<nav class="header">
    <a href="{{ url('settings') }}">
          <h1 class="text-lg px-6">{{ config('app.name') }}</h1>
   </a>
   <ul class="flex-grow justify-end pr-2">
       <li>
           <a href="{{ route('languages.index') }}" class="{{ set_active('') }}{{ set_active('/create') }}">
               @include('translation::icons.globe')
               {{ __('translation::translation.languages') }}
           </a>
       </li>
       <li>
           <a href="{{ route('languages.translations.index', config('app.fallback_locale')) }}" class="{{ set_active('*/translations') }}">
               @include('translation::icons.translate')
               {{ __('translation::translation.translations') }}
           </a>
       </li>
   </ul>

</nav>