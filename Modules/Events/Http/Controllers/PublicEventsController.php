<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Nwidart\Modules\Facades\Module;
use Modules\Events\Entities\AboutUser;
use Modules\Events\Entities\EventCategory;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\Events\Entities\SubGuest;
use Modules\Events\Http\Requests\PublicRegisterRequest;
use Modules\Events\Http\Controllers\Payment\PayPal;
use Modules\Events\Http\Controllers\Payment\Stripe;
use Modules\Events\Jobs\PaymentNotCompleted;
use Modules\Events\Jobs\GuestGreetingJob;
use Modules\Tracklink\Entities\Tracklink;
use Modules\User\Entities\User;
use Modules\Upsell\Entities\Upsell;
use Modules\Events\Entities\UpsellHistory;

class PublicEventsController extends Controller
{
    public function index($name)
    {
        $user = User::whereRaw('TRIM(LOWER(name)) = ? ',trim(strtolower(str_replace('-', ' ', $name))))->firstOrFail();
        $events = Event::withCount('guests')->where('user_id', $user->id)->where('is_listing', 1)->orderBy("start_date", "asc")->take(10)->get();
        if (count($events) > 0) {
            foreach ($events as $event) {
                $total_sub_guests_nums = 0;
                foreach ($event->guests as $guest) {
                    $total_sub_guests_nums += $guest->get_sub_guest_nums();
                }
                $event['available_seats'] = ($event->quantity == -1) ? 'unlimited' : ($event->quantity - ($event->guests_count + $total_sub_guests_nums));
            }
        }

        $about = AboutUser::where('user_id', $user->id)->first();
        if (!empty($about)) {
            $about['description'] = unserialize($about['description']);
        }
        $company = $user->company ?? 'Your Company Name Here';
        return view('events::events.event-landing', compact('events', 'company', 'about', 'user'));
    }
    
    public function category_view($name, $category_id) {
        $user = User::whereRaw('TRIM(LOWER(name)) = ? ',trim(strtolower(str_replace('-', ' ', $name))))->firstOrFail();
        $events = Event::withCount('guests')->where('user_id', $user->id)->where("category_id", $category_id)->where('is_listing', 1)->latest()->take(10)->get();
        if (count($events) > 0) {
            foreach ($events as $event) {
                $total_sub_guests_nums = 0;
                foreach ($event->guests as $guest) {
                    $total_sub_guests_nums += $guest->get_sub_guest_nums();
                }
                $event['available_seats'] = ($event->quantity == -1) ? 'unlimited' : ($event->quantity - ($event->guests_count + $total_sub_guests_nums));
            }
        }
        $about = AboutUser::where('user_id', $user->id)->first();
        if (!empty($about)) {
            $about['description'] = unserialize($about['description']);
        }
        $category = EventCategory::find($category_id);
        $company = $category->name;
        return view("events::events.event-category-landing", compact("events", 'company', 'about', 'user'));
    }

    public function show(Request $request, $name, $slug)
    {
        $event = Event::with('user')->withCount('guests')->where('short_slug', '=', $slug)->firstOrFail();
        $total_sub_guests_nums = 0;
        foreach ($event->guests as $guest) {
            $total_sub_guests_nums += $guest->get_sub_guest_nums();
        }
        $event['available_seats'] = ($event->quantity == -1) ? 'unlimited' : ($event->quantity - ($event->guests_count + $total_sub_guests_nums));
        $event->guests_count += $total_sub_guests_nums;
        $allowRemoveBrand = true;
        if (Module::find('Saas')) {
            $user = User::findOrFail($event->user_id);
            $allowRemoveBrand = $user->allowRemoveBrand();
        }
        $name = $event->user->name;
        $publishUrl = $event->getPublicUrl($name);
        $eventRegistrationExpired = $event->eventRegistrationExpired();
        $eventExpired = $event->eventExpired();

        Tracklink::save_from_request($request, Event::class, $event->id);
        return view('events::event_templates.' . $event->theme . '.main', [
            'event' => $event,
            'allowRemoveBrand' => $allowRemoveBrand,
            'publishUrl' => $publishUrl,
            'eventRegistrationExpired' => $eventRegistrationExpired,
            'eventExpired' => $eventExpired
        ]);
    }

    public function register(PublicRegisterRequest $request, $slug)
    {
        $data = $request->except(["_token"]);
        $event = Event::where('short_slug', '=', $slug)->firstOrFail();

        $info_items = $event->info_items;

        if (count($info_items) > 0) {
            $info_items['submit'] = [];
            for ($i = 0; $i < count($info_items['name']); $i++) {
                $submit = null;
                if (isset($data['info_item_' . $i])) {
                    $submit = $data['info_item_' . $i];
                }
                array_push($info_items['submit'], $submit);
            }
        }

        $ticket_detail = [null, null];
        $has_tickets = false;
        if (isset($data['ticket']) && !empty($data['ticket'])) {
            $has_tickets = true;
            $ticket_detail = explode(";", $data['ticket']);
        }
        $guest = Guest::create([
            'user_id' => $event->user_id,
            'event_id' => $event->id,
            'fullname' => $data['fullname'][0],
            'email' => $data['email'][0],
            'birthday' => $data['birthday'][0],
            'phone' => "1" . implode("", explode("-", $data["phone"][0])),
            'info_items' => $info_items,
            'ticket_name' => $ticket_detail[0],
            'ticket_price' => $ticket_detail[1],
            'ticket_currency' => $event->ticket_currency,
        ]);
        for($i = 1; $i < count($data["fullname"]); $i++) {
            SubGuest::create([
                "guest_id" => $guest->id,
                "fullname" => $data["fullname"][$i],
                "email" => $data["email"][$i],
                "birthday" => $data["birthday"][$i],
                "phone" => "1" . implode("", explode("-", $data["phone"][$i]))
            ]);
        }
        PaymentNotCompleted::dispatch($event, $guest)->delay(now()->addMinutes(5))->onQueue("guests_emails");
        // redirect to checkout
        if ($has_tickets) {
            session()->forget("upsells");
            
            $upsellIds = $event->upsells;
            if ($upsellIds && !empty($upsellIds)) {
                session()->put("upsell_items", json_encode([]));
                return redirect()->route('events.public.upsell.index', ['guest_code' => $guest->guest_code, 'upsell_id' => $upsellIds[0]]);
            } else {
                return redirect()->route('events.public.checkout', ['guest_code' => $guest->guest_code]);
            }
        } else {
            GuestGreetingJob::dispatch($event, $guest)->onQueue("guests_emails");
            return redirect()->back()->with('success', $event->noti_register_success);
        }


    }

    public function upsell(Request $reuqest, $guest_code, $upsell_id) {
        $guest = Guest::where([
            "guest_code" => $guest_code
        ])->firstOrFail();
        $event = Event::findOrFail($guest->event_id);
        $upsell = Upsell::find($upsell_id);
        return view('events::event_templates.' . $event->theme . '.upsell', [
            "event" => $event,
            "guest" => $guest,
            "upsell" => $upsell
        ]);
    }

    public function upsellStore(Request $request, $guest_code, $upsell_id, $price) {
        $guest = Guest::where([
            "guest_code" => $guest_code
        ])->firstOrFail();
        $event = Event::findOrFail($guest->event_id);
        $upsell = Upsell::find($upsell_id);
        $upsellIds = $event->upsells;
        
        $idx = array_search($upsell->id, $upsellIds);
        $upsell_items = json_decode(session()->get("upsell_items"), true);
        if ($idx != count($upsell_items)) array_splice($upsell_items, $idx, count($upsell_items));
        array_push($upsell_items, [
            "upsell_id" => $upsell_id,
            "upsell_title" => $upsell->title,
            "price" => $price
        ]);
        session()->put("upsell_items", json_encode($upsell_items));
        if (isset($upsellIds[count($upsell_items)])) {
            return redirect()->route('events.public.upsell.index', ['guest_code' => $guest->guest_code, 'upsell_id' => $upsellIds[count($upsell_items)]]);
        } else {
            return redirect()->route("events.public.checkout", ["guest_code" => $guest->guest_code]);
        }
    }
    public function checkout(Request $request, $guest_code)
    {
        $guest = Guest::where([
            ['guest_code', '=', $guest_code]
        ])->firstOrFail();
        $event = Event::findOrFail($guest->event_id);
        $allowRemoveBrand = true;
        if (Module::find('Saas')) {
            $user = User::findOrFail($event->user_id);
            $allowRemoveBrand = $user->allowRemoveBrand();
        }
        return view('events::event_templates.' . $event->theme . '.checkout', [
            'user' => $request->user(),
            'event' => $event,
            'guest' => $guest,
            'allowRemoveBrand' => $allowRemoveBrand,
            'publishUrl' => $event->getPublicUrl(),
            'eventExpired' => $event->eventExpired()
        ]);
    }

    public function submitCheckout(Request $request, $guest_code)
    {
        $payment_method = "";
        if ($request->has('payment_method')) {
            $type = ['paypal', 'bank_transfer', 'stripe'];
            if (!in_array($request->payment_method, $type)) {
                return response()->json(['error' => __("Not found type payment")]);
            }
            $payment_method = $request->payment_method;
        } else {
            return response()->json(['error' => __("Not found payment method or type")]);
        }

        $guest = Guest::where([
            ['guest_code', '=', $guest_code]
        ])->firstOrFail();

        if (!$guest) {
            return response()->json(['error' => __("Not found guest")]);
        }

        $event = Event::find($guest->event_id);
        if (!$event) {
            return response()->json(['error' => __("Not found event")]);
        }

        $user = $event->user;
        // check exits key Payment
        if ($payment_method == 'paypal') {

            $paypal_keys = ['PAYPAL_CLIENT_ID', 'PAYPAL_SECRET'];
            $check_key_payment = checkIssetAndNotEmptyKeys($user->settings, $paypal_keys);
            if (!$check_key_payment) {
                return response()->json(['error' => __("You need config setting payment PayPal in /accountsettings")]);
            }
        }
        if ($payment_method == 'stripe') {

            $stripe_keys = ['STRIPE_KEY', 'STRIPE_SECRET'];
            $check_key_payment = checkIssetAndNotEmptyKeys($user->settings, $stripe_keys);
            if (!$check_key_payment) {
                return response()->json(['error' => __("You need config setting payment STRIPE in /accountsettings")]);
            }
        }
        // get field if exits form
        $fields_request = array_keys($request->all());

        $fields_expect = ['_token', 'payment_method'];
        foreach ($fields_expect as $item) {
            if (($item = array_search($item, $fields_request)) !== false) {
                unset($fields_request[$item]);
            }
        }

        $fields_request = array_unique($fields_request);
        $field_values = array();

        if (count($fields_request) > 0) {
            foreach ($fields_request as $key) {
                $field_values[$key] = $request->input($key);
            }
        }
        $data = $field_values;
        $data['gateway'] = $payment_method;
        $guest->update($data);
        switch ($payment_method) {
            case 'stripe':
                return (new Stripe)->gateway_purchase($request, $event, $guest);
                break;

            case 'paypal':
                return (new PayPal)->gateway_purchase($request, $event, $guest);
                break;

            case 'bank_transfer':
                $request->session()->flash('success', $event->noti_register_success);
                $data_return = [
                    'success' => $event->noti_register_success,
                    'redirect_url' => $event->getPublicUrl()
                ];
                GuestGreetingJob::dispatch($event, $guest)->onQueue("guests_emails");
                return response()->json($data_return);
                break;
            default:
                return response()->json(['error' => __("Unsupported payment gateway")]);
                break;
        }

    }
    
        public function paymentIntent(Request $request) {
        $guest_code = $request->input("guestCode");
        $guest = Guest::where([
            ['guest_code', '=', $guest_code]
        ])->firstOrFail();
        if (!$guest) {
            return response()->json(['error' => __("Not found guest")]);
        }
        $event = Event::find($guest->event_id);
        if (!$event) {
            return response()->json(['error' => __("Not found event")]);
        }
        $user = $event->user;
        $stripe_keys = ['STRIPE_KEY', 'STRIPE_SECRET'];
        $check_key_payment = checkIssetAndNotEmptyKeys($user->settings, $stripe_keys);
        if (!$check_key_payment) {
            return response()->json(['error' => __('You need config setting payment STRIPE in /accountsettings')]);
        }

        $result = (new Stripe)->payment_intent_create($request, $event, $guest);
        return response()->json($result);
    }

    public function paymentIntentReturn(Request $request, $guest_id) {
        try {
            $guest = Guest::find($guest_id);
            $event = Event::find($guest->event_id);
            $paymentIntent = $request->paymentIntent;
            $guest->reference = $paymentIntent['id'];
            $guest->is_paid = true;
            $guest->save();
            if (session()->has("upsell_items")) {
                $upsell_items = json_decode(session()->get("upsell_items"), true);
                if (!is_null($upsell_items) && count($upsell_items) > 0) {
                    foreach ($upsell_items as $upsell_item) {
                        UpsellHistory::create([
                            "event_id" => $event->id,
                            "guest_id" => $guest->id,
                            "upsell_id" => $upsell_item["upsell_id"],
                            "price" => $upsell_item["price"]
                        ]);
                    }
                }
                session()->forget("upsell_items");
            }
            GuestGreetingJob::dispatch($event, $guest)->onQueue("guests_emails"); //send mail
            
            $request->session()->flash('success', $event->noti_register_success);
    
            return response([
                'success' => true,
                'url' => $event->getPublicUrl()
            ]);
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function paymentIntentCancel(Request $request, $guest_id) {
        $guest = Guest::find($guest_id);
        return response()->json(["url" => $guest->getCheckoutUrl()]);
    }

    public function paymentOrderReturn (Request $request, $guest_id) {
        $guest = Guest::find($guest_id);
        $event = Event::find($guest->event_id);
        $orderData = $request->orderData;
        $guest->reference = $orderData['id'];
        $guest->is_paid = true;
        $guest->save();
        if (session()->has("upsell_items")) {
            $upsell_items = json_decode(session()->get("upsell_items"), true);
            if (!is_null($upsell_items) && count($upsell_items) > 0) {
                foreach ($upsell_items as $upsell_item) {
                    UpsellHistory::create([
                        "event_id" => $event->id,
                        "guest_id" => $guest->id,
                        "upsell_id" => $upsell_item["upsell_id"],
                        "price" => $upsell_item["price"]
                    ]);
                }
            }
            session()->forget("upsell_items");
        }
        GuestGreetingJob::dispatch($event, $guest)->onQueue("guests_emails"); //send mail
        
        $request->session()->flash('success', $event->noti_register_success);

        return response([
            'success' => true,
            'url' => $event->getPublicUrl()
        ]);
    }

    public function paymentOrderCancel (Request $request, $guest_id) {
        $guest = Guest::find($guest_id);
        return response()->json(["url" => $guest->getCheckoutUrl()]);
    }

    public function gateway_return(Request $request, Event $event, Guest $guest)
    {
        switch ($guest->gateway) {

            case 'stripe':
                return (new Stripe)->gateway_return($request, $event, $guest);

                break;

            case 'paypal':

                return (new PayPal)->gateway_return($request, $event, $guest);

                break;
            default:
                return response()->json(['error' => __("Unsupported payment gateway")]);
                break;
        }

    }

    public function gateway_cancel(Request $request, Event $event, Guest $guest)
    {
        if ($event)
            return redirect()->to($guest->getCheckoutUrl());

        abort(404);
    }

    public function gateway_notify(Request $request, $gateway)
    {
        switch ($gateway) {

            case 'stripe':

                return (new Stripe)->gateway_notify($request);

                break;

            case 'paypal':

                return (new PayPal)->gateway_notify($request);

                break;

            default:

                return response()->json(['error' => __("Unsupported payment gateway")]);

                break;
        }
    }

    public function checkin(Request $request, $uuid)
    {
        $guest = Guest::where([
            ['user_id', '=', auth()->user()->id],
            ['guest_code', '=', $uuid]
        ])->first();

        if (!$guest) return redirect()->route('guests.index')->with('error', __('QR Code not exists!'));
        if ($guest->status == 'joined')
            return redirect()->route('guests.index')->with('error', $guest->email . " " . __('joined'));

        $guest->status = 'joined';
        $guest->save();
        return redirect()->route('guests.index')->with('success', $guest->email . " " . __('check-in success'));
    }

    public function calendar($name) {
        $user = User::where("name", trim(implode(" ", explode("-", $name))))->firstOrFail();
        $events = Event::withCount('guests')
            ->where('user_id', $user->id)
            ->where('is_listing', 1)
            ->latest()->take(10)->get();     
        if (count($events) > 0) {
            foreach ($events as $event) {
                $event['available_seats'] = ($event->quantity == -1) ? 'unlimited' : ($event->quantity - $event->guests_count);
            }
        }
        return view("events::events.event-calendar", ["events" => $events]);
    }
    
    public function getQrCode($qr_code_key) {
        $qr_code = Guest::where(["qr_code_key" => $qr_code_key])->first()->qr_code_image;
        $qr_code .= "<style>svg {width: 250px; height: 250px;}</style>";
        return response($qr_code);
    }
    
    public function terms($name, $slug) {
        $event = Event::where(["short_slug" => $slug])->first();
        return view("events::events.terms", ["event" => $event]);
    }
}
