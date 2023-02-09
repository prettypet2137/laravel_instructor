<?php

namespace Modules\Tracklink\Entities;

use Illuminate\Database\Eloquent\Model;
use MaxMind\Db\Reader;
use Modules\Events\Entities\Event;

class Tracklink extends Model
{
    protected $table = 'tracklinks';
    
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'target_class',
        'target_id',
        'country_code',
        'city_name',
        'os_name',
        'browser_name',
        'referrer_host',
        'referrer_path',
        'device_type',
        'browser_language',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'is_unique',
        'datetime',
    ];
   
    protected $casts = [
        'is_unique' => 'boolean',
    ];

    public function target()
    {
        return $this->belongsTo(Event::class, 'target_id', 'id');
    }

    public static function save_from_request($request, $target_class, $target_id) {
        $cookie_name = 's_statistics_' . $target_class . '_' . $target_id;

        /* check recently */
        if(\Cookie::get($cookie_name) !== null && (int) \Cookie::get($cookie_name) >= 3) {
            return;
        }

        /* Detect extra details about the user */
        $whichbrowser = new \WhichBrowser\Parser($_SERVER['HTTP_USER_AGENT']);

        /* Do not track bots */
        if($whichbrowser->device->type == 'bot') {
            return;
        }

        /* Detect extra details about the user */
        $browser_name = $whichbrowser->browser->name ?? null;
        $os_name = $whichbrowser->os->name ?? null;
        $browser_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? mb_substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : null;
        $device_type = get_device_type($_SERVER['HTTP_USER_AGENT']);
        $is_unique = isset($_COOKIE[$cookie_name]) ? false : true;

        /* Detect the location */
        try {
            $maxmind = (new Reader(__DIR__ . '/../Files/GeoLite2-City.mmdb'))->get($request->ip());
        } catch(\Exception $exception) {
            /* :) */
        }
        $country_code = isset($maxmind) && isset($maxmind['country']) ? $maxmind['country']['iso_code'] : null;
        $city_name = isset($maxmind) && isset($maxmind['city']) ? $maxmind['city']['names']['en'] : null;

        /* Process referrer */
        $referrer = isset($_SERVER['HTTP_REFERER']) ? parse_url($_SERVER['HTTP_REFERER']) : null;

        if(!isset($referrer)) {
            $referrer = [
                'host' => null,
                'path' => null
            ];
        }

        /* Check if referrer actually comes from the QR code */
        if(isset($_GET['referrer']) && $_GET['referrer'] == 'qr') {
            $referrer = [
                'host' => 'qr',
                'path' => null
            ];
        }

        $utm_source = $_GET['utm_source'] ?? null;
        $utm_medium = $_GET['utm_medium'] ?? null;
        $utm_campaign = $_GET['utm_campaign'] ?? null;

        /* Insert the log */
        Tracklink::create([
            'target_class' => $target_class,
            'target_id' => $target_id,
            'country_code' => $country_code,
            'city_name' => $city_name,
            'os_name' => $os_name,
            'browser_name' => $browser_name,
            'referrer_host' => $referrer['host'],
            'referrer_path' => $referrer['path'],
            'device_type' => $device_type,
            'browser_language' => $browser_language,
            'utm_source' => $utm_source,
            'utm_medium' => $utm_medium,
            'utm_campaign' => $utm_campaign,
            'is_unique' => $is_unique,
            'datetime' => \Carbon\Carbon::now()
        ]);

        /* Set cookie to try and avoid multiple entrances */
        $cookie_new_value = \Cookie::get($cookie_name) !== null ? (int) \Cookie::get($cookie_name) + 1 : 0;
        \Cookie::queue($cookie_name, (int) $cookie_new_value, time()+60*60*24*1);
    }
}
