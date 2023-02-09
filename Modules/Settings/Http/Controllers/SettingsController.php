<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use DateTimeZone;
use JoeDixon\Translation\Drivers\Translation;

use Modules\Saas\Entities\Package;
use Modules\User\Entities\User;
use Modules\Settings\Entities\Video;


class SettingsController extends Controller
{

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function dashboard(Request $request)
    {


        return view('settings::settings.dashboard', 
        );

    }

    public function index(Request $request)
    {
        $skins      = Storage::disk('skins')->directories();
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);

        return view('settings::settings.index', compact(
            'skins',
            'time_zones'
        ));
    }

    public function localization(Request $request)
    {
        $skins      = Storage::disk('skins')->directories();
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $languages = $this->translation->allLanguages();
        $currencies      = config('currencies');
        
        $CURRENCY_CODE = config('app.CURRENCY_CODE');
        $CURRENCY_SYMBOL = config('app.CURRENCY_SYMBOL');
        $APP_TIMEZONE = config('app.timezone');
        $APP_LOCALE = config('app.APP_LOCALE');
        
        return view('settings::settings.localization', compact(
            'CURRENCY_CODE',
            'CURRENCY_SYMBOL',
            'APP_TIMEZONE',
            'APP_LOCALE',
            'skins',
            'languages',
            'time_zones',
            'currencies'
        ));
    }

    public function email(Request $request)
    {
        return view('settings::settings.email');
    }

    public function manageAds(Request $request)
    {
        return view('settings::settings.ads');
    }

    public function integrations(Request $request)
    {
        return view('settings::settings.integrations');
    }
    public function update(Request $request, $group = '')
    {

        $data_more = [];

        switch ($group) {

            case 'localization':

                $request->validate([
                    'CURRENCY_CODE'   => 'required',
                    'APP_LOCALE'    => 'required',
                    'APP_TIMEZONE'  => 'required',
                ]);

                break;

            case 'email':

                $request->validate([
                    'MAIL_HOST'         => 'required',
                    'MAIL_PORT'         => 'required|integer',
                    'MAIL_USERNAME'     => 'required',
                    'MAIL_PASSWORD'     => 'required',
                    'MAIL_ENCRYPTION'   => 'required',
                    'MAIL_FROM_ADDRESS' => 'required|email',
                    'MAIL_FROM_NAME'    => 'required',
                ]);

                break;

            case 'integrations':
                break;
            case 'ads':
                break;

            default:
            
                $message_mimes = __('The :attribute must be an jpg,jpeg,png,svg');
                
                $request->validate([
                    'APP_URL'    => 'required|url',
                    'APP_NAME'   => 'required',
                    'SITE_LANDING'  => 'required',
                    'SERVER_IP'  => 'required',
                    'logo_frontend'                 => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
                    'logo_favicon'                  => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',
                    'logo_light'                     => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000',   
                ],
                [
                    'logo_frontend.mimes' => $message_mimes,
                    'logo_favicon.mimes' => $message_mimes,
                    'logo_light.mimes' => $message_mimes,
                ]
                );

                if ($request->hasFile('logo_favicon') && $request->file('logo_favicon')->isValid()) {

                    // delete image old
                    $path = public_path('storage')."/". config('app.logo_favicon');
                    deleteImageWithPath($path);

                    $logo_favicon = $request->file('logo_favicon')->store('system', 'public');
                    $data_more['logo_favicon'] = "storage/". $logo_favicon;

                }

                if ($request->hasFile('logo_frontend') && $request->file('logo_frontend')->isValid()) {

                    // delete image old
                    $path = public_path('storage')."/". config('app.logo_frontend');
                    deleteImageWithPath($path);

                    $logo_frontend = $request->file('logo_frontend')->store('system', 'public');
                    $data_more['logo_frontend'] = "storage/". $logo_frontend;
                    
                }
                if ($request->hasFile('logo_light') && $request->file('logo_light')->isValid()) {

                    // delete image old
                    $path = public_path('storage')."/". config('app.logo_light');
                    deleteImageWithPath($path);
                    
                    $logo_light = $request->file('logo_light')->store('system', 'public');
                    $data_more['logo_light'] = "storage/". $logo_light;
                
                }

                break;
        }
        
        $data = array_merge($data_more,$request->except(['_token','logo_favicon','logo_frontend','logo_light']));

        if(is_array($data)){
            foreach ($data as $key => $value) {
                update_option($key, trim($value));
            }
        }
        if($group == 'ads'){
            return redirect()->route('settings.manage-ads')->with('success', __('Settings saved successfully'));
        }

        return back()->with('success', __('Settings saved successfully'));
    }

    public function updateVersion(){
        set_time_limit(900); // 15 minutes
        Artisan::call('migrate', ["--force" => true]);
        Artisan::call('module:publish');
        Artisan::call('translation:sync-missing-translation-keys');
        Artisan::call('optimize:clear');
        die("All Artisan call done");
    }

    public function cacheClear(){
        Artisan::call('optimize:clear');
        die("optimize:clear done");
    }

    public function syncMissingTranslationKeys(){
        Artisan::call('optimize:clear');
        Artisan::call('translation:sync-missing-translation-keys');
        die("translation:sync-missing-translation-keys done");
    }

    public function video() {
        $videos = Video::all();
        return view("settings::settings.video", ["videos" => $videos]);
    }

    public function storeVideo(Request $request) {
        $request->validate([
            "link" => "required",
            "title" => "required"
        ]);
        $data = $request->except("_token");
        Video::create($data);
        return redirect()->route("settings.video.index");
    }
    
    public function getVideo($id) {
        $video = Video::findOrFail($id);
        return response()->json($video);
    }
    public function updateVideo(Request $request, $id) {
        $request->validate([
            "link" => "required",
            "title" => "required"
        ]);
        $data = $request->except(["_token", "_method"]);
        Video::find($id)->update($data);
        return redirect()->route("settings.video.index");
    }

    public function destroyVideo($id) {
        Video::find($id)->delete();
        return redirect()->route("settings.video.index");
    }
}