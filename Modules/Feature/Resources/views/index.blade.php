@extends('core::layouts.app')
@section('title', __('Features  '))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.css') }}"/>
<style>
    .dataTables_length select{
        min-width: 65px !important;
    }
    td {
        vertical-align: middle !important;
    }
</style>
@endpush
@section('content')
<div class="mb-2">
    <table class="table table-bordered table-hover" id="feature_table" style="width: 100%">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="60">User</th>
                <th>Title</th>
                <th width="80">Sent Date</th>
            </tr>
        </thead>
    </table>
</div>
@endsection
@push('scripts')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor//bootstrap-switch/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
<script>
    var token = "{{ csrf_token() }}";
    $(document).ready(function() {
        $("#feature_table").DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: BASE_URL + "/feature/get-features",
            columns: [
                {data: "id", name: "id"},
                {data: "username", name: "username"},
                {data: "title", name: "title"},
                {
                    data: function(row) {
                        return moment(row.created_at).format("YYYY/MM/DD HH:mm:ss")
                    },
                    name: "created_at"
                }
            ]
        })
    });
</script>
@endpush
