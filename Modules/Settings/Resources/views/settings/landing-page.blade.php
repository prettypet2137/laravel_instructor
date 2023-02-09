@extends('core::layouts.app')

@section('title', __('Landing Page'))

@push('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/theme/material-ocean.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/hint/show-hint.css">
    <link rel="stylesheet" href="{{ Module::asset('settings:css/main.css') }}"> <!-- Main css -->
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Landing Page settings')</h1>
    </div>
    <div class="row">
        <div class="col-md-3">
            @include('core::partials.admin-sidebar')
        </div>

        <div class="col-md-9">
            <form method="post" action="{{route('settings.landing-page.update')}}">
                @csrf
                <div class="row">
                    <div class="col-md-12" style="height: 700px;">
                        <div class="text-center mb-5">Landing Page HTML Editor</div>
                        <!-- Main area -->
                        <div id="main">
                            <!-- Editor -->
                            <textarea id="editor" name="description">
                        @if(!empty($content))
                            {!! $content->description !!}
                        @else
                            <!-- Header -->
                                <header id="header" class="header">
    <img class="decoration-line-blue" src="{{ Module::asset('themes:default/images/decoration-line-blue.svg')}}"
         alt="alternative">
    <img class="decoration-line-green" src="{{ Module::asset('themes:default/images/decoration-line-green.svg')}}"
         alt="alternative">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-container">
                    <h1 class="h1-large">@lang(!empty($content->title) ? $content->title : 'Create your event with 5 minutes')</h1>
                    <p class="p-large p-heading">@lang(!empty($content->description) ? $content->description : 'Manage your event and event attendees professionally and simply without the need for an expert').</p>
                    <a class="btn-solid-lg" href="{{ route('register') }}">@lang('Sign Up')</a>
                </div> <!-- end of text-container -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="image-container">
                    <img class="img-fluid"
                         src="{{ !empty($content) ? $content->getImage() : 'https://images.pexels.com/photos/2608517/pexels-photo-2608517.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=750&w=1260' }}"
                         alt="alternative">
                </div> <!-- end of image-container -->
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</header> <!-- end of header -->
                                <!-- end of header -->

                                <!-- Customers -->
                                <div class="slider-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>@lang('Trusted and used by more than <span class="blue">12300+</span> customers')</h4>
                <!-- Image Slider -->
                <div class="slider-container">
                    <div class="swiper-container image-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="img-fluid"
                                     src="{{ Module::asset('themes:default/images/customer-logo-1.png')}}"
                                     alt="alternative">
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid"
                                     src="{{ Module::asset('themes:default/images/customer-logo-2.png')}}"
                                     alt="alternative">
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid"
                                     src="{{ Module::asset('themes:default/images/customer-logo-3.png')}}"
                                     alt="alternative">
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid"
                                     src="{{ Module::asset('themes:default/images/customer-logo-4.png')}}"
                                     alt="alternative">
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid"
                                     src="{{ Module::asset('themes:default/images/customer-logo-5.png')}}"
                                     alt="alternative">
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid"
                                     src="{{ Module::asset('themes:default/images/customer-logo-6.png')}}"
                                     alt="alternative">
                            </div>
                        </div> <!-- end of swiper-wrapper -->
                    </div> <!-- end of swiper container -->
                </div> <!-- end of slider-container -->
                <!-- end of image slider -->

                <hr class="section-divider">
            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of slider-1 -->
                                <!-- end of customers -->

                                <!-- Benefits -->
                                <div class="cards-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="h2-heading">@lang('Check out all the benefits')</h2>
                <p class="p-heading">@lang('Event Landing Page, Countdown time, Registration form, Email Invitations, Selling ticket, Attendee Management')</p>
            </div> <!-- end of col -->
        </div> <!-- end of row -->
        <div class="row">
            <div class="col-lg-12">

                <!-- Card -->
                <div class="card">
                    <div class="card-icon">
                        <span class="fas fa-globe green"></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">@lang('Publish Event Anywhere')</h5>
                        <p>@lang('A mobile-friendly event landing page for selling tickets, your website or blog, Facebook, Twitter, and more.')</p>
                    </div>
                </div>
                <!-- end of card -->

                <!-- Card -->
                <div class="card">
                    <div class="card-icon">
                        <span class="far fa-clipboard blue"></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">@lang('Manage Your Event')</h5>
                        <p>@lang('Event Landing Page, Countdown time, Registration form, Email Invitations, Selling ticket, Attendee Management')</p>
                    </div>
                </div>
                <!-- end of card -->
                <!-- Card -->
                <div class="card">
                    <div class="card-icon">
                        <span class="fas fa-users purple"></span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">@lang('Easy To Use')</h5>
                        <p>@lang('Anyone without IT skills can start using app in a matter of minutes after creating their free account in the app')</p>
                    </div>
                </div>
                <!-- end of card -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of cards-1 -->
                                <!-- end of benefits -->
                                <!-- Testimonials -->
                                <div class="slider-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">

                <!-- Card Slider -->
                <div class="slider-container">
                    <div class="swiper-container card-slider">
                        <div class="swiper-wrapper">

                            <!-- Slide -->
                            <div class="swiper-slide">
                                <div class="card">
                                    <img class="quotes" src="{{ Module::asset('themes:default/images/quotes.svg')}}"
                                         alt="alternative">
                                    <div class="card-body">
                                        <p class="testimonial-text">@lang("I purchased pro version for my business. It's an amazingly good tool")</p>
                                        <div class="details">
                                            <img class="testimonial-image"
                                                 src="{{ Module::asset('themes:default/images/testimonial-1.jpg')}}"
                                                 alt="alternative">
                                            <div class="text">
                                                <div class="testimonial-author">Samantha Bloom</div>
                                                <div class="occupation">Team Leader - Syncnow</div>
                                            </div> <!-- end of text -->
                                        </div> <!-- end of testimonial-details -->
                                    </div>
                                </div>
                            </div> <!-- end of swiper-slide -->
                            <!-- end of slide -->

                            <!-- Slide -->
                            <div class="swiper-slide">
                                <div class="card">
                                    <img class="quotes" src="{{ Module::asset('themes:default/images/quotes.svg')}}"
                                         alt="alternative">
                                    <div class="card-body">
                                        <p class="testimonial-text">@lang('The speed of this application is amazing')</p>
                                        <div class="details">
                                            <img class="testimonial-image"
                                                 src="{{ Module::asset('themes:default/images/testimonial-2.jpg')}}"
                                                 alt="alternative">
                                            <div class="text">
                                                <div class="testimonial-author">Mike Page</div>
                                                <div class="occupation">Developer - Chainlink</div>
                                            </div> <!-- end of text -->
                                        </div> <!-- end of testimonial-details -->
                                    </div>
                                </div>
                            </div> <!-- end of swiper-slide -->
                            <!-- end of slide -->

                            <!-- Slide -->
                            <div class="swiper-slide">
                                <div class="card">
                                    <img class="quotes" src="{{ Module::asset('themes:default/images/quotes.svg')}}"
                                         alt="alternative">
                                    <div class="card-body">
                                        <p class="testimonial-text">@lang("This app has the potential of becoming a mandatory tool in every marketer's.")</p>
                                        <div class="details">
                                            <img class="testimonial-image"
                                                 src="{{ Module::asset('themes:default/images/testimonial-3.jpg')}}"
                                                 alt="alternative">
                                            <div class="text">
                                                <div class="testimonial-author">Mary Longhorn</div>
                                                <div class="occupation">Manager - Firstdev</div>
                                            </div> <!-- end of text -->
                                        </div> <!-- end of testimonial-details -->
                                    </div>
                                </div>
                            </div> <!-- end of swiper-slide -->
                            <!-- end of slide -->

                            <!-- Slide -->
                            <div class="swiper-slide">
                                <div class="card">
                                    <img class="quotes" src="{{ Module::asset('themes:default/images/quotes.svg')}}"
                                         alt="alternative">
                                    <div class="card-body">
                                        <p class="testimonial-text">@lang('The team created an awesome communication experience')</p>
                                        <div class="details">
                                            <img class="testimonial-image"
                                                 src="{{ Module::asset('themes:default/images/testimonial-4.jpg')}}"
                                                 alt="alternative">
                                            <div class="text">
                                                <div class="testimonial-author">Ronny Drummer</div>
                                                <div class="occupation">Designer - Sawdust</div>
                                            </div> <!-- end of text -->
                                        </div> <!-- end of testimonial-details -->
                                    </div>
                                </div>
                            </div> <!-- end of swiper-slide -->
                            <!-- end of slide -->

                        </div> <!-- end of swiper-wrapper -->

                        <!-- Add Arrows -->
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <!-- end of add arrows -->

                    </div> <!-- end of swiper-container -->
                </div> <!-- end of slider-container -->
                <!-- end of card slider -->

            </div> <!-- end of col -->
        </div> <!-- end of row -->
    </div> <!-- end of container -->
</div> <!-- end of slider-2 -->
                                <!-- end of testimonials -->
                            @endif
                    </textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success mt-5">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop

@push('scripts')
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/mode/xml/xml.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/mode/javascript/javascript.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/mode/css/css.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/mode/htmlmixed/htmlmixed.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/edit/matchbrackets.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/hint/show-hint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/hint/javascript-hint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/hint/html-hint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/hint/xml-hint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/addon/hint/css-hint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.52.2/keymap/sublime.js"></script>
    <script src="{{ Module::asset('settings:js/main.js') }}"></script>
@endpush