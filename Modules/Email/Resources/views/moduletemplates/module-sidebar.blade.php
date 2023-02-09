<li class="nav-item {{ (request()->is('email*')) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseEmail" aria-expanded="false"
       aria-controls="collapseTwo">
        <i class="fa fa-envelope"></i>
        <span>@lang('Email')</span>
    </a>
    <div id="collapseEmail" class="collapse {{ (request()->is('email*')) ? 'show' : '' }}"
         aria-labelledby="collapseEvents">
         <div class="py-2 collapse-inner rounded">
            @can('user')
                <a class="collapse-item email-templates-link {{routeName() == 'email.user.templates.index' ? 'active' : ''}}"
                    href="{{ route('email.user.templates.index') }}">@lang('Email Templates')</a>
                <!--<a class="collapse-item"-->
                <!--    href="{{ route('email.user.histories.index') }}">@lang('Email Histories')</a>-->
            @else
                <a class="collapse-item {{routeName() == 'email.admin.templates.index' ? 'active' : ''}}"
                    href="{{ route('email.admin.templates.index') }}">@lang('Email Templates')</a>
            @endcan
        </div>
    </div>
</li>
