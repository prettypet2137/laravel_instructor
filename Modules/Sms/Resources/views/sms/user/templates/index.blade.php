@extends('core::layouts.app')
@section('title', __('SMS Templates'))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.css') }}"/>
<style>
    .sms-balance {
        max-width: 120px; height: calc(2rem + 2px);
    }
    .toggle-group > .toggle-off {
        background-color: #dae0e5;
        border-color: #d3d9df;
    }
</style>
@endpush
@section('content')
<div class="mb-2">
    @php
        $tab = request()->get("tab");
        $tab = $tab ? $tab : $reminders[0]->id;
        $user = auth()->user();
        $smsStatus = auth()->user()->sms_status;
        $smsBalance = auth()->user()->sms_balance;
    @endphp
    <div class="card mb-4">
        <div class="card-content">
            <div class="card-body py-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="sms-switch" style="display: inline-block">
                            <input type="checkbox" id="sms-switch" data-on="SMS Enable" data-off="SMS Disable" data-toggle="toggle" {{ $smsStatus ? 'checked' : '' }}/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group justify-content-end">
                            <input type="text" class="form-control sms-balance" value="{{ 'Balance $' . $smsBalance }}" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="recharge-btn">Recharge</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                        @if (empty($template) || $template->type == "default")
                                            <form action="{{ route('sms.user.templates.store') }}" method="POST">
                                        @elseif ($template->user_id == $user->id)
                                            <form action="{{ route('sms.user.templates.update', $template->id) }}" method="POST">
                                                @method('put')
                                        @endif
                                                @csrf
                                                <input type="hidden" name="reminder_id" value="{{ $reminder->id }}" />
                                                <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                                <input type="hidden" name="type" value="customize" />
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
    <div class="modal fade" id="sms-checkout-modal">
        <div class="modal-dialog" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" action="{{ route('sms.user.templates.sms-checkout') }}">
                        @csrf
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="pt-3">
                            <div class="form-group d-flex">
                                <img src="{{ url('img/sms.jpg') }}" width="70" height="70" alt="SMS"/>
                                <div class="description pl-3 pt-2" style="flex: 1">
                                    <h3>SMS Service</h3>
                                    <h6>Amount: ${{$sms_hire->amount}}</h6>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label>Payment Option:</label>
                                <select class="form-control" name="payment_method">
                                    <option value="stripe">Stripe</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                        </div>
                        <hr/>
                        <button class="btn btn-primary btn-block">Pay now</button>
                        <button type="button" class="btn btn-danger btn-block" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
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
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor//bootstrap-switch/bootstrap4-toggle.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
<script src="{{ asset('vendor/loading-overlay/dist/loadingoverlay.min.js') }}"></script>
<script>
    var token = "{{ csrf_token() }}";
    var smsStatus = {{ $smsStatus }};
    $(document).ready(function() {
        $("#sms-switch").change(function() {
            var status = $(this).prop("checked") ? 1 : 0;
            $.ajax({
                type: "POST",
                url: `${BASE_URL}/sms/templates/enable-sms`,
                data: {
                    _token: token,
                    sms_status: status
                }
            }).then(function(res) {
                smsStatus = status;
                toastr.success(res.message, "Success!");
            }, function(err) {
                toastr.error(err.message, "Warning!");
            })
        });

        $("#recharge-btn").click(function() {
            $("#sms-checkout-modal").modal("show");
        });

        $(".sms-test-btn").click(function() {
            var id = $(this).data("id");
            if (smsStatus) {
                $.ajax({
                    type: "GET",
                    url: `${BASE_URL}/sms/templates/${id}`
                }).then(function(res) {
                    $("#sms-test-modal [name='template_id']").val(id);
                    $("#sms-test-modal [name='subject']").val(res.subject);
                    $("#sms-test-modal [name='description']").val(res.description);
                    $("#sms-test-modal").modal("show");
                });
            } else {
                toastr.error("You need to enable it to use SMS feature.", "Warning!");
            }
        });

        $("#sms-test-btn").click(function() {
            var receiverNumber = $("#sms-test-modal [name='receiver_number']").val();
            if (receiverNumber.trim()) {
                $("#wrapper").LoadingOverlay("show", { size: 50, maxSize: 50});
                $.ajax({
                    type: "POST",
                    url: `${BASE_URL}/sms/templates/test-sms`,
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
        })
    });
</script>
@endpush
