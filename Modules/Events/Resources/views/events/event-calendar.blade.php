<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Events Calendar</title>
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/bootstrap.min.css') }}"  />
    <link rel="stylesheet" type="text/css" href="{{ Module::asset('themes:default/css/fontawesome-all.min.css') }}"  />
    <style>
        .event-left-content {
            flex-basis: 80px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .event-left-content > img {
            border: 1px solid #cccccc;
            margin-bottom: 10px;
        }
        .event-left-content .badge {
            margin-top: 8px;
            display: block;
            padding: 5px;
            border-radius: 0px;
            line-height: 1;
            width: 100%;
        }
        .event-right-content {
            flex: 1;
        }
        .event-right-content a {
            color: #2261a5;
        }
        .event-description {
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            background:#fff;
            position:absolute;
            padding-top: 10px;
            padding-right: 20px;
        }
    </style>
</head>
<body>
    @if (session('error'))
        <div class="alert alert-danger border-radius-none">
            <i class="fas fa-times text-danger mr-2"></i> {!! session('error') !!}
        </div>
    @endif
    <div class="container py-2">
        @foreach ($events as $event)
        <div class="card mb-2">
            <div class="card-content">
                <div class="card-body d-flex">
                    <div class="event-left-content">
                        <img src="{{ $event->getImage() ?? Module::asset('events:img/logo.jpg') }}" style="width: 70px; height: 65px;"/>
                        <small>Open Seats</small>
                        <span class="badge badge-success">{{ ucfirst($event->available_seats) }}</span>
                    </div>
                    <div class="event-right-content px-4">
                        <h4 class="card-title"><a target="_blank" href="{{ $event->getPublicUrl(!empty($user) ? $user->name : "") }}">{{ $event->name }}</a></h4>
                        <small class="d-flex align-items-center">
                            <img src="{{ Module::asset('events:img/calender.png') }}" class="mr-1" alt="calendar" style="width: 12px; height: 12px;">
                            {{ date_format(date_create($event->start_date), 'M d, Y') }} - {{ date_format(date_create($event->end_date), 'M d, Y') }}
                            <img src="{{ Module::asset('events:img/clock.png') }}" class="mr-1 ml-2" width="12" height="12" alt="clock"/> 06:46 P.M.
                        </small>
                        <div class="event-description">
                            {!! $event->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <script src="{{ Module::asset('themes:default/js/jquery.min.js') }}"></script>
    <script src="{{ Module::asset('themes:default/js/bootstrap.min.js') }}"></script>
</body>
</html>