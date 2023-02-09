@extends('core::layouts.app')
@section('title', __('About'))
@section('content')
    <div class="d-sm-flex justify-content-between mb-2">
        <h1 class="h3 text-gray-800">@lang('About')</h1>
        @if(empty($about))
            <a class="btn btn-success" href="#" data-toggle="modal"
               data-target="#createAboutModal">@lang('Add About')</a>
        @endif
    </div>
    @if(!empty($about))
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">@lang('Description'):</h4>
                    </div>
                    <div class="card-body pl-4 py-2">
                        {!! $about->description !!}
                    </div>
                    <div class="card-footer">
                        <p>
                            <a class="btn btn-success" href="#" data-toggle="modal"
                               data-target="#editAboutModal">@lang('Edit About')</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @include('events::events.about-modal')
@stop

@push('scripts')
    <script src="{{ Module::asset('events:js/events/index.js') }}"></script>
    <script>
        $("#editAboutModal,#createAboutModal").on("hidden.bs.modal", function (e) {
            $('#description').val('')
            tinymce.get('description').setContent('');
        });
        // init editor
        (function () {
            tinymce.init({
                selector: "textarea#add_description",
                height: "350px",
                plugins: "codesample fullscreen hr image imagetools link lists",
                toolbar:
                    "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | link codesample hr | bullist numlist checklist",
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
                selector: "textarea#edit_description",
                height: "250px",
                plugins: "codesample fullscreen hr image imagetools link lists",
                toolbar:
                    "styleselect | fullscreen | bold italic underline strikethrough forecolor backcolor | link codesample hr | bullist numlist checklist",
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