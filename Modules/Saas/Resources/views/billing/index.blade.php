@extends('core::layouts.app')

@section('title', __('Billing'))

@section('content')
<div class="billing-container">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800">@lang('Billing')</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
        @if($subscribed)
            <div class="alert text-center alert-success">
               @lang('Your subscription for <strong>:package</strong> package is currently active and expires in <strong>:expires_in</strong> days!', ['package' => $subscription_title, 'expires_in' => $subscription_expires_in])
            </div>
        @endif
    
        @if(!$subscribed)
            <div class="alert text-center alert-danger">
               @lang("Your subscription has been ended. Please <a href=':url'>choose a plan</a> and pay",['url'=> url('pricing')]).</a>
            </div>
        @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        @if($subscribed)
            <div class="d-flex">
                <div class="p-2">
                    <a href="{{ url('pricing') }}" class="btn btn-sm btn-primary btn-clean">
                        <i class="fe fe-x-circle"></i> @lang('Upgrade package')
                    </a>
                </div>
                <div class="p-2 ml-auto">
                    <form action="{{ route('billing.cancel') }}" method="POST" onsubmit="return confirm('@lang('Confirm cancel subscription?')');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-secondary btn-clean">
                            <i class="fe fe-x-circle"></i> @lang('Cancel subscription') &ndash; {{ $subscription_title }}
                        </button>
                    </form>
                </div>
            </div>
        @else
        <div class="d-flex">
            <div class="">
                <a href="{{ url('pricing') }}" class="btn btn-sm btn-primary btn-clean">
                    <i class="fe fe-x-circle"></i> @lang('Upgrade package')
                </a>
            </div>
        </div>
        @endif
        </div>
    </div>
</div>
@endsection