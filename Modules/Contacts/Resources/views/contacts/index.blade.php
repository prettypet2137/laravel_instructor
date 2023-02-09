@extends('core::layouts.app')
@section('title', __('Contacts'))
@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">@lang('Contacts')</h1>
</div>
<div class="row">
    <div class="col-md-3">
        @include('core::partials.admin-sidebar')
    </div>
    <div class="col-md-9">
        <div class="row">
            <div class="col-md-12">
                @if($data->count() > 0)
                <div class="card">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap">
                            <thead class="thead-dark">
                                <tr>
                                    <th>@lang('Fullname')</th>
                                    <th>@lang('Info')</th>
                                    <th>@lang('Created at')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $item)
                                <tr>
                                    <td>
                                        <small>
                                            @if($item->is_readed)
                                            {{ $item->fullname }}
                                            @else
                                            <strong>{{ $item->fullname }}</strong>
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <small><label>@lang('Phone')</label> <a href="tel:{{ $item->phone }}">{{ $item->phone }}</a></small><br />
                                        <small><label>@lang('Email')</label> <a href="mailto:{{ $item->email }}">{{ $item->email }}</a></small>
                                    </td>
                                    <td>
                                        <small>{{ $item->created_at }}</small>
                                    </td>
                                
                                    <td>
                                        <div class="d-flex">
                                            <div class="p-1">
                                                <small><a href="javascript:void(0);" class="btn btn-sm btn-primary btn-show-content" data-id="{{ $item->id }}">@lang('Detail')</a></small>
                                            </div>
                                            <div class="p-1 ">
                                                <form method="post" action="{{ route('settings.contacts.destroy', $item->id) }}" onsubmit="return confirm('@lang('Confirm delete?')');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">@lang('Delete')</button>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <div id="modal_{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ $item->subject }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{ $item->content }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
                <div class="mt-4">
                    {{ $data->appends( Request::all() )->links() }}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                @if($data->count() == 0)
                <div class="text-center">
                    <div class="error mx-auto mb-3"><i class="fas fa-briefcase"></i></div>
                    <p class="lead text-gray-800">@lang('No contact Found')</p>
                    <p class="text-gray-500">@lang("You don't have any contact").</p>
                </div>
                @endif
            </div>
        </div>
    </div>

</div>



@stop

@push('scripts')
<script>
    const URL_POST_READED_AJAX = "{{ route('settings.contacts.ajaxreaded') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
</script>
<script src="{{ Module::asset('contacts:js/contacts.js') }}"></script>
@endpush