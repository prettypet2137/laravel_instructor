@if(isset($data['package']))
@if(config('services.stripe.key') && config('services.stripe.secret'))
<div class="row align-items-center">
    <div class="col-md-6 d-flex">
        <img src="{{ asset('img/visa.svg') }}" height="60" alt="Visa">
        <img src="{{ asset('img/mastercard.svg') }}" height="60" alt="MasterCard">
    </div>
    <div class="col-md-6">
        <form action="{{ route('gateway.purchase', [$data['package'], 'stripe']) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-block">
            @lang('Pay using card')
            </button>
        </form>
    </div>
</div>
<hr>
@endif
@if(config('services.paypal.client_id') && config('services.paypal.secret'))
<div class="row align-items-center">
    <div class="col-md-6">
        <img src="{{ asset('img/paypal.svg') }}" alt="PayPal">
    </div>
    <div class="col-md-6">
        <form action="{{ route('gateway.purchase', [$data['package'], 'paypal']) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary btn-block">
            @lang('Pay using PayPal')
            </button>
        </form>
    </div>
</div>
@endif
@endif