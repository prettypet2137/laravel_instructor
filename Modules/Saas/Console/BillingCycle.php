<?php

namespace Modules\Saas\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Modules\Saas\Http\Controllers\Payment\PayPal as PayPalPayment;
use Modules\Saas\Http\Controllers\Payment\Stripe as StripePayment;
use Modules\User\Entities\User;

class BillingCycle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rb:billingcycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run charge command for non-automatic payment gateways';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::whereNotNull('package_ends_at')
            ->where('package_ends_at', '<=', now())
            ->get();
        $payments_gateway = getPaymentsvailable();

        foreach ($users as $user) {

            $user->payments()->paid()->each(function ($payment) use ($user,$payments_gateway) {

                $this->info('Charging user: ' . $user->name . ' for payment: ' . $payment->id);

                $gateway_use = "";

                foreach ($payments_gateway as $item) {

                    if ($payment->gateway == $item['gateway_name']) {
                        $gateway_use = $item;
                    }
                }

                if (!empty($gateway_use) && class_exists($gateway_use['class_payment_name'])) {

                    return (new $gateway_use['class_payment_name'])->gateway_recurring_charge($payment);
                }

            });

        }
    }
}
