<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @if(!$event->seo_enable)
        <meta name="robots" content="noindex">
    @endif
    <title>@if(!empty($event->seo_title)) {{$event->seo_title}} @else {{$event->name}} @endif</title>
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
    <meta itemprop="image"
          content="@if($event->social_image){{ config('app.url') }}/storage/{{ $event->social_image }}@endif">
    <!-- Facebook Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{$event->social_title}}">
    <meta property="og:description" content="{{$event->social_description}}">
    <meta property="og:image"
          content="@if($event->social_image){{ config('app.url') }}/storage/{{ $event->social_image }}@endif">
    <meta property="og:url" content="{{ $publishUrl }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{$event->social_title}}">
    <meta name="twitter:description" content="{{$event->social_description}}">
    <meta name="twitter:image"
          content="@if($event->social_image){{ config('app.url') }}/storage/{{ $event->social_image }}@endif">
    @if($event->favicon)
        <link rel="icon" href="{{ config('app.url') }}/storage/{{ $event->favicon }}" type="image/png">
    @else
        <link rel="icon" href="{{ asset(config('app.logo_favicon'))}}" type="image/png">
    @endif

<!-- Styles -->
    <link rel="stylesheet" href="{{ asset('modules/events/event_templates/default/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('modules/events/event_templates/default/template.css') }}">
    <link href="https://fonts.googleapis.com/css?family={{ $event->font_family }}&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    @php
        $theme_color = "#316abc";
        if($event->theme_color && $event->theme_color != "#000000"){
           $theme_color = $event->theme_color;
        }
        $background_theme_url = asset('modules/events/event_templates/default/images/background.png');
        if($event->background){
           $background_theme_url = config('app.url'). '/storage/'. $event->background;
        }
        $font_css = explode(':',$event->font_family);
    @endphp
    <style>
        /* variable */
        :root {
            --theme-color: {{ $theme_color }};
            --background-image: url({{ $background_theme_url }});
            --font-family: '{{ $font_css[0] }}';
        }
        .form-control-input, .form-control-select {
            padding-right: 1rem;
        }
        .terms-and-conditions {
            text-align: left;
            border-radius: 5px;
            border: 2px solid #dddddd;
            padding: 10px;
            max-height: 150px;
            overflow: auto;
            background-color: #fafafa;
        }
    </style>
</head>
<body data-spy="scroll">
{{-- Alert --}}
@if($errors->any())
    <div class="alert alert-danger mb-0">
        <ul class="list-unstyled">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session('success'))
    <div class="alert alert-success mb-0">
        {!! session('success') !!}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mb-0">
        {!! session('error') !!}
    </div>
@endif
<!-- Header -->
<header id="header" class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="countdown">
                    <span id="clock"></span>
                </div>
                <h1 class="h1-large">{{ $event->name }}</h1>
                <p class="p-large">{{ $event->tagline }}</p>
                <a class="btn-outline-lg page-scroll" href="#registration">@lang('REGISTER')</a>
                <a class="btn-outline-lg page-scroll" href="#description">@lang('DESCRIPTION')</a>
                <p class="p-large pt-3 mb-0">@lang('Registered Users - '){{ $event->guests_count }}</p>
                <p class="p-large mt-0">@lang('Seats Left - '){{ $event->available_seats }}</p>
            </div>
        </div>
    </div>
</header>
<!-- end of header -->
<!-- Description -->
@php
    $students = request()->students;
    $students = is_null($students) ? 1 : $students;
@endphp
<div id="description" class="cards-2">
    <div class="container">
        <h2 class="h2"><span class="red">@lang('DESCRIPTION')</span></h2>
        <p>
            {!! $event->description !!}
        </p>
        @if(count($event->ticket_items) > 0)
            <h2 class="h2"><span class="red">@lang('Tickets')</span></h2>
            <table class="table">
                <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">@lang('Type')</th>
                    <th scope="col">@lang('Description')</th>
                    <th scope="col">@lang('Price')</th>
                    <th scope="col">@lang('Currency')</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $tmp_items = $event->ticket_items;
                    $tmp_len = count($tmp_items['name']);
                @endphp
                @for($tmp_index = 0; $tmp_index < $tmp_len; $tmp_index++)
                    <tr>
                        <th scope="row">{{ $tmp_index + 1 }}</th>
                        <td>{{ $tmp_items['name'][$tmp_index] }}</td>
                        <td>{{ $tmp_items['description'][$tmp_index] }}</td>
                        <td>{{ $tmp_items['price'][$tmp_index] }}</td>
                        <td>{{ $tmp_items['currency'][$tmp_index] ?? $event->ticket_currency }}</td>
                    </tr>
                @endfor
                </tbody>
            </table>
        @endif
    </div>
</div>
<!-- end of description -->

<!-- Registration -->
<div id="registration" class="form-1 bg-gray" style="clear: both;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="h2-heading text-center"><span class="red">@lang('REGISTER')</span> @lang('FORM')</h2>
                <!-- Registration Form -->
                @if(!$eventRegistrationExpired && !$eventExpired && ($event->available_seats == "unlimited" || $event->available_seats > 0))
                    <div class="form-container">
                        <form action="{{ route('events.public.register', ['slug' => $event->short_slug]) }}"
                              method="post" class="form-register">
                            @csrf

                            <div class="form-group required">
                                <label>@lang('Name')</label>
                                <input type="text" name="fullname[]" class="form-control-input" required>
                            </div>

                            <div class="form-group required">
                                <label>@lang('Email')</label>
                                <input type="email" name="email[]" class="form-control-input" required>
                            </div>
                            
                            <div class="form-group required">
                                <label>@lang('Birthday')</label>
                                <input type="date" name="birthday[]" class="form-control-input" required/>
                            </div>
                            <div class="form-group required">
                                <label>@lang('Cell Phone')</label>
                                <input type="tel" name="phone[]" data-inputmask="'mask': '999-999-9999'" class="form-control-input" required/>
                            </div>
                            @if(count($event->info_items) > 0)
                                @php
                                    $tmp_items = $event->info_items;
                                    $tmp_len = count($tmp_items['name']);
                                @endphp
                                @for($tmp_index = 0; $tmp_index < $tmp_len; $tmp_index++)
                                    @php
                                        $tmp_values = $tmp_items['values'][$tmp_index];
                                        $tmp_values = explode(',', $tmp_values);
                                    @endphp
                                    @switch($tmp_items['data_type'][$tmp_index])
                                        @case('text')
                                        <div class="form-group @if($tmp_items['is_required'][$tmp_index] == '1') required @endif">
                                            <label>{{ $tmp_items['name'][$tmp_index] }}</label>
                                            <input type="text" name="info_item_{{ $tmp_index }}"
                                                   class="form-control-input"
                                                   value="{{ old('info_item_' . $tmp_index, '') }}"
                                                   @if($tmp_items['is_required'][$tmp_index] == '1') required @endif >
                                        </div>
                                        @break
                                        @case('textarea')
                                        <div class="form-group @if($tmp_items['is_required'][$tmp_index] == '1') required @endif">
                                            <label>{{ $tmp_items['name'][$tmp_index] }}</label>
                                            <textarea name="info_item_{{ $tmp_index }}" class="form-control-input"
                                                      rows="3"
                                                      @if($tmp_items['is_required'][$tmp_index] == '1') required @endif >{{ old('info_item_' . $tmp_index, '') }}</textarea>
                                            @error('info_item_' . $tmp_index)
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        @break
                                        @case('select')
                                        <div class="form-group @if($tmp_items['is_required'][$tmp_index] == '1') required @endif">
                                            <label>{{ $tmp_items['name'][$tmp_index] }}</label>
                                            <select name="info_item_{{ $tmp_index }}" class="form-control-select"
                                                    @if($tmp_items['is_required'][$tmp_index] == '1') required @endif >
                                                @foreach($tmp_values as $tmp_value)
                                                    <option value="{{ $tmp_value }}"
                                                            @if(old('info_item_' . $tmp_index, null) == $tmp_value) selected @endif>{{ $tmp_value }}</option>
                                                @endforeach
                                            </select>
                                            @error('info_item_' . $tmp_index)
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        @break
                                        @default
                                    @endswitch
                                @endfor
                            @endif
                            @if(count($event->ticket_items) > 0)
                                <div class="form-group form-group-ticket required">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label>@lang('Tickets')</label>
                                            <select name="ticket" class="form-control-select">
                                                @php
                                                    $tmp_items = $event->ticket_items;
                                                    $tmp_len = count($tmp_items['name']);
                                                @endphp
                                                @for($tmp_index = 0; $tmp_index < $tmp_len; $tmp_index++)
                                                    <option value="{{ $tmp_items['name'][$tmp_index] }};{{ $tmp_items['price'][$tmp_index] }};{{ $tmp_items['currency'][$tmp_index] ?? '' }}">{{ $tmp_items['name'][$tmp_index] }}
                                                        - {{ $tmp_items['price'][$tmp_index] }} {{ $tmp_items['currency'][$tmp_index] ?? '' }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label>@lang('How many Tickets')</label>
                                            <select name="ticketCnt" class="form-control-select" id="student_cnt">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="sub_students"></div>
                            <div class="form-group text-center required">
                                <label>
                                    <input type="checkbox" class="form-check-input" required/><a target="_blank" href="{{ url("e/" . $event->name . "/" . $event->short_slug . "/terms-and-conditions") }}">I accept the terms & conditions</a>
                                </label>
                                <!--<div class="terms-and-conditions">{!! $event->terms_and_conditions !!}</div>-->
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control-submit-button">@lang('REGISTER')</button>
                            </div>
                        </form>
                    </div>
                @elseif ($eventRegistrationExpired)
                    <h2 class="text-center">@lang('Event registration date was expired!')</h2>
                @elseif ($eventExpired) 
                    <h2 class="text-center">@lang('Event has expired!')</h2>
                @elseif ($event->available_seats !== "unlimited" && $event->available_seats == 0)
                    <h2 class="text-center">@lang('Event is full!')</h2>
                @endif
            <!-- end of registration form -->
            </div>
        </div>
    </div>
</div>
<!-- end of registration -->
@if($event->type == "OFFLINE" && !empty($event->address))
    <div id="description" class="cards-2">
        <div class="container">
            <h2 class="h2"><span class="red">@lang('Event Location')</span></h2>
            <div class="map-responsive mt-4">
                <iframe src="https://maps.google.it/maps?q={{urlencode(strip_tags($event->address))}}&output=embed"
                        allowfullscreen frameBorder="0"></iframe>
            </div>
        </div>
    </div>
@endif
<!-- Scripts -->
@if(!$allowRemoveBrand)
    <div class="action_footer">
        <a href="{{ config('app.url') }}" class="cd-top">
            @lang('Powered by') {{ config('app.name') }}
        </a>
    </div>
@endif
<script src="{{ asset('modules/events/event_templates/default/lib.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/inputmask.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/inputmask.min.js') }}"></script>
<script src="{{ asset('vendor/input-mask//dist/bindings/inputmask.binding.js') }}"></script>
<script>
    var register_end_date = `{{ $event->register_end_date->format('Y/m/d H:i:s') }}`;
    var available_seats = "{{ $event->available_seats }}";
    var langs = {
        "countTimeDays": "@lang('Days')",
        "countTimeHours": "@lang('Hours')",
        "countTimeMinutes": "@lang('Minutes')",
        "countTimeSeconds": "@lang('Seconds')",
        "eventRegistrationExpired": "@lang('Event registration date was expired!')",
        "eventExpired": "@lang('Event has expired!')",
        "eventIsFull": "@lang('Event is full!')"
    };
</script>
<script src="{{ Module::asset('events:js/events/event_template/templates.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#student_cnt").change(function() {
            var students_nums = Number($(this).val());
            if (available_seats == "unlimited" || Number(available_seats) >= students_nums) {
                var html = "<h5>Please add information of the additional attendee.</h5>";
                for(let i = 1; i < students_nums; i++) {
                    html += `<div class="row mb-2">
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Name</label>
                                <input type="text" name="fullname[]" class="form-control-input" required>
                            </div>
                        </div>
    
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Email</label>
                                <input type="text" name="email[]" class="form-control-input" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Birthday</label>
                                <input type="date" name="birthday[]" class="form-control-input" required/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group required">
                                <label>Cellphone</label>
                                <input type="tel" name="phone[]" data-inputmask="'mask': '999-999-9999'" class="form-control-input" required/>
                            </div>
                        </div>
                    </div>`;
                }
                $(".sub_students").html(html);
                var inputMask = new Inputmask("999-999-9999");
                inputMask.mask($(".sub_students [type='tel']"));
            } else {
                toastr.error(`You can purchase up to ${available_seats} tickets.`, "Warning !");
            }
        });
        
        var preseOpt = {
        tourID: "anyTourID",
        tourTitle: "instructorsdash",
        baseurl: "http://instructorsdash.com",
        overlayClickable: false,
        lang: {
          modalIntroType: "Instructorsdash.com"
        },
        intro: {
          enable: true,
          title: "Welcome to Instructors Dash.",
          content: "We have created a step by step tour to help you set up your account while also teaching you how to navigate through the features and functions of the site. Let's get started, at any time you can exit the tour and restart by launching “Tour” from the top of the dashboard.."
        },
        steps: [{
          before: function () {
            $("[data-target='account-setting']").click();
          },
          title: "Account Setting",
          content: "Click on the top right to access the drop down menu where you can access your account settings.",
          target: "[data-target='account-setting'] + .dropdown-menu",
          event: ["click", ".dropdown-item:nth-child(1)"]
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Enter your company name here that you would like to display on your site.",
          target: "[name='company']"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "You can update your password at any time from your settings. Always be sure when updating any settings your password boxes are blank if you are not trying to change the password.",
          target: ".change-password-content"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Let's set up how your customer pays you, select the payment settings tab.",
          target: "[href='#tab_payment_setting']",
          event: "click"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "This is where you enter your payment gateway settings. You can select between Paypal or Stripe. For instructions on how to obtain the information required to set up, please select from the links displayed. If you need assistance please contact us through the support tab to assist you in configuring your settings, we charge a one time setup fee.",
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Select “About Us” from the menu and let's configure what your customers will see about your company.",
          target: "[href='#tab_about_us']",
          event: "click"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Enter the info about your company info that you want displayed on your calendar page.",
          target: "#tab_about_us .card-body"
        }, {
          loc: "/accountsettings",
          title: "",
          content: "Now click “save settings” to ensure your updates are saved.",
          target: ".card-footer",
        }, {
          title: "",
          content: "Select “Event Categories from the side menu to continue.",
          target: ".event-category-navlink",
          event: "click"
        }, {
          loc: "/categories",
          title: "",
          content: "We are now going to set up the categories for your event, you must have at least one category setup. Example; Beginners, Intermediate, Advanced",
          target: ".add_category_btn",
          event: "click"
        }, {
          delayBefore: 500,
          loc: "/categories",
          title: "",
          content: "Enter your category name, if there's a space between words add a - between words. Example; Yoga-Class, Pistol-Class, Surfing-Event, MotorCross-Event",
          target: ".modal.create_category_modal .modal-content"
        }, {
          before: function () {
            $(".create_category_modal").modal("hide");
          },
          loc: "/categories",
          content: "With each category created you will be provided a dedicated iframe code that can be used to insert that specific category calendar into your existing website. For example you want to only display the calendar event dates displayed for your “Intermediate-Event” category, you would copy the code for that category and insert it as a course code on your web page. If you need assistance please contact us through the support tab to assist you in configuring your settings, we charge a one time setup fee.",
          target: "#category_table > tbody"
        }, {
          loc: "/categories",
          content: "Select “My Events” from the side menu and let's create your first event.",
          target: "a.nav-link[data-target='#collapseEvents']",
          event: "click"
        }, {
          loc: "/categories",
          content: "Now select “Create Event”",
          target: "[data-target='#createModal']",
          event: "click"
        }, {
          loc: "/categories",
          delayBefore: 500,
          content: "You will first select the category your event will be listed under. After selecting your category, enter the name of your event. Example; “Fight Night Intermediate Class”",
          target: ".modal#createModal .modal-content",
          event: ["submit", "form"],
        }, {
          content: "Select an image for your event that will be displayed.",
          target: "#basic_content [name='image']"
        }, {
          content: "You can update your event name at any time from here. Enter a short description here. Make sure your description is short. Example; “Tuesday night blank beginners course.”",
          target: "#basic_content > .row:nth-child(2)"
        }, {
          content: "This is the maximum number of guests that can attend your course/event. For unlimited enter -1 or you can specify an amount. Example; 20",
          target: "#basic_content .row:nth-child(3) > .col-md-3:nth-child(1) .form-group"
        }, {
          content: "The “Register End Date” is the last date a user can register for the course/event on your calendar. The date/time must be prior to the “Start Date” of your event. You will then select the “Start Date” and “End Date” of your course/event. Be sure to set the correct time. Example 2022-12-19 14:36:13 represents Dec 19,2022 @ 2:36pm.",
          target: "#basic_content .row:nth-child(3) > .col-md-9 .row"
        }, {
          content: "If you would like your event to recur automatically select the box. Then select  the “Day” you want your event to recur on, then set the frequency, repeat every 1 week or every 2 weeks, etc. You will then select the “End Date” when you do not want your course/event to recur any further. PLEASE NOTE when you enable this feature your future events will be automatically added and displayed to your calendar.",
          target: "#basic_content .row:nth-child(4)"
        }, {
          content: "Are you offering this event online or offline, if you select offline you will need to enter a physical address for the event below.",
          target: "#basic_content .row:nth-child(5) > .col-md-3"
        }, {
          content: "Do you want this event to be displayed on your calendar? Example; If this is a private event not to be displayed on your calendar. If “No” is selected the event will NOT display on your calendar. If you do not see an event listed on your calendar, always check this option first what it is set at.",
          target: "#basic_content .row:nth-child(5) > .col-md-6:nth-child(2)"
        }, {
          content: "Enter the full complete address of the event here, including city state zip, this will be displayed as a map on your events page.",
          target: ".col-md-12.address-wrapper"
        }, {
          content: "Enter the full complete description of your course/event here. This will display to your customer the details of your course/event.",
          target: "#basic_content > .row:nth-child(5) > .col-md-12:last-child"
        }, {
          content: "Select the “Advance” tab from the top menu.",
          target: ".nav-tabs #tab_advance_content",
          event: "click"
        }, {
          delayBefore: 500,
          content: "You can use the default slug or If you would like to create a custom “slug” for your event link you may do so here. Be sure that you enter a dash between words. Example; south-event-show",
          target: "#advance_content > .row > .col-md-12:nth-child(1)"
        }, {
          content: "If you would like to collect specific information from your customer when they register, you can create custom fields here. Example; “How did you hear about us?” or “Referred By” etc. You can then select if this is a required field for your customer to fill out or optional. Below this field you will see where you can select the currency, default is USA.",
          target: "#advance_content > .row > .col-md-12:nth-child(2)"
        }, {
          content: "Terms & Conditions is a required field. Here you will enter the Terms & Conditions of your course/event. Your customer will be required to check a box acknowledging they agree to your Terms & Conditions of the course/event before they can continue registering.",
          target: "#advance_content > .row > .col-md-12:nth-child(4)"
        }, {
          content: "From the top menu tab select “Email & Notify”",
          target: "#tab_email_and_notify",
          event: "click"
        }, {
          delayBefore: 500,
          content: "The system by default has already labeled your “Registration Confirmation” email. You may edit the “Sender name” “Email Subject” and “Sender Email” from here. We DO NOT recommend you edit the “Body Message” of the email.",
          target: "#email_and_notify > .row:first-child"
        }, {
          content: "From the top menu select “Custom Domain” tab.",
          target: "#tab_domains",
          event: "click"
        }, {
          delayBefore: 500,
          content: "You can see your event by clicking on the “Public Event Link” If you want to provide someone a direct link to your specific event, this is the link to provide. You can also click on “Preview Button” at any time to preview your event listing page.",
          target: "#nav-domains .public-event-link"
        }, {
          content: "The system allows you to assign a custom domain or subdomain to your event. If you are not familiar with setting up this feature, we do offer a one time setup fee.",
          target: "#nav-domains .row > .col-md-8:nth-child(1)"
        }, {
          content: "Select the “SEO & Social” tab from the top menu. ",
          target: "#tab_seo_config",
          event: "click"
        }, {
          delayBefore: 500,
          content: "The system allows you to set up SEO for your event page, you can add a favicon for your event. This will display on the browser tab like the gmail icon.",
          target: "#seo_config [name='favicon']"
        }, {
          content: "Next you can enter the Title, Description and keywords for your event. This is optional and you do not have to enter this information to create your event.",
          target: "#seo_config .seo-content"
        }, {
          content: "Select “Theme Design tab from the top menu.",
          target: "#tab_theme_design",
          event: "click"
        }, {
          delayBefore: 500,
          content: "With the upgraded plan you can customize the theme of your event page.",
          target: "#theme_design > .row"
        }, {
          before: function () {
            $("#theme_design [name='theme']").click();
          },
          content: "You can select pre-designed themes for your event page.",
          target: "#theme_design .col-md-5 > .form-group"
        }, {
          content: "You can select the desired color and select an image to be used as the background.",
          target: "#theme_design .color-section"
        }, {
          content: "The system allows you to enter custom header and footer code, if you are not familiar with this we suggest leaving it blank.",
          target: "#theme_design .custom-header-and-footer"
        }, {
          content: "Once you have completed all your settings, click save at the bottom left.",
          target: "#form_create .card-footer button[type='submit']"
        }, {
          content: "Your event is now created. Lets now learn how to add an upsell option to your event. This will be displayed when your customer goes to checkout for your event.",
          target: ".upsell-link",
          event: "click"
        }, {
          loc: "/upsell",
          content: "Select “Add New” to create an upsell option.",
          target: ".add-upsell-btn",
          event: "click"
        }, {
          loc: "/upsell/create",
          content: "Select an image to be used for your upsell option. Example; you want to offer a meal ticket with your event, you can add the image displaying a meal ticket or of a meal item. You will then enter the Title of the upsell item. Example; “Last Chance to Add a Discounted Meal Ticket” then you will specify the price. Then the complete full description of your upsell item.",
          target: ".form"
        }, {
          loc: "/upsell/create",
          content: "You may add multiple price options, where you can specify in the description what the different price options include. Example; $5 | Meal for one, $10 | Meal for two, $20 | Meal for Four",
          target: ".form .form-price-group"
        }, {
          loc: "/upsell/create",
          content: "Remember to click save to update your changes.",
          target: ".form .form-actions > button"
        }, {
          delayBefore: 500,
          loc: "/upsell",
          content: "You can repeat this step and create multiple upsell options. Now that an upsell option has been created, let's learn how to add it to an event.",
          target: "#upsell_table"
        }, {
          content: "Select “My Events” from the side menu",
          target: "a[data-target='#collapseEvents']",
          event: "click"
        }, {
          content: "Then select “All Events”",
          target: ".all-events-link",
          event: "click"
        }, {
          delayBefore: 0,
          before: function () {
            $("#event_table tbody tr:nth-child(1) .dropdown-toggle").trigger("click");
          },
          loc: "/events",
          content: "Go to your event you want to add the upsell option to and click the “Actions Menu” from this menu select “Event Edit”",
          target: "table .dropdown-menu > a.dropdown-item:nth-child(1)",
          event: "click"
        }, {
          content: "Now from the event menu tabs select “Upsell”",
          target: "#tab_upsell",
          event: "click"
        }, {
          content: "From the menu select the upsell item you want to add to the event, select then click “Add” You will see the upsell option now added to the event.",
          target: "#upsell .input-group"
        }, {
          content: "Once you have finished adding the upsell items, remember to click “Save” on the bottom right to save your changes.",
          target: "#form_create .card-footer button"
        }, {
          content: "You can repeat this step as many times as you want adding different upsell options. At checkout the system will go through each option that you have added, providing your customer the option to add it to their checkout.",
          target: ""
        }, {
          before: function () {
            $("#event_table tbody tr:nth-child(1) .dropdown-toggle").trigger("click");
          },
          loc: "/events",
          content: "Let's take a look at your specific event page that you have now created.",
          target: "table .dropdown-menu > a.dropdown-item:nth-child(7)",
          event: "click"
        }, {
          content: "You can see the Ticket options you have created displayed on your event page.",
          target: "#description > .container"
        }, {
          content: "Here is where your ticket options you added are displayed on your event page.",
          target: ".form-group-ticket"
        }, {
          content: "Lets learn about the multi-guest option built into the system, select the drop down menu for quantity",
          target: "#student_cnt"
        }, {
          content: "Select the option for quantity “2” from the drop down menu",
          target: "#student_cnt"
        }, {
          content: "The system will now display the fields for the quantity of attendee selected. The",
          target: "#student_cnt"
        }, {
          content: "The system will now display the fields for the quantity of attendee selected. The customer will now enter the information for each additional attendee.",
          target: ".sub_students"
        }, {
          content: "Once the customer enters the registration information, if you have an upsell option added to the event, it will then display as they continue the checkout process.",
          target: ""
        }, {
          loc: "/events",
          before: function () {
            $("a.nav-link[data-target='#collapseEvent']").click();
          },
          content: "From the side menu bar, select “My Events” then “All Events”",
          target: ".all-events-link",
          event: "click"
        }, {
          loc: "/events",
          content: "This is the link to your main calendar page listing your events. If you would like to insert the calendar into an existing website, you can use the “iframe” tool. Click on the “Iframe code copier” button.",
          target: ".iframe-done-container",
          event: ["click", ".iframe-done-container a.btn"]
        }, {
          delayBefore: 500,
          loc: "/events",
          content: "Click the “Copy” button to copy the iFrame code to paste into your existing website. If you need assistance please contact us through the support tab to assist you in configuring your settings, we charge a one time setup fee.",
          target: ".main-code > div:nth-child(1)"
        }, {
          loc: "/events",
          content: "The Calendar Landing Page can be used if you do not have an existing website. This is also the page you would insert directly on to your existing website.",
          target: ""
        }, {
          loc: "/events",
          content: "The About Us section can be added/removed. If you are going to use the iFrame to insert into your existing website, we recommend you hide both About & Questions.",
          target: ""
        }, {
          loc: "/events",
          content: "The Questions form would also be hidden from the page if unchecked.",
          target: ""
        }, {
          loc: "/events",
          content: "You can select to add/remove the “About Us” or “Questions Form’ from your events calendar page by unchecking the boxes. If you are going to insert into an existing website, it is recommended to uncheck both options.",
          target: ".main-code > div.form-group"
        }, {
          loc: "/events",
          content: "You can see both options are now hidden.",
          target: ""
        }, {
          before: function () {
            $(".modal").modal("hide");
          },
          loc: "/events",
          content: "From the side menu select “Reports”",
          target: ".report-link"
        }],
      };
      iGuider("button", preseOpt, 'auto auto 40px 80px');
    });
</script>
</body>
</html>