<li class="nav-item {{ (request()->is('sms*')) ? 'active' : '' }}">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSms" aria-expanded="false"
       aria-controls="collapseTwo">
        <i class="fa fa-comments"></i>
        <span>@lang('SMS')</span>
    </a>
    <div id="collapseSms" class="collapse {{ (request()->is('sms*')) ? 'show' : '' }}"
         aria-labelledby="collapseEvents">
        <div class="py-2 collapse-inner rounded">
            @can('user')
               <a class="collapse-item sms-templates-link {{ routeName() == 'sms.user.templates.index' ? 'active' : '' }}"
                   href="{{ route('sms.user.templates.index') }}">@lang('SMS Templates')</a>
                <!--<a class="collapse-item {{ routeName() == 'sms.user.histories.index' ? 'active' : '' }}"-->
                <!--   href="{{ route('sms.user.histories.index') }}">@lang('SMS Histories')</a>-->
            @else
                <a class="collapse-item {{ routeName() == 'sms.admin.setting.index' ? 'active' : '' }}"
                    href="{{ route('sms.admin.setting.index') }}">SMS Setting</a>
                <a class="collapse-item {{ routeName() == 'sms.admin.templates.index' ? 'active' : ''}}" 
                    href="{{ route('sms.admin.templates.index') }}">SMS Templates</a>
            @endcan
        </div>
    </div>
</li>
