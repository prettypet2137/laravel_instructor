@extends('core::layouts.app')
@section('title', __('Events'))
@push('head')
    <link rel="stylesheet" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/responsive-datatables/css/responsive.bootstrap4.min.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"/>
    <style>
        table.dataTable td {
            text-overflow: clip;
            /* overflow: hidden; */
            overflow: inherit;
        }
        .child > .dtr-details {
            width: 100%;
        }
        .copyButton {
            position:absolute;
            top:5px;
            right:5px;
            font-size:.9rem;
            padding:.15rem;
            background-color:#828282;
            color:1e1e1e;
            border:ridge 1px #7b7b7c;
            border-radius:5px;
            text-shadow:#c4c4c4 0 0 2px;
        }
        .copyButton:hover{
            cursor:pointer;
            background-color:#bcbabb;
        }
        tbody .dropdown-toggle {
            border-radius: 50%;
            height: 30px;
            width: 30px;
            padding: 0px;
            border-color: #3b7ddd;
        }
        tbody .dropdown-toggle:hover {
            color: #fafafa;
        }
        tbody td {
            vertical-align: middle !important;
        }
        tbody td.break-line {
            white-space: normal !important;
            word-break: break-all;
        }
    </style>
@endpush
@section('content')
    @php $user = auth()->user(); @endphp
    <div class="d-sm-flex align-items-center justify-content-between mb-2">
        <div class="d-flex flex-column mb-2 iframe-done-container">
            <div class="d-flex justify-content-start">
                <h1 class="h3 text-gray-800">@lang('Events')</h1>
                <a href="#" data-toggle="modal" data-target="#iframeEventModal"
                   class="btn btn-info ml-2 mb-2">@lang('Iframe Code Copier')</a>
            </div>
            <a href="{{ route('all-events.index',['name' => getSlugName(auth()->user()->name)]) }}" target="_blank"
               title="Events Landing Page">{{ route('all-events.index',['name' => getSlugName(auth()->user()->name)]) }}</a>
        </div>
        <div class="ml-auto d-sm-flex">
            <form method="get" action="" class="navbar-search mr-4">
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
    @if($events->count() > 0)
        <div class="row">
            <div class="col-sm-12">
                <div class="display: block; width: 100%">
                <table id="event_table" class="table table-striped table-bordered dt-responsive nowrap desktop text-center" style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Event Start Date')</th>
                        <th style="width: 8.5%">@lang('Type')</th>
                        <th style="width: 8.5%">@lang('Seats')</th>
                        <th style="width: 5%">@lang('Registered')</th>
                        <th style="width: 4%">@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>
                                {{ $event->name }}
                            </td>
                            <td>
                                @isset($event->start_date)
                                    {{ $event->start_date->format('Y-m-d H:i:s') }}
                                @endisset
                            </td>
                            <td>
                                @php
                                    $tmp_type = '';
                                    switch($event->type){
                                        case 'ONLINE':
                                            $tmp_type = __('Online');
                                            break;
                                        case 'OFFLINE':
                                            $tmp_type = __('Offline');
                                            break;
                                        default:
                                            $tmp_type = '';
                                            break;
                                    }
                                @endphp
                                {{ $tmp_type }}
                            </td>
                            <td>
                                @if($event->quantity == -1)
                                    unlimited
                                @else
                                    {{  $event->available_seats.'/'.$event->quantity }}
                                @endif
                            </td>
                            <td>
                                {{$event->registered}}
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                        <i class="fa fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('events.edit', ['id' => $event->id]) }}">
                                            <i class="fa fa-edit"></i> Event Edit
                                        </a>
                                        <a class="dropdown-item" href="{{ route('tracklink.show', ['target_class' => 'event', 'target_id' => $event->id]) }}">
                                            <i class="fa fa-chart-bar"></i> Event Statistics
                                        </a>
                                        @if (!$event->is_recur)
                                        <a class="dropdown-item delete_btn" href="javascript:void(0);" data-id="{{ $event->id }}">
                                            <i class="fa fa-trash"></i> Event Delete
                                        </a>
                                        @endif
                                        <a class="dropdown-item" href="{{ route('guests.index', ['event' => $event->name]) }}">
                                            <i class="fa fa-user-graduate"></i> Students
                                        </a>
                                        <a class="dropdown-item duplicate_event_btn" href="javascript:void(0);">
                                            <i class="fa fa-clone"></i> Event Duplication
                                        </a>
                                        <a class="dropdown-item" href="{{ route('events.sales-review', ['id' => $event->id]) }}">
                                            <i class="fa fa-coins"></i> Event Sale
                                        </a>
                                        <a class="dropdown-item" href="{{ $event->getPublicUrl() }}" target="_blank" alt="{{ $event->name }}">
                                            <i class="fa fa-link"></i> @lang('Event URL')</a>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal duplicate_modal fade" role="dialog">
                                    <div class="modal-dialog">
                                        <form class="d-inline-block"
                                                action="{{ route('events.copy', ['id' => $event->id]) }}"
                                                method="post">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    @csrf
                                                    <label>How many copies of this event you want to make?</label>
                                                    <input class="form-control" type="number" value=1 min="1" name="number"
                                                            required>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Create</button>
                                                    <button type="button" class="btn btn-warning"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <form class="delete_form" action="{{ route('events.delete', ['id' => 0]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                </div>
                <div class="mt-2 d-flex justify-content-center">
                    {{ $events->appends( Request::all() )->links() }}
                </div>
            </div>
        </div>
    @endif
    @if($events->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="error mx-auto mb-3"><i class="fas fa-calendar-day"></i></div>
                    <p class="lead text-gray-800">@lang('Not Found')</p>
                    <p class="text-gray-500">@lang("You don't have any event")</p>
                </div>
            </div>
        </div>
    @endif
    @include('events::events.iframe-modal')
@stop

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
            $("#event_table").DataTable({
                "responsive": true,
                "searching": false,
                "lengthChange": false,
                "paging": false,
                "info": false
            });
            $(".duplicate_event_btn").click(function() {
                $(this).closest("td").find(".duplicate_modal").modal("show");
            })
            $("#event_table").on("click", ".delete_btn", function() {
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
                        $(".delete_form").attr("action", BASE_URL + "/events/" + id);
                        $(".delete_form").submit();
                    }
                });
            });
            $(".clipboard-btn").click(function() {
                var $temp = $("<input id='html-content' type='text'>");
                $("body").append($temp);
                var content = $(".language-html").text();
                $("#html-content").val(content).select();
                var input = document.getElementById("html-content");
                input.focus();
                input.select();
                document.execCommand("copy");
                $("#html-content").remove();
                toastr.success("Copied sucessfully.", "Success !");
            });
            $("input[name='is_show_about_us_form']").change(function() {
                var checked = $(this).prop("checked");
                $.ajax({
                    type: "POST",
                    url: BASE_URL + "/events/setting/show-form",
                    data: {
                        _token: _token,
                        _method: "PUT",
                        is_show_about_us_form: checked ? 1 : 0
                    }
                }).then(function(res) {
                    toastr.success("Set the option successfully.", "Success !");
                });
            });
            $("input[name='is_show_contact_us_form']").change(function() {
                var checked = $(this).prop("checked");
                $.ajax({
                    type: "POST",
                    url: BASE_URL + "/events/setting/show-form",
                    data: {
                        _token: _token,
                        _method: "PUT",
                        is_show_contact_us_form: checked ? 1 : 0
                    }
                }).then(function(res) {
                    toastr.success("Set the option successfully.", "Success !");
                });
            });
        });
    </script>
@endpush