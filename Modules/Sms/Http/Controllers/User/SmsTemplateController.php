<?php

namespace Modules\Sms\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Twilio\Rest\Client;
use Modules\User\Entities\User;
use Modules\Sms\Entities\SmsReminderTypes;
use Modules\Sms\Entities\SmsTemplate;
use Modules\Sms\Entities\SmsAccount;
use Modules\Sms\Entities\SmsHire;
use Stripe\Price as StripePrice;
use Stripe\Product as StripeProduct;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe as StripeGateway;
use Omnipay\Omnipay;

class SmsTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        $smsHire = SmsHire::where("is_active", 1)->first();
        $reminders = SmsReminderTypes::all();
        if ($user->sms_balance > $smsHire->amount) {
            $errors = [];
        } else {
            $errors = ["msg" => "You need to charge your SMS balance to use this feature."];
        }
        return view('sms::sms.user.templates.index', [
            "sms_hire" => $smsHire,
            "reminders" => $reminders
        ])->withErrors($errors);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('sms::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "subject" => "required",
            "description" => "required"
        ]);
        $data = $request->except("_token");
        SmsTemplate::create($data);
        return redirect()->route("sms.user.templates.index", ["tab" => $data["reminder_id"]]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $template = SmsTemplate::find($id);
        return response()->json($template);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('sms::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "subject" => "required",
            "description" => "required"
        ]);
        $data = $request->except(["_token", "_method"]);
        SmsTemplate::find($id)->update($data);
        return redirect()->route("sms.user.templates.index", ["tab" => $data["reminder_id"]]);
    }

    public function enableSms(Request $request) {
        $data = $request->except("_token");
        $user = auth()->user();
        if ($data["sms_status"]) {
            $user->update(["sms_status" => 1]);
            $hire = SmsHire::where("is_active", 1)->first();
            if ($user->sms_balance > $hire->amount) {
                $response = [
                    "message" => "You have enabled the SMS feature successfully. You can send SMS right now."
                ];
            } else {
                $response = [
                    "message" => "You have enabled the SMS feature successfully, however you need to charge a balance to send SMS."
                ];
            }
        } else {
            $user->update(["sms_status" => 0]);
            $response = [
                "message" => "You have disabled the SMS feature successfully."
            ];
        }
        return response()->json($response);
    }

    public function smsCheckout(Request $request) {
        $paymentMethod = "";
        if ($request->has("payment_method")) {
            $type = ["stripe", "paypal"];
            if (!in_array($request->payment_method, $type)) {
                return redirect()->route("sms.user.templates.index")->withErrors([
                    "msg" => "Not found type payment"
                ]);
            }
            $paymentMethod = $request->payment_method;
        } else {
            return redirect()->route("sms.user.templates.index")->withErrors([
                "msg" => "Not found payment method."
            ]);
        }
        $amount = SmsHire::where("is_active", 1)->first()->amount;
        
        if ($paymentMethod == "stripe") {
            StripeGateway::setApiKey(config("services.stripe.secret"));
            $stripeSession = StripeSession::create([
                "payment_method_types" => ["card"],
                "line_items" => [[
                    "price_data" => [
                        "currency" => "usd",
                        "product_data" => [
                            "name" => "SMS Service"
                        ],
                        "unit_amount" => $amount * 100,
                    ],
                    "quantity" => 1
                ]],
                "mode" => "payment",
                "success_url" => route("sms.user.templates.sms-checkout-success") . "?payment_method=stripe&session_id={CHECKOUT_SESSION_ID}",
                "cancel_url" => route("sms.user.templates.sms-checkout-cancel")
            ]);
            return redirect($stripeSession->url);
        } else if ($paymentMethod == "paypal") {
            $paypal = Omnipay::create('PayPal_Rest');
            $paypal->initialize([
                "clientId" => config("services.paypal.client_id"),
                "secret" => config("services.paypal.secret"),
                "testMode" => config("services.paypal.sandbox"),
                "brandName" => "InstructorsDash"
            ]);
            $response = $paypal->purchase([
                "amount" => $amount,
                "currency" => "usd",
                "description" => "SMS Service",
                "cancelUrl" => route('sms.user.templates.sms-checkout-cancel'),
                "returnUrl" => route("sms.user.templates.sms-checkout-success") . '?payment_method=paypal',
                "nofityUrl" => route('sms.user.templates.sms-checkout-notify')
            ])->send();
            if ($response->isRedirect()) {
                return redirect()->to($response->getRedirectUrl());
            } else {
                return redirect()->route("sms.user.templates.index")->withErrors([
                    "msg" => $response->getMessage()
                ]);
            }
        }
    }

    public function smsCheckoutSuccess(Request $request) {
        $paymentMethod = $request->payment_method;
        if ($paymentMethod == "stripe") {
            StripeGateway::setApiKey(config("services.stripe.secret"));
            $payment = StripeSession::retrieve($request->session_id);
            if ($payment->status == "complete") {
                $user = auth()->user();
                $amount = $user->sms_balance + $payment->amount_total / 100;
                User::find($user->id)->update(["sms_balance" => $amount]);                
            } 
        } else if ($paymentMethod == "paypal") {
            $paypal = Omnipay::create("PayPal_Rest");
            $paypal->initialize([
                "clientId" => config("services.paypal.client_id"),
                "secret" => config("services.paypal.secret"),
                "testMode" => config("services.paypal.sandbox"),
                "brandName" => "InstructorsDash"
            ]);
            $response = $paypal->completePurchase([
                "payer_id" => $request->PayerID,
                "transactionReference" => $request->paymentId,
                "cancelUrl" => route('sms.user.templates.sms-checkout-cancel'),
                "returnUrl" => route("sms.user.templates.sms-checkout-success") . '?payment_method=paypal',
                "nofityUrl" => route('sms.user.templates.sms-checkout-notify')
            ])->send();
            if ($response->isSuccessful()) {
                $data = $response->getData();
                $user = auth()->user();
                $amount = $user->sms_balance + $data["transactions"][0]["amount"]["total"];
                User::find($user->id)->update(["sms_balance" => $amount]);
            }
        }
        return redirect()->route("sms.user.templates.index");
    }

    public function smsCheckoutCancel(Request $request) {
        return redirect()->route("sms.user.templates.index")->withErrors([
            "msg" => "The payment charge operation was cancelled."
        ]);
    }
    public function testSms(Request $request) {
        try {
            $data = $request->except("_token");
            $receiverNumber = $data["receiver_number"];
            $template = SmsTemplate::find($data["template_id"]);
            $account = SmsAccount::first();
            $client = new Client($account->twilio_sid, $account->twilio_token);
            $client->messages->create($receiverNumber, [
                "from" => $account->twilio_number,
                "body" => $template->subject . "\n\r" . $template->description
            ]);
            return response()->json([
                "message" => "You sent SMS to " . $receiverNumber . " successfully."
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
