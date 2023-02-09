<?php

namespace Modules\Install\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;

class CanInstall
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
        if (File::exists(storage_path('installed'))) {
            
            abort(404);
        }

        return $next($request);
    }
}