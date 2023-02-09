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
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card mb-2">
                <div class="card-header">
                    <h4 class="card-title mb-0">SMS Account Setting</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ $sms_account ? route('sms.admin.setting.update', $sms_account->id) : route('sms.admin.setting.store') }}" method="post">
                            @csrf
                            @if ($sms_account)
                                @method('put')
                            @endif
                            <div class="form-group">
                                <label>Twilio String Identifier:</label>
                                <input type="text" class="form-control" name="twilio_sid" value="{{ $sms_account ? $sms_account->twilio_sid : "" }}"/>
                            </div>
                            <div class="form-group">
                                <label>Twilio Token:</label>
                                <input type="text" class="form-control" name="twilio_token" value="{{ $sms_account ? $sms_account->twilio_token : "" }}"/>
                            </div>
                            <div class="form-group">
                                <label>Twilio Phone Number:</label>
                                <input type="text" class="form-control" name="twilio_number" value="{{ $sms_account ? $sms_account->twilio_number : "" }}"/>
                            </div>
                            <div class="form-actions text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> {{ $sms_account ? "Update" : "Save" }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">SMS Fee</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form method="POST" action="{{ route('sms.admin.setting.fee-update') }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group required">
                                <label for="sms_fee">Price:</label>
                                <input type="number" required id="sms_fee" step="0.001" name="sms_fee" class="form-control" value="{{ $sms_account->sms_fee }}"/>
                            </div>
                            <div class="form-actions text-right">
                                <button class="btn btn-primary">
                                    <i class="fa fa-edit"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-header" style="padding: 0.5rem 1.25rem">
                    <h4 class="card-title mb-0" style="line-height: 1.5">
                        SMS Hire Setting
                        <button class="btn btn-primary float-right" id="new-sms-hire-btn"><i class="fa fa-save"></i> New Hire</button>
                    </h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class="table table-bordered table-hover" id="sms-hire-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="30">No</th>
                                    <th>Amount</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($sms_hires as $sms_hire)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $sms_hire->amount }}</td>
                                        <td>
                                            @if ($sms_hire->is_active)
                                                <button class="btn btn-sm btn-primary enable-sms-hire-btn" data-status="{{ $sms_hire->is_active }}" data-id="{{ $sms_hire->id }}" data-toggle="tooltip" data-placement="top" title="Enable/Disable">
                                                    <i class="fa fa-thumbs-up"></i>
                                                </button>
                                            @else 
                                                <button class="btn btn-sm btn-primary enable-sms-hire-btn" data-status="{{ $sms_hire->is_active }}" data-id="{{ $sms_hire->id }}" data-toggle="tooltip" data-placement="top" title="Enable/Disable">
                                                    <i class="fa fa-thumbs-down"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-success edit-sms-hire-btn" data-id="{{ $sms_hire->id }}" data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger delete-sms-hire-btn" data-id="{{ $sms_hire->id }}" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-sms-hire-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">New Sms Hire</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="new-sms-hire-form" action="{{ route('sms.admin.setting.hire-store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>New Hire Amount:</label>
                            <input type="number" name="amount" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Create</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="enable-sms-hire-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="enable-sms-hire-form" action="" method="post">
                    @csrf
                    @method('patch')
                    <div class="modal-body">
                        Do you really want to enable the hire option?
                        <input type="hidden" name="is_active"/>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-thumbs-up"></i> Enable</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-thumbs-down"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-sms-hire-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Sms Hire</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="edit-sms-hire-form" action="" method="post">
                    @csrf
                    @method('put')
                    <div class="modal-body">
                        <div class="form-group mb-0">
                            <label>Hire Amount:</label>
                            <input type="number" name="amount" class="form-control"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-sms-hire-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form class="delete-sms-hire-form" action="" method="post">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
<script>
    var token = "{{ csrf_token() }}";
    $(document).ready(function() {
        $("#sms-hire-table").DataTable({
            responsive: true,
            searching: false,
            lengthChange: false,
            info: false,
            paging: false
        });

        $("#new-sms-hire-btn").click(function() {
            $(".new-sms-hire-form")[0].reset();
            $("#new-sms-hire-modal").modal("show");
        });

        $("#sms-hire-table").on("click", ".enable-sms-hire-btn", function() {
            var id = $(this).data("id");
            var isActive = $(this).data("status");
            if (!isActive) {
                $(".enable-sms-hire-form").attr("action", BASE_URL + "/sms/admin/setting/hires/" + id);
                $("#enable-sms-hire-modal [name='is_active']").val(1);
                $("#enable-sms-hire-modal").modal("show");
            }
        });

        $("#sms-hire-table").on("click", ".edit-sms-hire-btn", function() {
            var id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: `${BASE_URL}/sms/admin/setting/hires/${id}`
            }).then(function(res) {
                $(".edit-sms-hire-form").attr("action", BASE_URL + "/sms/admin/setting/hires/" + id);
                $(".edit-sms-hire-form [name='amount']").val(res.amount);
                $("#edit-sms-hire-modal").modal("show");
            })
        });

        $("#sms-hire-table").on("click", ".delete-sms-hire-btn", function() {
            var id = $(this).data("id");
            $(".delete-sms-hire-form").attr("action", BASE_URL + "/sms/admin/setting/hires/" + id);
            $("#delete-sms-hire-modal").modal("show");
        });
    });
</script>
@endpush