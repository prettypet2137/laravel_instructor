@extends('themes::default.layout')
@section('content')

<!-- Header -->
<header class="ex-header">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">@lang('Get in touch')</h1>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of ex-header -->
<!-- end of header -->

  
    <!-- Basic -->
    <div class="ex-form-1 pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    
                    
                    <div class="text-box mt-5 mb-5">
                        <p class="mb-4">@lang('If you have any questions or need help, please fill out the form below. We do our best to response within 1 business day')</p>
                        <form id="" method="POST" action="{{ route('contacts.save') }}">
                            @csrf
                            <div class="form-group">
                                <input type="text" name="fullname" class="form-control-input" placeholder="@lang('Name')" value="{{ old('fullname', '') }}" required />
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" class="form-control-input" placeholder="@lang('Email')" value="{{ old('email', '') }}" required />
                            </div>
                            <div class="form-group">
                                <input type="number" name="phone" placeholder="@lang('Phone')" class="form-control-input" value="{{ old('phone', '') }}" required />
                            </div>
                            <div class="form-group">
                                <input type="text" name="subject" placeholder="@lang('Subject')" class="form-control-input" value="{{ old('subject', '') }}" required />
                            </div>
                            <div class="form-group">
                                <textarea name="content" class="form-control-input" placeholder="@lang('Content')" rows="4" required>{{ old('content', '') }}</textarea>
                            </div>
                            @if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
                                <div class="form-group">
                                {!! htmlFormSnippet() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                <div class="text-red mt-1">
                                    <small><strong>{{ $errors->first('g-recaptcha-response') }}</strong></small>
                                </div>
                                @endif
                                </div>
                            @endif
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="form-group">
                                <button type="submit" class="form-control-submit-button">@lang('Send')</button>
                            </div>
                        </form>

                    </div> <!-- end of text-box -->
                </div> <!-- end of col -->
            </div> <!-- end of row -->
        </div> <!-- end of container -->
    </div> <!-- end of ex-basic-1 -->
    <!-- end of basic -->


@stop

@if(config('recaptcha.api_site_key') && config('recaptcha.api_secret_key'))
    @push('head')
        {!! htmlScriptTagJsApi() !!}
    @endpush
@endif
