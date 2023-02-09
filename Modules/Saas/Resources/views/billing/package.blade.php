@extends('core::layouts.app')
@section('title', $package->title)
@section('content')
    <section class="section-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title-box text-center">
                        <h3 class="title-heading mt-4">@lang('Upgrade to :title',['title'=> $package->title])</h3>
                    </div>
                </div>
            </div>
            <div class="row pt-4 justify-content-center">
                <div class="price_content">
                    <!-- END Title -->
                    <div class="row justify-content-center">
                        <div class="card card_billing">
                            <div class="card-header">
                                <h5 class="card-title">@lang('Total') {{ $currency_symbol }}{{ $package->price }}</h5>
                                <span class="f-16 text-muted">{{$package->interval_number}} @lang($package->interval)</span>
                            </div>
                            <div class="card-body">
                                {!! paymentSkins(['package' => $package]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop