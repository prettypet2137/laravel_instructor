@extends('core::layouts.app')
@section('title', __('Users'))
@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Users')</h1>
        <a href="{{ route('settings.users.create') }}" class="btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-plus fa-sm text-white-50"></i> @lang('Create')</a>
    </div>

    <div class="row">
        <div class="col-md-3">
            @include('core::partials.admin-sidebar')
        </div>
        <div class="col-md-9">
            @if($data->count() > 0)
                <div class="card mb-3">
                    <div class="table-responsive">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <div class="d-flex justify-content-around">
                                <button class="btn btn-success m-2 btn-send-email">Send Email</button>
                                <button class="btn btn-success m-2 btn-send-all-email">Send All</button>
                            </div>
                            <form method="get" action="" class="navbar-search mr-4">
                                <div class="input-group">
                                    <input type="text" name="search" value="{{ \Request::get('search', '') }}"
                                           class="form-control bg-light border-0 small" placeholder="@lang('Search')"
                                           aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table class="table card-table table-vcenter text-nowrap" id="usersTable">
                            <thead class="thead-dark">
                            <tr>
                                <th><input type="checkbox" class="check-all"/></th>
                                <th>@lang('Name')</th>
                                <th>@lang('E-mail')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="user-checkbox" name="users[]"
                                               value="{{ $item->id }}">
                                    </td>
                                    <td>
                                        {{ $item->name }}
                                    </td>
                                    <td>
                                        {{ $item->email }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            {{ $data->appends( Request::all() )->links() }}
            @if($data->count() == 0)
                <div class="alert alert-primary text-center">
                    <i class="fe fe-alert-triangle mr-2"></i> @lang('No users found')
                </div>
            @endif
        </div>

    </div>
    @include('user::users.email-modal')
@stop

@push('scripts')
    <script type="text/javascript">
        var allUsers = false;
        $("#usersTable").find('input[type=checkbox]').prop('checked', true);

        $('.check-all').click(function (e) {
            allUsers = false;
            var table = $(e.target).closest('table');
            $('td input:checkbox', table).prop('checked', this.checked);
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
                        url: "{{ route('users.email.send') }}",
                        data: {
                            ids: ids,
                            subject: subject,
                            description: String(textareaValue),
                            is_all: allUsers
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
            allUsers = false;
            $("#modalEmailTemplate").modal("show");
        });

        $(".btn-send-all-email").click(function () {
            allUsers = true;
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