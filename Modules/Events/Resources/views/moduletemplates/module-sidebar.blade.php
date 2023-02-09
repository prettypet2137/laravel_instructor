<li class="nav-item {{ (request()->is('all-events.comment.index')) ? 'active' : '' }}" data-target="comment-tour">
    <a class="nav-link comment-link" href="{{ route('all-events.comment.index') }}">
        <i class="fas fa-comment-alt"></i>
        <span>@lang('Comments')</span></a>
</li>

<li class="nav-item {{ (request()->is('categories*')) ? 'active' : '' }}" data-target="event-category-tour">
    <a class="nav-link collapsed event-category-navlink" href="{{ route('categories.index') }}">
        <i class="fa fa-list"></i>
        <span>@lang('Event Categories')</span>
    </a>
</li>

<li class="nav-item {{ (request()->is('events*')) ? 'active' : '' }}" data-target="event-tour">
    <a class="nav-link collapsed my-event-link" href="#" data-toggle="collapse" data-target="#collapseEvents" aria-expanded="false"
       aria-controls="collapseTwo">
        <i class="fas fa-calendar-day"></i>
        <span>@lang('My Events')</span>
    </a>
    <div id="collapseEvents" class="collapse {{ (request()->is('events*')) ? 'show' : '' }}"
         aria-labelledby="collapseEvents">
        <div class="py-2 collapse-inner rounded">
            <a class="collapse-item all-events-link {{ routeName() == 'events.index' ? 'active' : '' }}"
               href="{{ route('events.index') }}">@lang('All events')</a>
            <a class="collapse-item" href="#" data-toggle="modal" data-target="#createModal">@lang('Create event')</a>
        </div>
    </div>
</li>

<li class="nav-item {{ (request()->is('guests')) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEventGuests"
       aria-expanded="false" aria-controls="collapseTwo">
        <i class="fas fa-user-friends"></i>
        <span>@lang('Guests')</span>
    </a>
    <div id="collapseEventGuests" class="collapse {{ (request()->is('guests')) ? 'show' : '' }}"
         aria-labelledby="collapseEventGuests">
        <div class="py-2 collapse-inner rounded">
            <a class="collapse-item all-guests-link {{ routeName() == 'guests.index' ? 'active' : '' }}"
               href="{{ route('guests.index') }}">@lang('All guests')</a>
            <a class="collapse-item {{ routeName() == 'guests.email' ? 'active' : '' }}"
               href="{{ route('guests.email') }}">@lang('Email')</a>
        </div>
    </div>
</li>