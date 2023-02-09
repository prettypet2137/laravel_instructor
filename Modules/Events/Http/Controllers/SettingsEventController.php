<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SettingsEventController extends Controller
{
    public function emaildefault(Request $request)
    {
        return view('events::settings.emaildefault');
    }

    public function store(Request $request)
    {
        $request->validate([
            'EVENT_EMAIL_CONTENT'         => 'required',
        ]);
        update_option('EVENT_EMAIL_CONTENT', $request->EVENT_EMAIL_CONTENT);
        
        return redirect()->back()->with('success', __('Updated successfully'));
    }
    
    
}
