<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(!$event->seo_enable)
        <meta name="robots" content="noindex">
    @endif
    <title>@lang('Upsell')</title>
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
        <div class="row">
            <div class="col-md-6 upsell-cover-content">
                <img src="{{ asset('storage/' . $upsell->image) }}" style="width: 100%"/>
            </div>
            <div class="col-md-6 upsell-content">
                <h3 class="upsell-title">{{ $upsell->title }}</h3>
                <div class="upsell-description">{!! $upsell->description !!}</div>
                <form action="" method="POST" style="width: 100%; display: flex; justify-content: center; align-items: center">
                    @csrf
                    <input type="hidden" name="upsell_id" value="{{ $upsell->id }}"/>
                    <input type="hidden" name="guest_id" value="{{ $guest->id }}"/>
                    @php $prices = $upsell->getPrices(); @endphp
                    <div class="d-flex mb-2 align-items-center justify-content-center" style="flex: 1">
                        @foreach ($prices as $price)
                            <button type="button" class="btn btn-block btn-primary purchase-btn" data-price="{{ $price }}">${{$price}}</button>
                        @endforeach
                    </div>
                </form>
                <a class="btn btn-link checkout-btn" href="{{ route('events.public.checkout', ['guest_code' => $guest->guest_code]) }}">No thanks, I'd rather not take advantage of this special offer.</a>
            </div>
        </div>
    </div>
</body>
<style>
    .container {
        display: flex;
        min-height: 100vh;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .upsell-cover-content, .upsell-content {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .upsell-content > .upsell-title {
        text-align: center;
    }
    .upsell-content > .upsell-description {
        padding-top: 12px;
        border-top: 1px solid #cccccc;
        border-bottom: 1px solid #cccccc;
        margin-bottom: 15px;
    }
    .purchase-btn {
        margin-left: 10px;
        margin-right: 10px;
        margin-top: 0 !important;
    }
    .checkout-btn {
        max-width: 65%;
    }
</style>
<script>
    var BASE_URL = "{{ url('/') }}";
    window._orderLink = "{{ url('/')."/e/submit-checkout/".$guest->guest_code }}";
    window._token = "{{ csrf_token() }}";
    var guestCode = "{{ $guest->guest_code }}";
    $(document).ready(function() {
        $(".purchase-btn").click(function() {
            var upsellId = $("[name='upsell_id']").val();
            var price = $(this).data("price");
            location.href = BASE_URL + "/e/upsell/" + guestCode + "/" + upsellId + "/" + price;
        });
    });
</script>
</html>