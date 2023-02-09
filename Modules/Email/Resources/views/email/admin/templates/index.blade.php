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
                                        <form
                                            action="{{ empty($template) ? route('email.admin.templates.store') : route('email.admin.templates.update', $reminder->getTemplate()->id) }}" method="POST">
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
                                                <textarea class="form-control tinymce" name="description">
                                                        {{ empty($template) ? "" : $template->description }}
                                                    </textarea>
                                            </div>
                                            <div class="d-flex justify-content-end">
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
    tinymce.init({
        selector: "textarea",
        height: "250px",
        plugins: "codesample fullscreen hr image imagetools link lists",
        toolbar:
            "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | image link codesample hr | bullist numlist checklist",
        menubar: false,
        statusbar: false,
        file_picker_callback: function (callback, value, meta) {
            let x =
                window.innerWidth ||
                document.documentElement.clientWidth ||
                document.getElementsByTagName("body")[0].clientWidth;
            let y =
                window.innerHeight ||
                document.documentElement.clientHeight ||
                document.getElementsByTagName("body")[0].clientHeight;

            let type = "image" === meta.filetype ? "Images" : "Files",
                url = "/laravel-filemanager?editor=tinymce5&type=" + type;

            tinymce.activeEditor.windowManager.openUrl({
                url: url,
                title: "Filemanager",
                width: x * 0.8,
                height: y * 0.8,
                onMessage: (api, message) => {
                    callback(message.content);
                },
            });
        },
    });
</script>
@endpush