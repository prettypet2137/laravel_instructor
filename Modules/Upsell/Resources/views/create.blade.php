@extends('core::layouts.app')
@section('title', __('SMS Templates'))
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}" />
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.css') }}"/>
<style>
    .dataTables_length select{
        min-width: 65px !important;
    }
    .image-preview-container {
        width: 100%;
        height: 160px;
        margin-right: auto;
        border: 2px solid #cccccc;
        padding: 4px;
    }
    .image-preview-content {
        width: 100%;
        height: 100%;
        background-color: #333333;
        border: 1px solid #cccccc;
        position: relative;
    }
    .image-preview-mask {
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .btn-outline-default {
        color: #fafafa;
        border-color: #fafafa;
    }
    .btn-outline-default:hover, .btn-outline-default:active {
        color: #ffffff;
    }
</style>
@endpush
@section('content')
<div class="mb-2">
    <form class="form" action="{{ route('upsell.store') }}" enctype="multipart/form-data" method="POST"/>
        @csrf
        <div class="d-flex">
            <div style="flex-basis: 160px;" class="mr-3">
                <div class="form-group">
                    <div class="image-preview-container">
                        <div class="image-preview-content">
                            <div class="image-preview-mask">
                                <button type="button" class="btn btn-sm btn-outline-default" id="choose-image-btn">Choose Image</button>
                            </div>
                            <input type="file" name="image" class="d-none"/>
                        </div>
                    </div>
                </div>                
            </div>
            <div style="flex: 1">
                <div class="form-group">
                    <label>Title:</label>
                    <input type="text" class="form-control" name="title"/>
                </div>
                <div class="form-group form-price-group">
                    <label>Price:</label>
                    <div class="row price-row">
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="number" class="form-control" name="price[]"/>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary add_price_btn"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Description:</label>
            <textarea class="form-control tinymce" name="description"></textarea>
        </div>
        <div class="form-actions">
            <button class="btn btn-primary float-right"><i class="fa fa-save"></i> Save</button>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-switch/bootstrap4-toggle.min.js') }}"></script>
<script>
    $(document).ready(function() {
        tinymce.init({
            selector: "textarea",
            height: "500px",
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

        $("#choose-image-btn").click(function() {
            $("input[name='image']").click();
        });
        
        $("input[name='image']").change(function(ev) {
            var image = ev.target.files[0];
            var imageUrl = URL.createObjectURL(image);
            $(".image-preview-content").css({
                backgroundImage: "url(" + imageUrl + ")",
                backgroundSize: "contain",
                backgroundRepeat: "no-repeat",
                backgroundPosition: "center"
            });
        });

        $(".add_price_btn").click(function() {
            $(".price-row").append(`
                <div class="col-md-3">
                    <div class="input-group mb-3">
                        <input type="number" class="form-control" name="price[]" value=""/>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger delete_price_btn">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `);
        });
        $(".price-row").on("click", ".delete_price_btn", function() {
            $(this).closest(".col-md-3").remove();
        });
    });
</script>
@endpush