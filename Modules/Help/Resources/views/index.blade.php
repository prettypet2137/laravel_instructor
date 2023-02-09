@extends('core::layouts.app')
@section('title', __('Events'))
@push('head')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <style>
        .video-container {
            text-align:center;
        }
        .video-content {
            margin: 20px auto;
            width: 80%;
            padding-top: 55%;
            position: relative;
        }
        .video-content > iframe {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0
        }
    </style>
@endpush
@section('content')
<div class="mb-2">
        @foreach ($videos as $video) 
        <div class="card mb-3">
            <div class="card-content">
                <div class="card-body">
                    <div class="video-container">
                        <h2 class="video-title">{{ $video->title }}</h2>
                        <div class="video-content">
                            <iframe src="{{ $video->link }}"></iframe>
                        </div>
                        <div class="vide-description">{!! $video->description !!}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
</div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        var token = "{{ csrf_token() }}";
        $(document).ready(function() {
        });
    </script>
@endpush