@extends('core::layouts.app')
@section('title', __('Guests Emailing'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <h1 class="h3 mb-4 text-gray-800">@lang('Guests Emailing')</h1>
        <div class="ml-auto d-sm-flex guest-emails-filter">
            <button class="btn btn-success mr-2 btn-send-email">Send Email</button>
            <form method="get" action="" class="navbar-search mr-4 d-flex justify-content-around">
                <div class="input-group">
                    <select name="event" class="form-control" id="eventId">
                        <option value="all">@lang('All')</option>
                        @forelse($events as $event)
                            <option value="{{$event->name}}" {{ $event->name == \Request::get('event', '') ? 'selected' : '' }}>@lang($event->name)</option>
                        @empty
                        @endforelse
                    </select>
                </div>
                <div class="input-group ml-2">
                    <input type="text" name="guest" value="{{ \Request::get('guest', '') }}"
                           class="form-control" placeholder="@lang('Search Guest')"
                           aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if($guests->count() > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <table class="table card-table table-vcenter text-nowrap" id="usersTable">
                        <thead class="thead-dark">
                        <tr>
                            <th><input type="checkbox" class="check-all"/></th>
                            <th>@lang('Event')</th>
                            <th>@lang('Email')</th>
                            <th>@lang('Paid')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Register at')</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($guests as $guest)
                            <tr>
                                <td>
                                    <input type="checkbox" class="user-checkbox" name="users[]"
                                           value="{{ $guest->id }}">
                                </td>
                                <td>
                                    {{ $guest->event->name ?? '' }}
                                </td>
                                <td>
                                    {{ $guest->email }}
                                </td>
                                <td>
                                    {{ $guest->is_paid ? __('Paid') : __('Unpaid') }}
                                </td>
                                <td>
                                    {{ $guest->status == 'joined' ? __('Joined') : __('Registered') }}
                                </td>
                                <td>
                                    @php echo date('d-m-Y H:i:s', strtotime($guest->created_at)); @endphp
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $guests->appends( Request::all() )->links() }}
                </div>
            </div>
        </div>
    @endif
    @if($guests->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="error mx-auto mb-3"><i class="fas fa-calendar-day"></i></div>
                    <p class="lead text-gray-800">@lang('Not Found')</p>
                    <p class="text-gray-500">@lang("You don't have any events guests")</p>
                </div>
            </div>
        </div>
    @endif
    @include('events::guests.email-modal')
@stop

@push('scripts')
    <script src="{{ Module::asset('events:js/events/index.js') }}"></script>
    <script type="text/javascript">
        $("#usersTable").find('input[type=checkbox]').prop('checked', true);

        $('.check-all').click(function (e) {
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);
        });

        $('#eventId').change(function (e) {
            $(this).closest("form").submit();
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });

        $(".send-email").click(function () {
            var btn = $(this);
            var selectRowsCount = $("input[class='user-checkbox']:checked").length;

            if (selectRowsCount > 0) {

                var subject = $('#subject').val();
                var textareaValue = tinymce.get('description').getContent();

                if (subject.length && textareaValue.length) {
                    var ids = $.map($("input[class='user-checkbox']:checked"), function (c) {
                        return c.value;
                    });

                    $.ajax({
                        type: 'POST',
                        url: "{{ route('guests.email.send') }}",
                        data: {
                            ids: ids,
                            subject: subject,
                            description: String(textareaValue)
                        },
                        beforeSend: function () {
                            btn.html('Loading...');
                            btn.attr("disabled", true)
                        },
                        success: function (data) {
                            btn.html('Send Email');
                            btn.removeAttr("disabled")
                            $('#subject').val('')
                            tinymce.get('description').setContent('');
                            $("#modalEmailTemplate").modal("hide");
                            alert(data.success);
                        },
                        error: function (error) {
                            btn.html('Send Email');
                            btn.removeAttr("disabled")
                            console.log(error);
                        }
                    });

                } else {
                    alert("All form fields are required.");
                }

            } else {
                alert("Please select at least one user from list.");
            }
            console.log(selectRowsCount);
        });

        $(".btn-send-email").click(function () {
            $("#modalEmailTemplate").modal("show");
        });

        $("#modalEmailTemplate").on("hidden.bs.modal", function (e) {
            $('#subject').val('')
            tinymce.get('description').setContent('');
        });
        // init editor
        (function () {
            tinymce.init({
                selector: "textarea#description",
                height: "350px",
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
            tinymce.init({
                selector: "textarea#email_content",
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

            $("#theme_design_list").on("change", function () {
                $(".theme-screen-preview").addClass("d-none");
                $("#template_" + this.value).removeClass("d-none");
            });
        })();
    </script>
@endpush