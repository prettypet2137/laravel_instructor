<?php

namespace Modules\Saas\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\Event;
use Modules\User\Entities\User;
use Modules\Events\Entities\Guest;
use Modules\Tracklink\Entities\Tracklink;
use Modules\Events\Http\Requests\PublicRegisterRequest;
use Modules\Events\Jobs\GuestGreetingJob;
use Module;
use Carbon\Carbon;

class ApiController extends Controller
{

    public function getEvent(Request $request)
    {
        $custom_domain = $request->custom_domain;
        if(!$custom_domain){
            return ['status'=> false, 'message' => __('Not found any custom_domain')];
        }
        $item = Event::where('custom_domain',$custom_domain)->first();
        
        if(!$item){
            return ['status'=> false, 'message' => __('Not found any event')];
        }

        $user = User::find($item->user_id);
        $allowRemoveBrand = 1;
        $publishUrl =  $item->getPublicUrl();
        $eventExpired = $item->eventExpired();
        
        if (Module::find('Saas')) {
            $allowRemoveBrand = $user->allowRemoveBrand();
        }

        return ['status'=> true, 'message' => __('Success'), 'data' => [
            'item'=> $item,
            'allowRemoveBrand' => $allowRemoveBrand,
            'publishUrl' => $publishUrl,
            'eventExpired' => $eventExpired,
            'eventClass' => Event::class
        ]];
    }
    public function saveTrackLink(Request $request){

        try {
            $data = $request->all();
            $data['datetime'] =  \Carbon\Carbon::now();
            Tracklink::create($request->all());
            return ['status'=> true, 'message' => __('Success')];

        } catch (\Exception $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }

    }

    public function registerEvent(Request $request){
        

        try {

            $custom_domain = $request->custom_domain;
            if(!$custom_domain){
                return ['status'=> false, 'message' => __('Not found any custom_domain')];
            }
            $event = Event::where('custom_domain',$custom_domain)->first();
            
            if(!$event){
                return ['status'=> false, 'message' => __('Not found any event')];
            }
            // Validate
            $validator = \Validator::make($request->all(), $event->getRules());
            $data = $request->all();
            
            if ($validator->fails()) {
                return ['status'=> false, 'message' => $validator->errors()];
            }
            
            // Create register
            $info_items = $event->info_items;
        
            if(count($info_items) > 0){
                $info_items['submit'] = [];
                for($i = 0; $i < count($info_items['name']); $i++){
                    $submit = null;
                    if(isset($data['info_item_' . $i])){
                        $submit = $data['info_item_' . $i];
                    }
                    array_push($info_items['submit'], $submit);
                }            
            }
            
            $ticket_detail = [null,null];
            if(isset($data['ticket']) && !empty($data['ticket'])){
                $ticket_detail = explode(";",$data['ticket']);
            }
        
            $guest = Guest::create([
                'user_id' => $event->user_id,
                'event_id' => $event->id,
                'fullname' => $data['fullname'],
                'email' => $data['email'],
                'info_items' => $info_items,
                'ticket_name' => $ticket_detail[0],
                'ticket_price' => $ticket_detail[1],
                'ticket_currency' => $event->ticket_currency,
            ]);

            GuestGreetingJob::dispatch($event, $guest);

            return ['status'=> true, 'message' => $event->noti_register_success];

        }catch (\Exception $e) {
            return ['status'=> false, 'message' => $e->getMessage()];
        }

    }
    public function test(){
        $data = $request->validated();

        $event = Event::where('short_slug', '=', $slug)->firstOrFail();

        
        
        return redirect()->back()->with('success', $event->noti_register_success);
    }
}
