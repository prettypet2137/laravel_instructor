<?php

namespace Modules\Saas\Http\Controllers\Payment;

use Modules\Saas\Entities\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Price as StripePrice;
use Stripe\Product as StripeProduct;
use Stripe\Stripe as StripeGateway;
use Stripe\Subscription as StripeSubscription;
use Stripe\Webhook as StripeWebhook;
use Illuminate\Routing\Controller;

class Stripe
{
    public function gateway_purchase(Request $request, Payment $payment)
    {
        // Set API key

        StripeGateway::setApiKey(config('services.stripe.secret'));

        try {

            // Create a product
            $stripe_product = StripeProduct::create([
                'name'        => config('app.name'),
                'type'        => 'service',
                'description' => 'Subscription for Package: ' . $payment->package->title,
            ]);

            // Create a price for a product
            $stripe_price = StripePrice::create([
                'unit_amount' => $payment->package->price_in_cents,
                'currency'    => strtolower(config('app.CURRENCY_CODE')),
                'recurring'   => [
                    'interval' => $payment->package->interval,
                ],
                'product'     => $stripe_product->id,
            ]);

            // Initialize a session
            $stripe_session_options = [
                'payment_method_types' => [
                    'card',
                ],
                'line_items'           => [[
                    'price'    => $stripe_price->id,
                    'quantity' => 1,
                ]],
                'customer_email'       => $payment->user->email,
                'client_reference_id'  => $payment->id,
                'mode'                 => 'subscription',
                'success_url'          => route('gateway.return', $payment),
                'cancel_url'           => route('gateway.cancel', $payment),
            ];


            $stripe_session = StripeSession::create($stripe_session_options);

            $payment->options = [
                'stripe_product_id' => $stripe_product->id,
                'stripe_price_id'   => $stripe_price->id,
                'stripe_session_id' => $stripe_session->id,
            ];

            $payment->save();

            return view('saas::billing.stripe', compact(
                'stripe_session'
            ));

        } catch (\Exception $e) {

            Log::error('Something went wrong: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine());

            return redirect()->route('billing.package', $payment->package)
                ->with('error', $e->getMessage());
        }
    }

    public function gateway_return(Request $request, Payment $payment)
    {
        // Set API key
        StripeGateway::setApiKey(config('services.stripe.secret'));

        try {

            $stripe_session = StripeSession::retrieve($payment->options['stripe_session_id']);

            $stripe_subscription = StripeSubscription::retrieve($stripe_session->subscription);

            // Payment was successful
            if (in_array(strtolower($stripe_subscription->status), ['active', 'trialing'])) {

                $payment->reference = $stripe_subscription->id;
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
        // Set API key
        StripeGateway::setApiKey(config('services.stripe.secret'));

        $event = null;

        try {

            $event = StripeWebhook::constructEvent(
                $request->getContent(),
                $request->server('HTTP_STRIPE_SIGNATURE'),
                config('services.stripe.webhook.secret')
            );

        } catch (\UnexpectedValueException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid payload',
            ], 400);

        } catch (SignatureVerificationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Invalid signature',
            ], 400);

        }

        try {

            // Handle the event
            if ($event->type == 'invoice.payment_succeeded') {

                $stripe_subscription = StripeSubscription::retrieve($event->data->object->subscription);

                // Payment was successful
                if (in_array(strtolower($stripe_subscription->status), ['active', 'trialing'])) {

                    $__payment = Payment::where('gateway', 'stripe')
                        ->where('reference', $stripe_subscription->id)
                        ->first();

                    if ($__payment) {

                        $payment            = $__payment->replicate();
                        $payment->reference = $stripe_subscription->id;
                        $payment->is_paid   = true;
                        $payment->save();

                        // Update subscription
                        $payment->applyPayment();

                        return response()->json([
                            'success' => true,
                            'message' => 'Subscription extended',
                        ], 200);
                    }

                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Unexpected event type',
            ], 200);

        } catch (\Exception $e) {

            Log::error('Something went wrong: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine(),
            ], 400);

        }

    }

    public function gateway_cancel(Request $request, Payment $payment)
    {
        // Set API key
        StripeGateway::setApiKey(config('services.stripe.secret'));

        try {

            $stripe_subscription = StripeSubscription::retrieve($payment->reference);
            $stripe_subscription->cancel();

            return true;

        } catch (\Exception $e) {

            Log::error('Something went wrong: ' . $e->getMessage() . ' in file: ' . $e->getFile() . ' on line: ' . $e->getLine());

        }

        return false;
    }

    public function gateway_recurring_charge(Payment $payment)
    {

    }
}
