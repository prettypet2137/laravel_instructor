@extends('core::layouts.app')
@section('title', __('Categories'))
@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Categories')</h1>
    <a href="{{ route('settings.events.categories.create') }}" class="btn btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> @lang('Create')</a>
 </div>

  <div class="row">
        <div class="col-md-3">
            @include('core::partials.admin-sidebar')
        </div>
        <div class="col-md-9">
          @if($categories->count() > 0)
          <div class="card">
              <table class="table card-table table-vcenter text-nowrap">
                  <thead class="thead-dark">
                      <tr>
                          <th>@lang('Name')</th>
                          <th>@lang('Created at')</th>
                          <th>@lang('Actions')</th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($categories as $category)
                      <tr>
                          <td>
                            {{ $category->name }}
                          </td>
                          <td>
                            {{ $category->created_at }}
                          </td>
                          <td>
                              <a href="{{ route('settings.events.categories.edit', ['id' => $category->id, 'back_url' => \Request::fullUrl()]) }}" class="btn btn-primary">@lang('Edit')</a>
                              <form class="d-inline-block form-delete" action="{{ route('settings.events.categories.delete', ['id' => $category->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-delete">@lang('Delete')</button>
                              </form>
                          </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
          <div class="mt-4">
              {{ $categories->appends( Request::all() )->links() }}
          </div>
          @endif
          @if($categories->count() == 0)
                <div class="text-center">
                    <div class="error mx-auto mb-3"><i class="far fa-file-alt"></i></div>
                    <p class="lead text-gray-800">@lang('Not Found')</p>
                    <p class="text-gray-500">@lang("You don't have any item").</p>
                </div>
          @endif
      </div>
  </div>
 
  
 
@stop

@push('scripts')
<script src="{{ Module::asset('events:js/categories/index.js') }}"></script>
@endpush
