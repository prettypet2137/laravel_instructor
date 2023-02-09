<?php

namespace Modules\Saas\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Settings\Entities\ContentManagement;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Event;
use Modules\User\Entities\User;
use Modules\Events\Entities\Guest;
use Modules\Tracklink\Entities\Tracklink;
use Modules\Events\Http\Requests\PublicRegisterRequest;
use Modules\Events\Jobs\GuestGreetingJob;
use Module;
use Carbon\Carbon;

class CustomDomainController extends Controller
{

    public function getLandingPage(Request $request)
    {
        $domain = $request->getHost();
        $app_url = config('app.url');
        $parse = parse_url($app_url);
        
        $content = ContentManagement::where('page', 'landing_page')->latest()->first();
        if (!empty($content)) {
            $content->description = unserialize($content->description);
        }
        
        if($domain == $parse['host']){
            $skin            = config('app.SITE_LANDING');
            $currency_symbol         = config('app.CURRENCY_SYMBOL');
            $currency_code   = config('app.CURRENCY_CODE');
            $user            = $request->user();
            return view('themes::' . $skin . '.home', compact(
                'user','currency_symbol','currency_code','content'
            ));
        }else{

            $custom_domain = $domain;

            $event = Event::where('custom_domain',$custom_domain)->first();
            
            if(!$event){
                abort(404);
            }

            $allowRemoveBrand = true;
            if (Module::find('Saas')) {
                $user = User::findOrFail($event->user_id);
                $allowRemoveBrand = $user->allowRemoveBrand();
            }
            $publishUrl = $event->getPublicUrl();
            $eventExpired = $event->eventExpired();

            Tracklink::save_from_request($request, Event::class, $event->id);
            return view('events::event_templates.'.$event->theme.'.main', [
                'event' => $event,
                'allowRemoveBrand' => $allowRemoveBrand,
                'publishUrl' => $publishUrl,
                'eventExpired' => $eventExpired
            ]);

        }
        
    }
    
}
