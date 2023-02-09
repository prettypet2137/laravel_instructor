@extends('core::layouts.app')
@section('title', __('Guests'))
@section('content')
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">@lang('Guests')</h1>
      <form method="get" action="" class="my-3 my-lg-0 navbar-search">
          <div class="input-group">
              <input type="text" name="query" value="{{ \Request::get('query', '') }}" class="form-control bg-light border-0 small" placeholder="@lang('Search')" aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">
                      <i class="fas fa-search fa-sm"></i>
                  </button>
              </div>
          </div>
      </form>
  </div>
  @if($guests->count() > 0)
  <div class="row">
      <div class="col-sm-12">
          <div class="card">
              <table class="table card-table table-vcenter text-nowrap">
                  <thead class="thead-dark">
                      <tr>
                          <th>@lang('Event')</th>
                          <th>@lang('Fullname')</th>
                          <th>@lang('Email')</th>
                          <th>@lang('Phone')</th>
                          <th>@lang('Gender')</th>
                          <th>@lang('Submit at')</th>
                          <th>@lang('Actions')</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                    @foreach($guests as $guest)
                      <tr>
                          
                          <td>
                            <a href="{{ route('events.edit', ['id' => $guest->event_id]) }}">{{ $guest->event->name }}</a>
                          </td>
                          <td>
                            {{ $guest->fullname }}
                          </td>
                          <td>
                            {{ $guest->email }}
                          </td>
                          <td>
                            {{ $guest->phone }}
                          </td>
                          <td>
                            @if($guest->gender)
                                @lang('Male')
                            @else
                                @lang('Female')
                            @endif
                          </td>
                          <td>
                            {{ $guest->created_at }}
                          </td>
                          <td>
                            <form class="d-inline-block form-delete" action="{{ route('guests.delete', ['id' => $guest->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger btn-delete">@lang('Delete')</button>
                            </form>
                          </td>
                          <td>
                            <a href="javascript:void(0);" class="btn btn-default btn-detail-panel" data-target="#detail_panel_{{ $guest->id }}">@lang('View') <i class="fas fa-chevron-down"></i></a>
                          </td>
                      </tr>
                      <tr id="detail_panel_{{ $guest->id }}" class="detail-panel">
                        <td colspan="8">
                          <div>
                            @if(count($guest->info_items) > 0)
                              @php 
                                $tmp_len = count($guest->info_items['name']);
                              @endphp
                              @for($i = 0; $i < $tmp_len; $i++)
                                <p>
                                  <span>{{ $guest->info_items['name'][$i] }}</span>&nbsp;&nbsp;&nbsp;&nbsp;
                                  @switch($guest->info_items['data_type'][$i])
                                    @case('text')
                                        <strong><i>{{ $guest->info_items['submit'][$i] }}</i></strong>
                                        @break

                                    @case('textarea')
                                        <strong><i>{{ $guest->info_items['submit'][$i] }}</i></strong>
                                        @break

                                    @case('select')
                                        <strong><i>{{ $guest->info_items['submit'][$i] }}</i></strong>
                                        @break
                                    @default
                                  @endswitch
                                </p>
                              @endfor
                            @endif
                          </div>
                        </td>
                      <tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
          <div class="mt-4">
              {{ $guests->appends( Request::all() )->links() }}
          </div>
      </div>
  </div>
  @endif
  @if($guests->count() == 0)
  <div class="row">
      <div class="col-lg-12">
          <div class="text-center">
              <div class="error mx-auto mb-3">
                <i class="fas fa-user-friends"></i>
              </div>
              <p class="lead text-gray-800">@lang('Not Found')</p>
              <p class="text-gray-500">@lang("You don't have any guests").</p>
          </div>
      </div>
  </div>
  @endif
@stop

@push('head')
<link rel="stylesheet" href="{{ Module::asset('events:css/styles.css') }}" />
@endpush

@push('scripts')
<script src="{{ Module::asset('events:js/guests/index.js') }}"></script>
@endpush