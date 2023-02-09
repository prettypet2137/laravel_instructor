<?php

namespace Modules\Saas\Http\Controllers;
use Modules\Saas\Entities\Package;
use Modules\Saas\Entities\Payment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class BillingController extends Controller
{
    public function listPackages(Request $request)
    {
        $packages = Package::active()->get();

        $currency_symbol         = config('app.CURRENCY_SYMBOL');
        $currency_code   = config('app.CURRENCY_CODE');
        $user            = $request->user();
        
        return view('saas::billing.packages', compact(
            'packages',
            'currency_code',
            'currency_symbol',
            'user'
        ));
    }
   

    public function index(Request $request)
    {
        $user                    = $request->user();
        $packages                = Package::active()->get();
        $subscribed              = $user->subscribed();
        $currency_code           = config('app.CURRENCY_CODE');
        $currency_symbol         = config('app.CURRENCY_SYMBOL');
        $subscription_title      = null;
        $subscription_expires_in = 0;

        if ($subscribed) {
            $subscription_title      = $user->package->title;
            $subscription_expires_in = $user->package_ends_at->diffInDays();
        }

        return view('saas::billing.index', compact(
            'packages',
            'subscribed',
            'currency_code',
            'currency_symbol',
            'subscription_title',
            'subscription_expires_in',
            'user'
        ));
    }

    public function package(Request $request, Package $package)
    {
        $user            = $request->user();
        $currency_code   = config('app.CURRENCY_CODE');
        $currency_symbol = config('app.CURRENCY_SYMBOL');

        return view('saas::billing.package', compact(
            'package',
            'currency_code',
            'currency_symbol',
            'user'
        ));
    }

    public function gateway_purchase(Request $request, Package $package, $gateway)
    {
        // Create a payment
        $payment = Payment::create([
            'user_id'    => $request->user()->id,
            'package_id' => $package->id,
            'gateway'    => $gateway,
            'total'      => $package->price,
            'is_paid'    => false,
            'currency'   => config('app.CURRENCY_CODE'),
        ]);

        $payments_gateway = getPaymentsvailable();
        
        $gateway_use = "";

        foreach ($payments_gateway as $item) {

            if ($payment->gateway == $item['gateway_name']) {
                $gateway_use = $item;
            }
        }
        if (!empty($gateway_use) && class_exists($gateway_use['class_payment_name'])) {

            return (new $gateway_use['class_payment_name'])->gateway_purchase($request, $payment);
        }
        
        return redirect()->route('billing.package', $package)
                    ->with('error', __('Unsupported payment gateway'));

    }

    public function gateway_return(Request $request, Payment $payment)
    {
        $payments_gateway = getPaymentsvailable();

        $gateway_use = "";

        foreach ($payments_gateway as $item) {

            if ($payment->gateway == $item['gateway_name']) {
                $gateway_use = $item;
            }
        }

        if (!empty($gateway_use) && class_exists($gateway_use['class_payment_name'])) {

            return (new $gateway_use['class_payment_name'])->gateway_return($request, $payment);
        }

        return redirect()->route('billing.package', $payment->package)
                    ->with('error', __('Unsupported payment gateway'));


    }

    public function gateway_cancel(Request $request, Payment $payment)
    {
        return redirect()->route('billing.index')
            ->with('error', __('You have cancelled your recent payment.'));

    }

    public function gateway_notify(Request $request, $gateway)
    {
        $payments_gateway = getPaymentsvailable();

        $gateway_use = "";

        foreach ($payments_gateway as $item) {

            if ($gateway == $item['gateway_name']) {
                $gateway_use = $item;
            }
        }

        if (!empty($gateway_use) && class_exists($gateway_use['class_payment_name'])) {

            return (new $gateway_use['class_payment_name'])->gateway_notify($request);
        }

        return redirect()->route('billing.index')
                    ->with('error', __('Unsupported payment gateway'));

    }

    public function cancel(Request $request)
    {
        $user = $request->user();

        $user->update([
            'package_id'      => null,
            'package_ends_at' => null,
        ]);

        $payments_gateway = getPaymentsvailable();
        // Cancel all subscriptions
        $user->payments()->paid()->each(function ($payment) use ($request,$payments_gateway) {

            $gateway_use = "";

            foreach ($payments_gateway as $item) {

                if ($payment->gateway == $item['gateway_name']) {
                    $gateway_use = $item;
                }
            }

            if (!empty($gateway_use) && class_exists($gateway_use['class_payment_name'])) {

                return (new $gateway_use['class_payment_name'])->gateway_cancel($request, $payment);
            }

        });

        return redirect()->route('billing.index')
            ->with('success', __('You have cancelled your subscription.'));
    }

    public function payments(Request $request, Payment $payment)
    {
        
            $data = Payment::with([
                'user',
                'package',
            ])
            ->where(function ($q) use ($request) {
                if ($request->filled('is_paid')) {
                    $q->where('is_paid', $request->is_paid);
                }
            })
            ->orderByDesc('id')
            ->paginate(10);

        return view('saas::billing.payments', compact(
            'data'
        ));
    }
}
