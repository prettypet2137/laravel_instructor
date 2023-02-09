@extends('core::layouts.app')
@push('head')
<link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}"/>
@endpush
@section('title', __('Guests'))
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">@lang('Guests')</h1>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="users-table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>@lang('Event')</th>
                        <th>@lang('Email')</th>
                        <th class="no-sort">@lang('Ticket')</th>
                        <th>@lang('Paid')</th>
                        <th>@lang('Gateway')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Register at')</th>
                        <th width="70" class="no-sort">@lang('Action')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="modalDetail" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title data-guest-fullname"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>@lang('Full name')</strong>: <span class="data-guest-fullname"></span></p>
                    <p><strong>@lang('Event name')</strong>: <span class="data-event-name"></span></p>
                    <p><strong>@lang('Email')</strong>: <span class="data-guest-email"></span></p>
                    <p><strong>@lang('Status')</strong>: <span class="data-guest-status"></span></p>
                    <p><strong>@lang('Registered at')</strong>: <span class="data-guest-registered"></span></p>
                    <p><strong>@lang('Joined at')</strong>: <span class="data-guest-joined"></span></p>
                    <p><strong>@lang('Ticket')</strong>: <span class="data-guest-ticket"></span></p>
                    <div><strong>@lang('Upsell')</strong>: <div class="data-upsell"></div></div>
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong class="pb-2">@lang('QR Code for checkin')</strong>:</p>
                            <p><span class="data-qr-code" style="display: inline-block"></span></p>
                        </div>
                        <div class="col-md-8">
                            <button type="button" class="btn btn-sm btn-primary mt-3 confirm_ticket_btn"><i class="fa fa-check"></i> Confirmation ticket</button>
                        </div>
                    </div>
                    <div class="data-guest-info-items"></div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalTransfer" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer the Guest to Other Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('guests.transfer_guests')}}" class="navbar-search">
                        @csrf
                        <div class="select-div"></div>
                        <button class="btn btn-primary btn-sm" type="submit">
                            Submit
                        </button>
                    </form>
                    <p><span class="data-qr-code"></span></p>
                    <div class="data-guest-info-items"></div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('head')
    <link rel="stylesheet" href="{{ Module::asset('events:css/styles.css') }}"/>
@endpush

@push('scripts')
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script>
        var token = '{{ csrf_token() }}';
        var guests_route = "{{ url('guests/delete') }}";
        var datatable_url = "{{ route('guests.data',['event'=>request()->get('event')]) }}";
        var guests_switch_status_url = "{{ route('guests.switch_status', ['id' => ':id']) }}";
        var guests_switch_paid_url = "{{ route('guests.switch_paid', ['id' => ':id']) }}";
        var guests_get_detail_url = "{{ route('guests.get_detail', ['id' => ':id']) }}";
        var guests_get_events_url = "{{ route('guests.get_events', ['id' => ':eventId']) }}";
        var event_options = "";
        var guest_url = "{{route('guests.index',['event'=>request()->get('event')])}}"
        @foreach($events as $event)
            event_options += `<option value="{{ $event->id }}" data-event-name="{{$event->name}}" {{ !empty(request()->get('event') && $event->name == request()->get('event')) ? 'selected' : '' }}>{{ $event->name }}</option>`;
        @endforeach
    </script>
    <script src="{{ Module::asset('events:js/guests/datatable.js') }}"></script>
@endpush
