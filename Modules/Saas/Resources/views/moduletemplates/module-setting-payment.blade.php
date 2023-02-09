<div class="row">
    <div class="col-md-6">
        <h4 class="mb-4">@lang('Paypal')</h4>
        <div class="form-group">
            <label class="form-label">@lang('Environment')</label>
            <select name="PAYPAL_SANDBOX" class="form-control">
                <option value="0" {{ config('services.paypal.sandbox') == false ? 'selected' : '' }}>@lang('Live')</option>
                <option value="1" {{ config('services.paypal.sandbox') == true ? 'selected' : '' }}>@lang('Sandbox')</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Client ID')</label>
            <input type="text" name="PAYPAL_CLIENT_ID" value="{{ config('services.paypal.client_id') }}" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Secret')</label>
            <input type="text" name="PAYPAL_SECRET" value="{{ config('services.paypal.secret') }}" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-4">
            <img src="{{ asset('img/paypal.svg') }}" height="60" alt="Visa">
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-6">
        <h4 class="mb-4">@lang('Stripe')</h4>
        <div class="form-group">
            <label class="form-label">@lang('Publishable key')</label>
            <input type="text" name="STRIPE_KEY" value="{{ config('services.stripe.key') }}" class="form-control" placeholder="pk_XXX">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Secret key')</label>
            <input type="text" name="STRIPE_SECRET" value="{{ config('services.stripe.secret') }}" class="form-control">
        </div>
        <div class="form-group">
            <label class="form-label">@lang('Webhook secret')</label>
            <input type="text" name="STRIPE_WEBHOOK_SECRET" value="{{ config('services.stripe.webhook.secret') }}" class="form-control">
        </div>
    </div>
    <div class="col-md-6">
        <div class="mb-4">
            <img src="{{ asset('img/mastercard.svg') }}" class="mb-2" height="60" alt="MasterCard">
            <img src="{{ asset('img/visa.svg') }}" height="60" alt="Visa">
        </div>
        <p>@lang('Webhook secret:') <a href="{{ route('gateway.notify', 'stripe') }}" target="_blank">{{ route('gateway.notify', 'stripe') }}</a></p>
    </div>
</div>