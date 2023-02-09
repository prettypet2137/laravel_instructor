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
    @php
        $user = auth()->user();
        $tab = request()->get("tab");
        $tab = $tab ? $tab : $reminders[0]->id;
    @endphp
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                            aria-orientation="vertical">
                            @foreach ($reminders as $reminder)
                            <a class="nav-link my-1 {{ $tab == $reminder->id ? 'active' : '' }}"
                                id="{{ 'tab_' . $reminder->id . '-tab'}}" data-toggle="pill"
                                href="{{ '#tab_' . $reminder->id  }}">
                                {{ $reminder->type }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                @foreach ($reminders as $reminder)
                <div class="tab-pane fade {{ $tab == $reminder->id ? 'show active' : '' }}"
                    id="{{ 'tab_' . $reminder->id }}">
                    <div class="card">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        @php $template = $reminder->getTemplate(); @endphp
                                        <form action="{{ empty($template) ? route('sms.admin.templates.store') : route('sms.admin.templates.update', $template->id) }}" method="POST">
                                            @csrf
                                            @if (!empty($template))
                                                @method('put')
                                            @endif
                                            <input type="hidden" name="reminder_id" value="{{ $reminder->id }}" />
                                            <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                            <input type="hidden" name="type" value="default" />
                                            <div class="form-group">
                                                <label>Subject:</label>
                                                <input type="text" name="subject" class="form-control"
                                                    value="{{ empty($template) ? '' : $template->subject }}" />
                                            </div>
                                            <div class="form-group">
                                                <label>Message:</label>
                                                <textarea class="form-control" rows="5" name="description">{{ empty($template) ? '' : $template->description }}</textarea>
                                            </div>
                                            <div class="d-flex justify-content-between">

                                                <button class="btn btn-secondary sms-test-btn" data-id="{{ empty($template) ? 0 : $template->id }}" type="button">Sent Test
                                                    SMS</button>
                                                <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="alert alert-warning" style="margin-top: 30px"><strong>Notice!</strong> Enter the following fields so that the content entered by the guest into the form field will be pasted automatically:</div>
                                        <ul class="mt-4">
                                            <li>Event name: <b>%event_name%</b></li>
                                            <li>Event description: <b>%event_description%</b></li>
                                            <li>Event address: <b>%event_address%</b></li>
                                            <li>Event start date: <b>%event_start_date%</b></li>
                                            <li>QR code: <b>%qr_code%</b></li>
                                            <li>Guest fullname: <b>%guest_fullname%</b></li>
                                            <li>Guest email: <b>%guest_email%</b></li>
                                            <li>Guest ticket name: <b>%guest_ticket_name%</b></li>
                                            <li>Guest ticket price: </b>%guest_ticket_price%</b></li>
                                            <li>Guest ticket currency: <b>%guest_ticket_currency%</b></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="sms-test-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">SMS Test Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="template_id"/>
                    <div class="form-group">
                        <label>Receiver Phone Number:</label>
                        <input type="tel" name="receiver_number" placeholder="+12222222222" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label>Subject:</label>
                        <input type="text" name="subject" class="form-control" readonly/>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea class="form-control" name="description" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="sms-test-btn" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Send Now</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                </div>
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

    $(".sms-test-btn").click(function() {
        var id = $(this).data("id");
        $.ajax({
            type: "GET",
            url: `${BASE_URL}/sms/admin/templates/${id}`
        }).then(function(res) {
            $("#sms-test-modal [name='template_id']").val(id);
            $("#sms-test-modal [name='subject']").val(res.subject);
            $("#sms-test-modal [name='description']").val(res.description);
            $("#sms-test-modal").modal("show");
        }, function(err) {
            toastr.error(err.message, "Error!");
        });
    });

    $("#sms-test-btn").click(function() {
        var receiverNumber = $("#sms-test-modal [name='receiver_number']").val();
        if (receiverNumber.trim()) {
            $("#wrapper").LoadingOverlay("show", { size: 50, maxSize: 50});
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/sms/admin/templates/test-sms`,
                data: {
                    _token: token,
                    receiver_number: $("#sms-test-modal [name='receiver_number']").val(),
                    template_id: $("#sms-test-modal [name='template_id']").val()
                }
            }).then(function(res) {
                $("#wrapper").LoadingOverlay("hide");
                toastr.success(res.message, "Success!");
                $("#sms-test-modal").modal("hide");
            }, function(err) {
                $("#wrapper").LoadingOverlay("hide");
                toastr.error(err.responseJSON.message, "Error!");
            });
        } else {
            toastr.error("You have to enter the receiver number to send sms.", "Warning!");
        }
    });
</script>
@endpush