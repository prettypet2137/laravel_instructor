<?php

namespace Modules\Saas\Http\Middleware;

use Closure;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\User\Entities\User;

class Billing
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
        $user = $request->user();
        $requestInfo = $request->getPathInfo();
        $routeName = routeName();
        // request user login
        if ($user) {

            if ($routeName == 'events.store') { // check limit events
                    
                    $noti = __('You need to upgrade for more events');
                    $check = $this->checkNumberEvents($user);
                    if ($check == true) {
                        return $next($request);
                    }
                    return back()->with('error', $noti);

            }
            elseif($routeName == 'events.update'){ // check theme premium
                
                $theme = $request->input('theme');
                $allowPremiumTheme = $user->allowPremiumTheme();
                $noti = __('You need to upgrade for use premium theme')." - ".$theme;
                
                if($allowPremiumTheme == false && getConfigFileEventTemplate($theme)['is_premium'] == true){
                    return back()->with('error', $noti);
                }
                return $next($request);
            }
            elseif($routeName == 'events.public.register'){ // check limit guests

                $event = Event::where('short_slug', '=', $request->slug)->firstOrFail();
                $noti = __('You need to upgrade for more guests');
                $check = $this->checkNumberGuests($event);
                if ($check == true) {
                    return $next($request);
                }
                return back()->with('error', $noti);

            }
            
                
        }

        return $next($request);
    }

    public function checkNumberEvents($user){

        if (!$user->subscribed()) {
            
            $has  = $user->events()->count();
            $max = config('saas.no_events');
            
            if ($max == -1) {
                return true;
            }
            if ($has >= $max) {
                return false;
            }
        }
        else{

            $has  = $user->events()->count();
            $max = $user->package->no_events;

            if ($max == -1) {
                return true;
            }
            if ($has >= $max) {
                return false;
            }
        }
        return true;
    }

    public function checkNumberGuests($event){

        $user = User::find($event->user_id);

        if (!$user->subscribed()) {
            $has  = Guest::where('user_id',$event->user_id)->count();
            $max = config('saas.no_guests');
            
            if ($max == -1) {
                return true;
            }
            if ($has >= $max) {
                return false;
            }
        }
        else{
            $has  = Guest::where('user_id',$event->user_id)->count();
            $max = $user->package->no_guests;
            if ($max == -1) {
                return true;
            }
            if ($has >= $max) {
                return false;
            }
        }
        return true;
    }
    

    
}
