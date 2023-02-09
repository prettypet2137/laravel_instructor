@extends('core::layouts.app')
@section('title', __('Events'))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
<style>
</style>
@endpush
@section('content')
<div class="mb-2">
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
<script>
    var token = "{{ csrf_token() }}";
</script>
@endpush