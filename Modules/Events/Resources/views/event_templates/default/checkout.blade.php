<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(!$event->seo_enable)
        <meta name="robots" content="noindex">
    @endif
    <title>@lang('Checkout') @if(!empty($event->seo_title)) {{$event->seo_title}} @else {{$event->name}} @endif</title>
    <meta name="description" content="{{$event->seo_description}}">
    <meta name="keywords" content="{{$event->seo_keywords}}">
    <!-- Apple Stuff -->
    <link rel="apple-touch-icon" href="{{ config('app.url') }}/storage/{{ $event->favicon }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Title">
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="{{$event->seo_title}}">
    <meta itemprop="description" content="{{$event->seo_description}}">
    <meta itemprop="image" content="@if($event->social_image){{ config('app.url') }}/storage/{{ $event->social_image }}@endif">
    <!-- Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{$event->social_title}}">
    <meta property="og:description" content="{{$event->social_description}}">
    <meta property="og:image" content="@if($event->social_image){{ config('app.url') }}/storage/{{ $event->social_image }}@endif">
    <meta property="og:url" content="{{ $publishUrl }}">
    
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$event->social_title}}">
    <meta name="twitter:description" content="{{$event->social_description}}">
    <meta name="twitter:image" content="@if($event->social_image){{ config('app.url') }}/storage/{{ $event->social_image }}@endif">
    @if($event->favicon)
    <link rel="icon" href="{{ config('app.url') }}/storage/{{ $event->favicon }}" type="image/png">
    @else
	<link rel="icon" href="{{ asset(config('app.logo_favicon'))}}" type="image/png">
    @endif
    <link rel="stylesheet" href="{{ asset('modules/events/event_templates/default/checkout.css') }}">
    <script src="{{ asset('modules/events/event_templates/default/checkout.js') }}"></script>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <div class="container">
        @php $upsell_items = json_decode(session()->get("upsell_items"), true); @endphp
        <div class="py-5 text-center">
            <h2>@lang('Checkout') - {{ $event->name }}</h2>
            <p class="lead">{{ $event->tagline }}</p>
        </div>
        <div class="row">
            <div class="col-md-6 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-5">
                    <span class="text-muted">@lang('Checkout Description')</span>
                </h4>
                <ul class="list-group mb-3 sticky-top">
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <h6 class="my-0">Ticket: {{ $guest->ticket_name }} <small class="text-muted">({{ $guest->ticket_name }})</small></h6>
                        <span class="text-muted">{{ $guest->ticket_price }} {{ $guest->ticket_currency }} &times {{ $guest->get_sub_guest_nums() + 1 }}</span>
                    </li>
                    @if (!is_null($upsell_items))
                        @foreach ($upsell_items as $upsell)
                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                <h6 class="my-0 product-name">Service & Product: {{ $upsell["upsell_title"] }}</h6>
                                <span class="text-muted">{{ $upsell["price"] }} USD</span>
                            </li>
                        @endforeach 
                    @endif
                    <li class="list-group-item d-flex justify-content-between">
                        <h6 class="my-0 product-name">@lang('Total')</h6>
                        @php 
                            $total_price = $guest->ticket_price * ($guest->get_sub_guest_nums() + 1); 
                            if (!is_null($upsell_items)) {
                                foreach ($upsell_items as $upsell) {
                                    $total_price +=   $upsell["price"];
                                }
                            }
                        @endphp
                        <span class="text-muted">{{ $total_price }} {{ $guest->ticket_currency }}</span>
                    </li>
                </ul>
            </div>
            <div class="col-md-6 order-md-1">
                <h4 class="mb-3">@lang('Ticket Recipient')</h4>
                <form id="form-checkout-event" class="needs-validation" novalidate="">
                    <input id="pay_type" name="payment_method" type="hidden" value="<?php echo getValueIfKeyIsset($user->settings, 'IS_PAYPAL') ? 'paypal' : 'stripe' ?>" />
                    <div class="mb-3">
                        <label for="username">@lang('Fullname')*</label>
                        <input type="text" name="fullname" value="{{ $guest->fullname }}" placeholder="@lang('Fullname')" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email">@lang('Email')*</label>
                        <input type="email" name="email" value="{{ $guest->email }}" placeholder="@lang('Email')" class="form-control" required>
                    </div>
                    <div class="d-block my-3">
                        <div id="smart-button-container">
                            <div style="text-align: center;">
                                <div id="paypal-button-container" <?php echo getValueIfKeyIsset($user->settings,'IS_PAYPAL') ? '' : 'style="display: none;"' ?> ></div>
                            </div>
                        </div>
{{--                        <div style="display:flex; align-items: center;justify-content: center">--}}
{{--                            <div style="flex: 1"><hr/></div>--}}
{{--                            <h5 style="margin-top: 0px; margin-bottom: 0px; padding-left: 10px; padding-right: 10px;">OR</h5>--}}
{{--                            <div style="flex: 1"><hr/></div>--}}
{{--                        </div>--}}
                        <div id="payment-element"></div>
                        <!--<div class="custom-control custom-radio custom-control-inline">-->
                        <!--    <input id="stripe" name="payment_method" value="stripe" type="radio" class="custom-control-input" checked="" required="">-->
                        <!--    <label class="custom-control-label" for="stripe">@lang('Stripe')</label>-->
                        <!--</div>-->
                        <!--<div class="custom-control custom-radio custom-control-inline">-->
                        <!--    <input id="paypal" name="payment_method" value="paypal" type="radio" class="custom-control-input" required="">-->
                        <!--    <label class="custom-control-label" for="paypal">@lang('PayPal')</label>-->
                        <!--</div>-->
                        @if(getValueIfKeyIsset($user->settings,'IS_STRIPE') || !getValueIfKeyIsset($user->settings,'IS_PAYPAL'))
                            <button id="submit" class="btn btn-success btn-lg btn-block" style="padding: 7px;" type="submit">@lang('Stripe')</button>
                        @endif
                    </div>
                    <!--<button class="btn btn-primary btn-lg btn-block" type="submit">@lang('Continue to checkout')</button>-->

                    <div id="payment-message" class="hidden"></div>
                </form>
            </div>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© {{ date('Y') }}</p>
        </footer>
    </div>
</body>
<style>
    .container {
        max-width: 960px;
    }
    .lh-condensed { line-height: 1.25; }
    .product-name {
        max-width: 330px;
        text-overflow: ellipsis;
        overflow: hidden;
        white-space: nowrap;
    }
</style>

<script>
    window._token = "{{ csrf_token() }}";
    window.baseUrl = "{{ url('/') }}";
    window._orderLink = "{{ url('/')."/e/submit-checkout/".$guest->guest_code }}";
    window._token = "{{ csrf_token() }}";
    var guest_code = "{{ $guest->guest_code }}";
    var guest_id = {{ $guest->id }};
</script>
<script src="https://www.paypal.com/sdk/js?client-id=AdvIuyb2J6OHxsO8WfHVhVHYVIZZsMYhxQ18U19m1RBiKLR8B2BAp44HPYb5naGQVYF9jEicTiXqMMlF&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
<script>
    var pay_type = $('#pay_type').val();

    var totalPrice = {{$total_price}};
    function initPayPalButton() {
        paypal.Buttons({
            style: {
                shape: 'rect',
                color: 'gold',
                layout: 'horizontal',
                label: 'paypal',
            },
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{"amount":{"currency_code":"USD","value":totalPrice}}]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(async function(orderData) {
                    // Full available details
                    console.log('Capture result', orderData);
                    var result = await $.ajax({
                        url: baseUrl + "/e/paypal/payment-intent/" + guest_id + "/return",
                        data: {
                            _token: _token,
                            orderData: orderData
                        }
                    });
                    if (result.success) {
                        window.location.href = result.url;
                    } else {
                        toastr.error(result.msg);
                    }
                });
            },
            onError: async function(err) {
                console.log(err);
                var result = await $.ajax({
                    url: baseUrl + "/e/paypal/payment-intent/" + guest_id + "/cancel"
                });
                window.location.href= result.url;
            }
        }).render('#paypal-button-container');
    }

    if (pay_type == 'paypal') {
        initPayPalButton();
    } else {


        const stripe = Stripe("pk_test_51LyDugD9UnFHOWqaJq4Qv8lNEeoxGna2GDX2i6AyWvtniiZiFOprj7UHYvetK10etR4a3tWlpaZl1RiOB4OvcTKq00ELpxBTjH");

        let elements;

        initialize();
        checkStatus();

        document
            .querySelector("#form-checkout-event")
            .addEventListener("submit", handleSubmit);

        // Fetches a payment intent and captures the client secret
        async function initialize() {
            const { clientSecret } = await fetch(baseUrl + "/e/stripe/payment-intent", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    amount: totalPrice,
                    _token: _token,
                    currency: "usd",
                    guestCode:  guest_code,
                }),
            }).then((r) => r.json());

            elements = stripe.elements({ clientSecret });

            const paymentElementOptions = {
                layout: "tabs",
            };

            const paymentElement = elements.create("payment", paymentElementOptions);
            paymentElement.mount("#payment-element");
        }

        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            const { error } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: window.location.href,
                },
            });

            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occurred.");
            }

            setLoading(false);
        }


        async function checkStatus() {
            const clientSecret = new URLSearchParams(window.location.search).get(
                "payment_intent_client_secret"
            );

            if (!clientSecret) {
                return;
            }

            const { paymentIntent } = await stripe.retrievePaymentIntent(clientSecret);

            switch (paymentIntent.status) {
                case "succeeded":
                    showMessage("Payment succeeded!");
                    var result = await $.ajax({
                        url: baseUrl + "/e/stripe/payment-intent/" + guest_id + "/return",
                        data: {
                            _token: _token,
                            paymentIntent: paymentIntent
                        }
                    });
                    if (result.success) {
                        window.location.href = result.url;
                    } else {
                        toastr.error(result.msg);
                    }
                    break;
                case "processing":
                    showMessage("Your payment is processing.");
                    break;
                case "requires_payment_method":
                    showMessage("Your payment was not successful, please try again.");
                    var result = await $.ajax({
                        url: baseUrl + "/e/stripe/payment-intent/" + guest_id + "/cancel",
                    });
                    window.location.href= result.url;
                    break;
                default:
                    showMessage("Something went wrong.");
                    break;
            }
        }
    }

    // ------- UI helpers -------

    function showMessage(messageText) {
    const messageContainer = document.querySelector("#payment-message");

    messageContainer.classList.remove("hidden");
    messageContainer.textContent = messageText;

    setTimeout(function () {
        messageContainer.classList.add("hidden");
        messageText.textContent = "";
    }, 4000);
    }

    // Show a spinner on payment submission
    function setLoading(isLoading) {
    if (isLoading) {
        // Disable the button and show a spinner
        document.querySelector("#submit").disabled = true;
        document.querySelector("#spinner").classList.remove("hidden");
        document.querySelector("#button-text").classList.add("hidden");
    } else {
        document.querySelector("#submit").disabled = false;
        document.querySelector("#spinner").classList.add("hidden");
        document.querySelector("#button-text").classList.remove("hidden");
    }
    }
</script>
<script>
// (function () {
//     'use strict'
//     const functionFormPaymentSubmit = function() {
//
//         var form = $(this);
//         var btn = form.find("button[type=submit]:focus" );
//
//         // var payment_method = form.find("[name='payment_method']:checked").val();
//         var payment_method = $("#pay_type").val();
//
//         var list_payment_method = ['stripe','paypal','bank_transfer'];
//
//         var check_payment_method = list_payment_method.includes(payment_method);
//         if (!check_payment_method) {
//             alert('Not found payment method please select a payment method');
//             return false;
//         }
//         var values = form.serialize();
//
//         values += `&_token=${window._token}`;
//
//         var url = window._orderLink.trim();
//         $.ajax({
//             url: url,
//             type: 'POST',
//             async: false,
//             data: values,
//             beforeSend: function() {
//                 btn.attr("disabled", true);
//                 btn.after('<smal id="loading-ajax-small">Loading...</small>');
//             },
//             success: function(data) {
//                 if($.isEmptyObject(data.error)) {
//
//                     console.log(payment_method);
//
//                     switch (payment_method) {
//                         case 'stripe':
//                             var stripe = Stripe(`${data.stripe_key}`);
//                             stripe.redirectToCheckout({
//                                 sessionId: `${data.stripe_session_id}`
//                             }).then(function (result) {
//                                 alert(result.error.message);
//                                 document.location = `${data.cancel_url}`;
//                             });
//                             break;
//                         case 'paypal':
//                             if (data.redirect_url) {
//                                 window.location.href = data.redirect_url;
//                             }
//                         default:
//                             if (data.redirect_url) {
//                                 window.location.href = data.redirect_url;
//                             }
//                             break;
//                     }
//                 }else{
//                     alert(data.error);
//                     btn.removeAttr("disabled");
//                     $('#loading-ajax-small').remove();
//                 }
//                 btn.removeAttr("disabled");
//                 $('#loading-ajax-small').remove();
//             },
//             error: function(xhr, ajaxOptions, thrownError) {
//                 btn.removeAttr("disabled");
//                 $('#loading-ajax-small').remove();
//                 console.log(xhr);
//             }
//         });
//         btn.removeAttr("disabled");
//         $('#loading-ajax-small').remove();
//         return false;
//
//     };
//     $('form#form-checkout-event').on('submit', functionFormPaymentSubmit);
// }())
</script>
</html>