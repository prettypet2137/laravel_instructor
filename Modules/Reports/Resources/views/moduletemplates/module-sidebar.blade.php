<li class="nav-item {{ (request()->is('reports.index')) ? 'active' : '' }}" data-target="report-tour">
    <a class="nav-link report-link" href="{{ route('reports.index') }}">
        <i class="fas fa-book-open"></i>
        <span>@lang('Reports')</span></a>
</li>
