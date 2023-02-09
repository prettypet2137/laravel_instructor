<?php

namespace Modules\Themes\Http\Middleware;

use Closure;


class CustomDomain
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
        $domain = $request->getHost();
        // domain main
        if ($domain == getAppDomain()) {

            $request->merge([
                'domain' => $domain,
            ]);
            return $next($request);
        }
        // check domain customize landing page
        $page = LandingPage::where('custom_domain', $domain)
                        ->orWhere('sub_domain', $domain)->publish()->firstOrFail();

        // Append domain and tenant to the Request object
        $request->merge([
            'domain' => $domain,
            'page' => $page
        ]);

        return $next($request);
    }
}