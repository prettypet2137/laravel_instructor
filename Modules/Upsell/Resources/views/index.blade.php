@extends('core::layouts.app')
@section('title', __('SMS Templates'))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"/>
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
    <a class="btn btn-primary add-upsell-btn mb-2" href="{{ route('upsell.create') }}"><i class="fa fa-plus"></i> Add New</a>
    <table class="table table-bordered table-hover" id="upsell_table" style="width: 100%">
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="40">Image</th>
                <th width="350">Title</th>
                <th width="50">Price</th>
                <th>Description</th>
                <th width="60">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <div class="modal fade" id="delete_upsell_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="delete_upsell_form" action="" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        Once you delete it, you can not revert it.
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-trash"></i> Delete</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
<script>
    var token = "{{ csrf_token() }}";
    $(document).ready(function() {
        $("#upsell_table").DataTable({
            processing: true,
            serverSide: true,
            ajax: BASE_URL + "/upsell/get-upsells",
            columns: [
                {data: "id", name: "id"},
                {data: "image", name: "image"},
                {data: "title", name: "title"},
                {data: "price", name: "price"},
                {data: "description", name: "description"},
                {data: "action", name: "action"}
            ]
        });
        $("#upsell_table").on("click", ".delete-btn", function() {
            var id = $(this).data("id");
            $("#delete_upsell_modal form").attr("action", BASE_URL + "/upsell/" + id);
            $("#delete_upsell_modal").modal("show");
        })
    });
</script>
@endpush