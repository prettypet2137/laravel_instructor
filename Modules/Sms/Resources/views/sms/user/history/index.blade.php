@extends('core::layouts.app')
@section('title', __('Events'))
@push('head')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <style>
        div.dataTables_wrapper div.dataTables_length select {
            width: 50px;
        }
    </style>
@endpush
@section('content')
<div>
    <table id="history_table" class="table table-striped table-hover table-bordered dt-responsive nowrap desktop"
        style="width: 100%">
        <thead class="thead-dark text-center">
            <tr class="text-center">
                <th width="25">No</th>
                <th>Phone Number</th>
                <th>Reminder Type</th>
                <th>Send Date</th>
                <th width="30">Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @php $idx = 1; @endphp
            @foreach ($histories as $history)
            <tr>
                <td>{{ $idx++ }}</td>
                <td>{{ $history->receiver_number }}</td>
                <td>{{ $history->reminder_type->type }}</td>
                <td>{{ $history->created_at }}</td>
                <td>
                    <button class="btn btn-sm btn-danger delete_reminder_btn" data-id="{{ $history->id}}"
                        data-toggle="tooltip" data-placement="top" title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="delete_reminder_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Do you want to delete this history really? Once you delete it, you can not revert it again.
                    <input type="hidden" name="id"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="delete_reminder_btn"><i class="fa fa-thumbs-up"></i> Yes</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-thumbs-down"></i> No</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        var token = "{{ csrf_token() }}";
        $(document).ready(function() {
            var historyTable = $("#history_table").DataTable({
                "responsive": true,
            });
            $("#history_table").on("click", ".delete_reminder_btn", function() {
                var id = $(this).data("id");
                $("#delete_reminder_modal input[type='hidden']").val(id);
                $("#delete_reminder_modal").modal("show");
            });
            $("#delete_reminder_btn").click(function() {
                var id = $("#delete_reminder_modal input[type='hidden']").val();
                $.ajax({
                    type: "POST",
                    url: BASE_URL + "/sms/history/" + id,
                    data: {
                        _token: token,
                        _method: "DELETE"
                    }
                }).then(function(res) {
                    toastr.success("The history is delete successfully.", "Success!");
                    $("#delete_reminder_modal").modal("hide");
                    location.reload();
                }, function(err) {
                    toastr.error(err.message(), "Error!");
                });
            });
        });

    </script>
@endpush