<?php

namespace Modules\Saas\Http\Controllers;
use DateTimeZone;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;


class SettingController extends Controller
{

    public function settings(Request $request)
    {
        return view('saas::settings.settings');
    }
    public function update(Request $request)
    {
        $data = $request->except(['_token']);

        if(is_array($data)){
            foreach ($data as $key => $value) {
                update_option($key, trim($value));
            }
        }

        return back()->with('success', __('Settings saved successfully'));
    }

    public function packageFree(Request $request)
    {
        $permissions = config('saas.PERMISSIONS');

        return view('saas::settings.packagefree', compact(
            'permissions'
        ));
    }
    public function packageFreeUpdate(Request $request)
    {
        $request->merge([
            'unlimited_premium_theme' => $request->filled('unlimited_premium_theme'),
            'custom_domain' => $request->filled('custom_domain'),
            'custom_header_footer' => $request->filled('custom_header_footer'),
            'remove_branding' => $request->filled('remove_branding'),
            'custom_fonts' => $request->filled('custom_fonts'),
        ]);

        $data = $request->except(['_token']);
        if(is_array($data)){
            foreach ($data as $key => $value) {
                update_option($key, trim($value));
            }
        }

        return back()->with('success', __('Settings saved successfully'));
    }

    public function paymentIntegrations(Request $request)
    {
        $skins      = Storage::disk('skins')->directories();
        $time_zones = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
        $languages  = config('languages');
        
        return view('saas::settings.payment-integrations', compact(
            'skins',
            'languages',
            'time_zones'
        ));
    }

    public function paymentIntegrationsUpdate(Request $request)
    {
        $data = $request->except(['_token']);

        if(is_array($data)){
            foreach ($data as $key => $value) {
                update_option($key, trim($value));
            }
        }

        return back()->with('success', __('Settings saved successfully'));
    }

}
