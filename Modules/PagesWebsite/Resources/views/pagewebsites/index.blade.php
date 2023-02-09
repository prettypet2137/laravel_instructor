

@extends('core::layouts.app')
@section('title', __('Pages Website'))
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Pages Website')</h1>
    <a href="{{ route('settings.pagewebsites.create') }}" class="btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> @lang('Create')</a>
</div>

<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <div class="row mb-2">
          <div class="col-sm-12">
              <small>@lang('All the page links will be displayed in the footer menu of the website home page')</small>
          </div>
        </div>
        @if($data->count() > 0)
            <div class="card">
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-nowrap">
                        <thead class="thead-dark">
                            <tr>
                                <th>@lang('Title')</th>
                                <th>@lang('Active')</th>
                                <th>@lang('Date Created')</th>
                                <th>@lang('Date Modified')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $item)
                            <tr>
                                <td>

                                    <a href="{{ route('settings.pagewebsites.edit', $item->id) }}">{{ $item->title }}</a>
                                </td>
                                 <td>
                                    @if($item->is_active)
                                        <span class="badge badge-success">@lang('Active')</span>
                                    @else
                                        <span class="badge badge-warning">@lang('Not Active')</span>
                                    @endif
                                    
                                </td>
                               <td>
                               
                                <div class="small text-muted">
                                        {{$item->created_at->format('M j, Y')}}
                                </div>
                                </td>
                                <td>
                                        <div class="small text-muted">
                                                {{$item->updated_at->format('M j, Y')}}
                                        </div>
                                </td>
                                
                                <td>
                                     <div class="d-flex">
                                        <div class="p-1 ">
                                             <a href="{{ route('settings.pagewebsites.edit', $item->id) }}" class="btn btn-sm btn-primary">@lang('Edit')</a>
                                        </div>
                                        <div class="p-1 ">
                                                <form method="post" action="{{ route('settings.pagewebsites.destroy', $item->id) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
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
        <div class="alert alert-primary text-center">
            <i class="fe fe-alert-triangle mr-2"></i> @lang('No page found')
        </div>
        @endif
    </div>
    
</div>

@stop