<?php

namespace Modules\Install\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RedirectIfNotInstalled
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
        // Check if /storage/installed file exists
        if (File::exists(storage_path('installed'))) {
            return $next($request);
        }
        // Already in the wizard
        if (Str::startsWith($request->getPathInfo(), '/install')) {
            return $next($request);
        }


        // Not installed, redirect to installation wizard
        return redirect()->route('install.check');
    }
}
