@extends('core::layouts.app')
@push('head')
<style>
    .admin-sidebar {
        flex-basis: 240px;
    }
    .admin-content {
        flex: 1;
    }
    .admin-content .video {
        border: 1px solid #cccccc;
        margin-bottom: 20px;
    }
    .admin-content .video-info {
        padding: 5px 15px 10px;
    }
    .admin-content .video-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .admin-content .video-description {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .btn-outline-primary {
        border-radius: 50%;
        border-color: #168ae6;
        padding: 0px;
        width: 25px;
        height: 24px;
    }
    .btn-outline-danger {
        border-radius: 50%;
        border-color: #e74a3b;
        padding: 0px;
        width: 25px;
        height: 24px;
    }
    .video-actions {
        padding-top: 10px;
        text-align: right;
    }
    .btn-outline-primary:hover,
    .btn-outline-danger:hover {
        color: #fafafa;
    }
</style>
@endpush
@section('title', __('Settings'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
     <h1 class="h3 mb-0 text-gray-800">@lang('General settings')</h1>
</div>
<div class="d-flex">
    <div class="admin-sidebar">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="admin-content">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    Instruction Video
                    <button class="btn btn-primary btn-sm float-right" id="add_video_btn"><i class="fa fa-plus"></i> Add New</button>
                </h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        @foreach ($videos as $video)
                        <div class="col-lg-4 col-md-6">
                            <div class="video">
                                <iframe width="100%" height="240" src="{{ $video->link }}"></iframe>
                                <div class="video-info">
                                    <h5 class="video-title">{{ $video->title }}</h5>
                                    <div class="video-description">{!! $video->description !!}</div>
                                    <div class="video-actions">
                                        <button class="btn btn-sm btn-outline-primary edit_video_btn" data-id="{{ $video->id }}"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-sm btn-outline-danger delete_video_btn" data-id="{{ $video->id }}"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new_video_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('settings.video.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group required">
                            <label>Video Link:</label>
                            <input type="text" class="form-control" name="link"/>
                        </div>
                        <div class="form-group required">
                            <label>Video Title:</label>
                            <input type="text" class="form-control" name="title"/>
                        </div>
                        <div class="form-group">
                            <label>Video Description:</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_video_modal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group required">
                            <label>Video Link:</label>
                            <input type="text" class="form-control" name="link"/>
                        </div>
                        <div class="form-group required">
                            <label>Video Title:</label>
                            <input type="text" class="form-control" name="title"/>
                        </div>
                        <div class="form-group">
                            <label>Video Description:</label>
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form id="delete_video_form" action="" method="post">
        @csrf
        @method("delete")
    </form>
</div>
@stop
@push('scripts')
<script>
    $(document).ready(function() {
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

        $("#add_video_btn").click(function() {
            $("#new_video_modal").modal("show");
        });
        $(".edit_video_btn").click(function() {
            var id = $(this).data("id");
            $.ajax({
                type: "GET",
                url: BASE_URL + "/settings/video/" + id
            }).then(function(video) {
                $("#edit_video_modal form").attr("action", BASE_URL + "/settings/video/" + id);
                $("#edit_video_modal [name='link']").val(video.link);
                $("#edit_video_modal [name='title']").val(video.title);
                tinymce.activeEditor.setContent(video.description ? video.description : "");
                $("#edit_video_modal").modal("show");
            });
        });
        $(".delete_video_btn").click(function() {
            var id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: '<i class="fa fa-times"></i> Cancel',
                confirmButtonText: '<i class="fa fa-trash"></i> Delete'
            }).then(function(res) {
                if (res.value) {
                    $("#delete_video_form").attr("action", BASE_URL + "/settings/video/" + id);
                    $("#delete_video_form").submit();
                }
            });
        })
    });
</script>
@endpush