@can('admin')
<li class="nav-item">
	<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBlogs" aria-expanded="false" aria-controls="collapseTwo">
		<i class="fas fa-blog"></i>
		<span>@lang('Blogs')</span>
	</a>
	<div id="collapseBlogs" class="collapse {{ (request()->is('settings/blogs*')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="">
		<div class="py-2 collapse-inner rounded">
			<a class="collapse-item {{ routeName() == 'settings.blogs.index' ? 'active' : '' }}" href="{{ route('settings.blogs.index') }}">
				<span>@lang('All Blogs')</span>
			</a>
			<a class="collapse-item {{ routeName() == 'settings.blogs.create' ? 'active' : '' }}" href="{{ route('settings.blogs.create') }}">
				<span>@lang('Create Blog')</span>
			</a>
			<a class="collapse-item {{ routeName() == 'settings.blogs.categories.index' ? 'active' : '' }}" href="{{ route('settings.blogs.categories.index') }}">
				<span>@lang('All Categories')</span>
			</a>
			<a class="collapse-item {{ routeName() == 'settings.blogs.categories.create' ? 'active' : '' }}" href="{{ route('settings.blogs.categories.create') }}">
				<span>@lang('Create Category')</span>
			</a>
		</div>
	</div>
</li>
@endcan
