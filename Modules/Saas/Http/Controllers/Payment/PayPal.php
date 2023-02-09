<?php

namespace Modules\Saas\Http\Controllers\Payment;

use Modules\Saas\Entities\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Omnipay\Omnipay;
use Illuminate\Routing\Controller;

class PayPal
{
    public function gateway_purchase(Request $request, Payment $payment)
    {
        $paypal = Omnipay::create('PayPal_Rest');

        $paypal->initialize([
            'clientId'  => config('services.paypal.client_id'),
            'secret'    => config('services.paypal.secret'),
            'testMode'  => config('services.paypal.sandbox'),
            'brandName' => config('app.name'),
        ]);

        try {

            // Send purchase request
            $response = $paypal->purchase([
                'transactionId' => $payment->id,
                'amount'        => $payment->total,
                'currency'      => $payment->currency,
                'description'   => $payment->package->title,
                'cancelUrl'     => route('gateway.cancel', $payment),
                'returnUrl'     => route('gateway.return', $payment),
                'notifyUrl'     => route('gateway.notify', $payment),
            ])->send();

            // Process response
            if ($response->isRedirect()) {

                // Redirect to offsite payment gateway
                return $response->redirect();

            } elseif ($response->isSuccessful()) {

                // Payment was successful
                $payment->reference = $response->getTransactionReference();
                $payment->is_paid   = true;
                $payment->save();

                // Update subscription
                $payment->applyPayment();

                return redirect()->route('billing.index')
                    ->with('success', __('Thank you for your payment! Your subscription is activated successfully.'));

            } else {

                // Payment failed
                return redirect()->route('billing.package', $payment->package)
                    ->with('error', $response->getMessage());

            }

        } catch (\Exception $e) {

            Log::error('Something went wrong: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine());

            return redirect()->route('billing.package', $payment->package)
                ->with('error', $e->getMessage());
        }
    }

    public function gateway_return(Request $request, Payment $payment)
    {

        $request->validate([
            'paymentId' => 'required',
            'PayerID'   => 'required',
        ]);

        $paypal = Omnipay::create('PayPal_Rest');

        $paypal->initialize([
            'clientId'  => config('services.paypal.client_id'),
            'secret'    => config('services.paypal.secret'),
            'testMode'  => config('services.paypal.sandbox'),
            'brandName' => config('app.name'),
        ]);

        try {

            // Complete purchase
            $response = $paypal->completePurchase([
                'transactionId'        => $payment->id,
                'payer_id'             => $request->PayerID,
                'transactionReference' => $request->paymentId,
                'amount'               => $payment->total,
                'currency'             => $payment->currency,
                'description'          => $payment->package->title,
                'cancelUrl'            => route('gateway.cancel', $payment),
                'returnUrl'            => route('gateway.return', $payment),
                'notifyUrl'            => route('gateway.notify', $payment),
            ])->send();

            // Process response
            if ($response->isSuccessful()) {

                // Payment was successful
                $payment->reference = $response->getTransactionReference();
                $payment->is_paid   = true;
                $payment->save();

                // Update subscription
                $payment->applyPayment();

                return redirect()->route('billing.index')
                    ->with('success', __('Thank you for your payment! Your subscription is activated successfully.'));
            } else {

                // Payment failed
                return redirect()->route('billing.package', $payment->package)
                    ->with('error', $response->getMessage());

            }

        } catch (\Exception $e) {

            Log::error('Something went wrong: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine());

            return redirect()->route('billing.package', $payment->package)
                ->with('error', $e->getMessage());
        }
    }

    public function gateway_notify(Request $request)
    {

    }

    public function gateway_cancel(Request $request, Payment $payment)
    {

    }

    public function gateway_recurring_charge(Payment $payment)
    {

    }
}
