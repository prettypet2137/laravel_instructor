@if(isset($data['pagewebsites']))
	@foreach($data['pagewebsites'] as $p)
		<li><a href="{{ route('pagewebsite', $p->slug) }}">{{ $p->title }}</a></li>
	@endforeach
@endif