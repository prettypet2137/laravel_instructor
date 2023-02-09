@extends('core::layouts.app')
@section('title', __('Blogs'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-2">
  <h1 class="h3 mb-4 text-gray-800">@lang('Blogs')</h1>
  <div class="ml-auto d-sm-flex">
    <form method="get" action="" class="navbar-search mr-4">
        <div class="input-group">
            <input type="text" name="search" value="{{ \Request::get('search', '') }}" class="form-control bg-light border-0 small" placeholder="@lang('Search blog')" aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>
    <a href="{{ route('settings.blogs.create') }}" class="btn btn-success">
      <i class="fas fa-plus"></i> @lang('Create blog')
    </a>
  </div>
</div>

<div class="row">
      <div class="col-md-3">
          @include('core::partials.admin-sidebar')
      </div>
      <div class="col-md-9">
        @if($data->count() > 0)
            <div class="card">
                <div class="table-responsive">
                     <table class="table card-table table-vcenter text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Category')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('Thumb')</th>
                                <th>@lang('Read times')</th>
                                <th>@lang('Created at')</th>
                                <th></th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>            
                            @foreach($data as $item)
                            <tr>
                               <td>
                                   <small>{{ $item->category->name }}</small>
                               </td>
                               <td>
                                   <small>{{ $item->title }}</small>
                               </td>
                               <td>
                                  <img src="{{ $item->getThumbLink() }}" alt="{{ $item->title }}" width="50" height="50" />
                               </td>
                               <td>
                                <small>{{ $item->time_read }}</small>
                               </td>
                               <td>
                                <small>{{ $item->created_at }}</small>
                               </td>
                               <td>
                                  @if($item->is_active)
                                      <span class="small text-success"><i class="fas fa-check-circle"></i> @lang('Active')</span>
                                  @else
                                      <span class="small text-danger"><i class="fas fa-times-circle"></i> @lang('No Active')</span>
                                  @endif
                                  <br>
                                  @if($item->is_featured)
                                      <span class="small text-primary"><i class="fas fa-check-circle"></i> @lang('Featured')</span>
                                  @endif
                                </td>
                                <td>
                                  <div class="d-flex">
                                        <div class="p-1 ">
                                             <a href="{{ route('settings.blogs.edit', $item->id) }}" class="btn btn-sm btn-primary">@lang('Edit')</a>
                                        </div>
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('settings.blogs.destroy', $item->id) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger btn-clean">
                                                        @lang('Delete')
                                                    </button>
                                                </form>
                                        </div>
                                    </div>
                              </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div class="mt-4">
            {{ $data->appends( Request::all() )->links() }}
        </div>
        @if($data->count() == 0)
        <div class="text-center">
          <div class="error mx-auto mb-3"><i class="fas fa-briefcase"></i></div>
          <p class="lead text-gray-800">@lang('No blog Found')</p>
          <p class="text-gray-500">@lang("You don't have any blog").</p>
          <a href="{{ route('settings.blogs.create')}}" class="btn btn-primary">
            <span class="text">@lang('New blog')</span>
          </a>
        </div>
        @endif
    </div>
</div>


@stop