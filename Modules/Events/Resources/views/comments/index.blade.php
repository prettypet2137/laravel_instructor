@extends('core::layouts.app')
@section('title', __('User Comments'))
@push('head')
    <style>
        .cut-text {
            text-overflow: ellipsis;
            overflow: hidden;
            white-space: nowrap;
        }
    </style>
@endpush
@section('content')
    <div class="comments-container">
        <div class="d-sm-flex align-items-center justify-content-between mb-2">
            <h1 class="h3 text-gray-800">@lang('User Comments')</h1>
            <div class="ml-auto d-sm-flex">
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
        </div>
        @if($comments->count() > 0)
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <table class="table card-table table-vcenter text-nowrap">
                            <thead class="thead-dark">
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Email')</th>
                                <th style="width: 400px;">@lang('Description')</th>
                                <th>@lang('Actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr>
                                    <td>
                                        {{ $comment->name }}
                                    </td>
                                    <td>
                                        {{ $comment->email }}
                                    </td>
                                    <td class="cut-text">
                                        {{ $comment->description }}
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-name="{{$comment->name}}"
                                           data-email="{{$comment->email}}" data-description="{{$comment->description}}"
                                           class="btn btn-sm btn-secondary btn-detail mr-1">@lang('Details')</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $comments->appends( Request::all() )->links() }}
                    </div>
                </div>
            </div>
        @endif    
    </div>
    
    @if($comments->count() == 0)
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <div class="error mx-auto mb-3"><i class="fas fa-calendar-day"></i></div>
                    <p class="lead text-gray-800">@lang('Not Found')</p>
                    <p class="text-gray-500">@lang("You don't have any comment")</p>
                </div>
            </div>
        </div>
    @endif
    @include('events::comments.detail')
@stop

@push('scripts')
    <script src="{{ Module::asset('comments:js/comments/index.js') }}"></script>
    <script>
        $(document).on("click", ".btn-detail", function () {
            var name = $(this).data("name");
            var email = $(this).data("email");
            var description = $(this).data("description");
            $("#modalDetail").modal("show");
            $(".data-name").text(name);
            $(".data-email").text(email);
            $(".data-description").text(description);
        });
    </script>
@endpush