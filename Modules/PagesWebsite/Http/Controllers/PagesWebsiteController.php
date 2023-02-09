<?php

namespace Modules\PagesWebsite\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\PagesWebsite\Entities\PageWebsite;
use Str;
class PagesWebsiteController extends Controller
{
    
    public function pageWebsite($slug, Request $request)
    {
        $page = PageWebsite::where('slug', $slug)->first();

        if ($page) {
            
            $skin = config('app.SITE_LANDING');
            $user = $request->user();

            return view('themes::' . $skin . '.page', compact(
                'page',
                'user'
            ));
        }
        abort(404);
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = PageWebsite::orderByDesc('id');
        $data = $data->paginate(10);
        return view('pageswebsite::pagewebsites.index', compact(
            'data'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('pageswebsite::pagewebsites.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->request->add([
            'slug' => Str::slug($request->slug),
        ]);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'slug'          => 'required|string|unique:page_websites',
        ]);

        $dataRequest = $request->all();

        if (!$request->filled('is_active')) {
            $dataRequest['is_active'] = false;
        } else {
            $dataRequest['is_active'] = true;
        }


        PageWebsite::create($dataRequest);

        return redirect()->route('settings.pagewebsites.index')
            ->with('success', __('Created successfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = PageWebsite::findorFail($id);
        return view('pageswebsite::pagewebsites.edit', compact(
            'item'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = PageWebsite::findorFail($id);

        $request->request->add([
            'slug' => Str::slug($request->slug),
        ]);

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'slug'          => 'required|string|unique:page_websites,slug,' . $page->id,
        ]);

        
        if (!$request->filled('is_active')) {
            $request->request->add([
                'is_active' => false,
            ]);
        } else {
            $request->request->add([
                'is_active' => true,
            ]);
        }
        


        $page->update($request->all());

        return redirect()->route('settings.pagewebsites.edit', $page)
            ->with('success', __('Updated successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $page = PageWebsite::findorFail($id);
        $page->delete();

        return redirect()->route('settings.pagewebsites.index')
            ->with('success', __('Deleted successfully'));
    }
}