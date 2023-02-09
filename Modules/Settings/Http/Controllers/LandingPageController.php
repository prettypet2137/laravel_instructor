<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Settings\Entities\ContentManagement;

class LandingPageController extends Controller
{
    public function index()
    {
        $content = ContentManagement::where('page', 'landing_page')->latest()->first();
        if (!empty($content)) {
            $content->description = unserialize($content->description);
        }
        return view('settings::settings.landing-page', compact('content'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'description' => 'required',
        ]);

        $inputData = $request->all();
        $inputData['title'] = 'landing_page';
        $inputData['page'] = 'landing_page';
        $inputData['slug'] = Str::slug($inputData['title']);
        !$request->filled('is_active') ? $inputData['is_active'] = false : $inputData['is_active'] = true;

        $content = ContentManagement::where('page', 'landing_page')->latest()->first();

        if (empty($content)) {
            $content = new ContentManagement();
        }

        $content->page = $inputData['page'];
        $content->title = $inputData['title'];
        $content->slug = $inputData['slug'];
        $content->description = serialize($inputData['description']);
        $content->is_active = $inputData['is_active'];
        $content->save();

        return redirect()->back()->with('success', __('Successfully saved'));
    }
}
