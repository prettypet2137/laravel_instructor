<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\App;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('locale')) {
            App::setLocale(session()->get('locale'));
            Carbon::setLocale(session()->get('locale'));
        }
        else{
            $current_locale =  config('app.locale');
            if(config('app.APP_LOCALE')){
                $current_locale =  config('app.APP_LOCALE');
            }
            App::setLocale($current_locale);
            Carbon::setLocale($current_locale);
        }
        return $next($request);
    }
}
