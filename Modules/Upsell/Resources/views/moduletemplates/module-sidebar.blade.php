<li class="nav-item {{ (request()->is('upsell*')) ? 'active' : '' }}">
    <a class="nav-link upsell-link" href="{{ route('upsell.index') }}">
        <i class="fa fa-gift"></i>
        <span>@lang('Upsell')</span>
    </a>
</li>
