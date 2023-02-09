@extends('core::layouts.app')
@section('title', __('Account Settings'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Setting Account')</h1>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form role="form" method="post" action="{{ route('accountsettings.update') }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" href="#tab_profile" data-toggle="tab">
                                    @lang('Profile')
                                </a>
                            </li>
                            @php
                                $views_render = accountSettingPayments(['user' => $user]);
                            @endphp

                            @if(!empty($views_render))
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_payment_setting" data-toggle="tab">
                                        @lang('Payment Settings')
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a class="nav-link" href="#tab_about_us" data-toggle="tab">
                                    @lang('About Us')
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_profile">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Name')</label>
                                            <input type="text" name="name" value="{{ $user->name }}"
                                                   class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                                   placeholder="@lang('Full name')" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang('Company Name')</label>
                                            <input type="text" name="company" value="{{ $user->company ?? "" }}"
                                                   class="form-control {{ $errors->has('company') ? 'is-invalid' : '' }}"
                                                   placeholder="@lang('Company Name')">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang("E-mail")</label>
                                            <input type="email" value="{{ $user->email }}" class="form-control disabled"
                                                   placeholder="E-mail" disabled>
                                            <small class="help-block">@lang("E-mail can't be changed")</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Password')</label>
                                            <input type="password"
                                                autocomplete="false"
                                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                   name="password" placeholder="@lang('Password')">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang('Confirm password')</label>
                                            <input type="password"
                                                autocomplete="false"
                                                   class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                                   name="password_confirmation" placeholder="@lang('Confirm password')">
                                        </div>
                                        <div class="alert alert-info">
                                            @lang('Type new password if you would like to change current password.')
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="tab-pane" id="tab_payment_setting">
                                <div class="d-flex flex-column align-items-start justify-content-between">
                                    <h4>Payment Setup</h4>
                                    <ul class="nav flex-column">
                                        <li class="nav-item">
                                            <a class="nav-link" href="https://youtu.be/byectV_Ri6c" target="_blank">How  to get PayPal API Credentials?</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="https://youtu.be/byectV_Ri6c" target="_blank">Locating Test and Live Stripe API Keys</a>
                                        </li>
                                    </ul>
                                </div>
                                <hr>
                                @if(!empty($views_render))
                                    {!! $views_render !!}
                                @endif
                            </div>
                            <div class="tab-pane" id="tab_about_us">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="card-body pl-4 py-2">
                                                <div class="form-group">
                                                    <label class="form-label">@lang('Description')</label>
                                                    <textarea name="description" id="description" rows="4"
                                                              class="form-control">{!! $about->description ?? "" !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fe fe-save mr-2"></i> @lang('Save settings')
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        // init editor
        (function () {
            tinymce.init({
                selector: "textarea#description",
                height: "250px",
                plugins: "codesample fullscreen hr image imagetools link lists",
                toolbar:
                    "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | link codesample hr | bullist numlist checklist",
                menubar: false,
                statusbar: false,
                file_picker_callback: function (callback, value, meta) {
                    let x =
                        window.innerWidth ||
                        document.documentElement.clientWidth ||
                        document.getElementsByTagName("body")[0].clientWidth;
                    let y =
                        window.innerHeight ||
                        document.documentElement.clientHeight ||
                        document.getElementsByTagName("body")[0].clientHeight;

                    let type = "image" === meta.filetype ? "Images" : "Files",
                        url = "/laravel-filemanager?editor=tinymce5&type=" + type;

                    tinymce.activeEditor.windowManager.openUrl({
                        url: url,
                        title: "Filemanager",
                        width: x * 0.8,
                        height: y * 0.8,
                        onMessage: (api, message) => {
                            callback(message.content);
                        },
                    });
                },
            });

            $("#theme_design_list").on("change", function () {
                $(".theme-screen-preview").addClass("d-none");
                $("#template_" + this.value).removeClass("d-none");
            });
        })();
    </script>
@endpush