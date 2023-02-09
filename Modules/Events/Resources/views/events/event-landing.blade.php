@extends('events::events.event-landing-layout')
@push('head')
    <style>
        .multiline-ellipsis {
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            height: 50px;
        }

    </style>
@endpush
@section('content')
    <div class="main-1 m-0">
        <div class="container pt-4">
            <div class="d-flex">
                <h2 class="text-white my-auto main-heading3 ">
                    {{$company}}
                </h2>
            </div>
            <div class="row py-5">
                @if ($user->is_show_about_us_form || $user->is_show_contact_us_form)
                <div class="col-lg-7">
                    <div class="">

                        <p class="main-heading2 text-white">
                            Please select below from our upcoming courses
                        </p>

                        <div class="pe-5">
                            <div class=" bg-danger pe-2">
                                @php $colors = ['green','red','blue']; @endphp
                                @forelse($events as $event)
                                    <div class=" row {{ 'borderrow-'.$colors[rand(0,2)]}}">
                                        <div class="col-2 bg-white ">
                                            <div class="py-3 w-100 text-center ">
                                                <img
                                                        class=""
                                                        width="70"
                                                        height="70"
                                                        alt="logo-img"
                                                        src="{{ $event->getImage() ?? Module::asset('events:img/logo.jpg') }}"
                                                /><br/>
                                                <small>Open Seats</small>
                                                <br/>
                                                <button class="w-100 text-center mt-2 py-1 border-0 text-white rounded bg-green"
                                                        style=""
                                                >
                                                    {{$event->available_seats}}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-10 bg-white">
                                            <div class="py-3 ">
                                                <a href="{{ $event->getPublicUrl(!empty($user) ? $user->name : "") }}"
                                                   target="_blank"
                                                   style="text-decoration: none;">
                                                    <h1 class="main-heading1">
                                                        {{$event->name ?? ""}}
                                                    </h1>
                                                </a>

                                                <small>
                                                    <img src="{{ Module::asset('events:img/calender.png')}}"
                                                         alt="calender" width="12"
                                                         height="12">
                                                    {{date_format(date_create($event->start_date),'M d, Y')}}
                                                    - {{date_format(date_create($event->end_date),'M d, Y')}}
                                                    <img src="{{ Module::asset('events:img/clock.png')}}" alt="clock"
                                                         width="12" height="12"> {{date_format(date_create($event->start_date), 'h:i A')}}
                                                </small>

                                                <br/>

                                                <div class="mt-1 multiline-ellipsis">
                                                    {!! $event->description ?? "" !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-5 pt-md-5 pt-lg-0">
                    <div class="px-5">
                        @if ($user->is_show_about_us_form)
                        <div class="main-2 ">
                            <div class="px-4 py-4 ">
                                <p class="main-heading2 text-white">
                                    About
                                </p>
                                <div class="main-heading12 p-3 rounded"
                                     style="background: white!important;">
                                    {!! !empty($about) ? $about->description : "" !!}
                                </div>
                            </div>

                        </div>
                        @endif
                        @if ($user->is_show_contact_us_form)
                        <div class="main-2 mt-5 ">
                            <div class="px-4 py-4 ">
                                <p class="main-heading2 text-white">
                                    Questions?
                                </p>
                                <form method="post" action="{{route('all-events.comment')}}">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{!empty($user) ? $user->id : ""}}">
                                    <div class="row mt-4">
                                        <div class="col-md-12 col-12">
                                            <div class=" ">
                                                <h4
                                                        class="text-center font-nunito color-blue"
                                                >
                                                    Complete the form below
                                                </h4>
                                                @if (session('success'))
                                                    <div class="alert alert-success border-radius-none">
                                                        <i class="fas fa-check-circle text-success mr-2"></i> {!! session('success') !!}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 pt-md-4 pt-4">
                                            <!-- <small class="font-nunito">Name*</small> -->

                                            <div
                                                    class="py-2 px-3 border rounded bg-white"
                                            >
                                                <div class="">
                                                    <input
                                                            type="text"
                                                            class="input-contact w-100"
                                                            placeholder="Enter your name"
                                                            name="name"
                                                            required/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 pt-md-4 pt-3">
                                            <!-- <small class="font-nunito">Email*</small> -->
                                            <div
                                                    class="py-2 px-3 border rounded bg-white"
                                            >
                                                <div class="">
                                                    <input
                                                            type="email"
                                                            class="input-contact w-100"
                                                            placeholder="Enter your email"
                                                            name="email"
                                                            required/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12 pt-md-4 pt-3">
                                            <!-- <small class="font-nunito"
                                              >Phone number*</small
                                            > -->

                                            <div
                                                    class="py-2 px-3 border rounded bg-white"
                                            >
                                                <textarea class="form-control border-0" placeholder="Comment" rows="3"
                                                          name="description"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-12 pt-md-4 pt-3">
                                            <small></small>
                                            <button
                                                    type="submit"
                                                    class="w-100 border text-center bg-success text-white fw-bold py-3 rounded color-bg1"
                                            >
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        </div>
                        @endif
                    </div>
                </div>
                @else 
                <div class="col-lg-12">
                    <div class="">

                        <p class="main-heading2 text-white">
                            Please select below from our upcoming courses
                        </p>

                        <div class="pe-5">
                            <div class=" bg-danger pe-2">
                                @php $colors = ['green','red','blue']; @endphp
                                @forelse($events as $event)
                                    <div class=" row {{ 'borderrow-'.$colors[rand(0,2)]}}">
                                        <div class="col-2 bg-white ">
                                            <div class="py-3 w-100 text-center ">
                                                <img
                                                        class=""
                                                        width="70"
                                                        height="70"
                                                        alt="logo-img"
                                                        src="{{ $event->getImage() ?? Module::asset('events:img/logo.jpg') }}"
                                                /><br/>
                                                <small>Open Seats</small>
                                                <br/>
                                                <button class="w-100 text-center mt-2 py-1 border-0 text-white rounded bg-green"
                                                        style=""
                                                >
                                                    {{$event->available_seats}}
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-10 bg-white">
                                            <div class="py-3 ">
                                                <a href="{{ $event->getPublicUrl(!empty($user) ? $user->name : "") }}"
                                                   target="_blank"
                                                   style="text-decoration: none;">
                                                    <h1 class="main-heading1">
                                                        {{$event->name ?? ""}}
                                                    </h1>
                                                </a>

                                                <small>
                                                    <img src="{{ Module::asset('events:img/calender.png')}}"
                                                         alt="calender" width="12"
                                                         height="12">
                                                    {{date_format(date_create($event->start_date),'M d, Y')}}
                                                    - {{date_format(date_create($event->end_date),'M d, Y')}}
                                                    <img src="{{ Module::asset('events:img/clock.png')}}" alt="clock"
                                                         width="12" height="12"> {{date_format(date_create($event->start_date), 'h:i A')}}
                                                </small>

                                                <br/>

                                                <div class="mt-1 multiline-ellipsis">
                                                    {!! $event->description ?? "" !!}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                @empty
                                @endforelse
                            </div>

                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="d-flex justify-content-center pb-2">
                <a href="/" class="text-decoration-none text-white text-center" target="_blank">Powered By
                    InstructorsDash.com</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script></script>
@endpush