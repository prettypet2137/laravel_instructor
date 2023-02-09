@extends('core::layouts.app')
@section('title', __('Features  '))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.css') }}"/>
@endpush
@section('content')
<div class="mb-2">
    <div class="from-group">
        <label>User Name</label> 
        <input type="text" class="form-control" value="{{ $feature->user->name }}"/>
       </div>
    <div class="form-group">
        <label>Title:</label>
        <input type="text" class="form-control" readonly value="{{ $feature->title }}"/>
    </div>
    <div class="form-group">
        <label>Content:</label>
        <textarea class="form-control" rows="8">{{ $feature->content}}></textarea>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor//bootstrap-switch/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
@endpush