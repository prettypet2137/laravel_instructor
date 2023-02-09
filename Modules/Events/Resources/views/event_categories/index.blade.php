@extends('core::layouts.app')
@section('title', __('Events'))
@push('head')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <style>
        table.dataTable td {text-overflow: clip;overflow: hidden;}
        table.dataTable td > * {vertical-align: sub;}
        .child > .dtr-details {width: 100%;}
        tbody .dropdown-toggle {border-radius: 50%;height: 30px;width: 30px;padding: 0px;border-color: #3b7ddd;}
        tbody .dropdown-toggle:hover {color: #fafafa;}
    </style>
@endpush
@section('content')
<div>
    <h1 class="h3 text-gray-800 mb-3">@lang('Event Categories')</h1>
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <div class="d-flex flex-column mb-2">
            <div class="d-flex justify-content-start">
                <button class="btn btn-primary add_category_btn"><i class="fa fa-plus"></i> New Category</button>
            </div>
        </div>
        <div class="ml-auto d-sm-flex">
            <form method="get" action="" class="navbar-search">
                <div class="input-group">
                    <input type="text" name="query" value="{{ \Request::get('query', '') }}"
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
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="display: block; width: 100%">
                <table id="category_table" class="table table-striped table-bordered dt-responsive nowrap desktop" style="width: 100%">
                    <thead class="thead-dark">
                        <tr>
                            <th width="40">No</th>
                            <th>Name</th>
                            <th>Iframe Code</th>
                            <th width="60">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($categories->count())
                            @php $no = 1; @endphp
                            @foreach ($categories as $category)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <code class="language-html" style="padding: 6px 8px; border: 1px solid #dddddd">&lt;iframe src="{{ route('category-events.index', ['name' => getSlugName(auth()->user()->name), 'id' => $category->id ]) }}" style="width: 100%; min-height: 100vh;"&gt;&lt;/iframe&gt;</code>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm copy-btn">
                                        <i class="fa fa-clipboard"></i> Copy
                                    </button>
                                    <button class="btn btn-success btn-sm edit-btn" 
                                        data-name="{{ $category->name }}" 
                                        data-id="{{ $category->id }}">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm remove-btn"
                                        data-id="{{ $category->id }}">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal create_category_modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Category</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="{{ route('categories.store') }}" method="post">
                    <div class="modal-content">
                        <div class="modal-body">
                            @csrf
                            <label>Category Name:</label>
                            <input class="form-control" type="text" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Create</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal edit_category_modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-content">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <label>Category Name:</label>
                            <input class="form-control" type="text" name="name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal remove_category_modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <form action="" method="post">
                    <div class="modal-content">
                        <div class="modal-body">
                            @csrf
                            @method('DELETE')
                            Once you delete it, you can not revert again.
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-trash"></i> Delete</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection
@push('scripts')
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/responsive-datatables/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/responsive-datatables/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        var BASE_URL = "{{ url('/') }}";
        var _token = "{{ csrf_token() }}";
        $(document).ready(function() {
            $("#category_table").DataTable({
                responsive: true,
                searching: false,
                lengthChange: false,
                paging: false,
                info: false
            });

            $(".add_category_btn").click(function() {
                $(".create_category_modal").modal("show");
            });

            $("#category_table").on("click", ".copy-btn", function() {
                var $temp = $("<input id='html-content' type='text'>");
                $("body").append($temp);
                var content = $(this).closest("td").prev("td").find(".language-html").text();
                $("#html-content").val(content).select();
                var input = document.getElementById("html-content");
                input.focus();
                input.select();
                document.execCommand("copy");
                $("#html-content").remove();
                toastr.success("Copied sucessfully.", "Success !");
            });
            $("#category_table").on("click", ".edit-btn", function() {
                var id = $(this).data("id");
                var name = $(this).data("name");

                $(".edit_category_modal form").attr("action", `${BASE_URL}/categories/${id}`);
                $(".edit_category_modal input[name='name']").val(name);
                $(".edit_category_modal").modal("show");
            });
            $("#category_table").on("click", ".remove-btn", function() {
                var id = $(this).data("id");
                $(".remove_category_modal form").attr("action", `${BASE_URL}/categories/${id}`);
                $(".remove_category_modal").modal("show");
            });
        });
    </script>
@endpush