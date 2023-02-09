<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\AboutUser;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $about = AboutUser::where('user_id', auth()->user()->id)->first();
        if (!empty($about)) {
            $about['description'] = unserialize($about->description);
        }
        return view('events::events.about', compact('about'));
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'add_description' => 'required|string'
        ], [
            'add_description.required' => 'The description field is required.'
        ]);

        AboutUser::firstOrCreate([
            'user_id' => auth()->id()
        ], [
            'description' => serialize($attributes['add_description'])
        ]);
        return redirect()->route('about.index')->with('success', 'Successfully added');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $attributes = $request->validate([
            'edit_description' => 'required|string'
        ], [
            'edit_description.required' => 'The description field is required.'
        ]);
        $id = empty($id) ? auth()->id() : $id;
        $about = AboutUser::findOrFail($id);
        $about->update([
            'user_id' => auth()->id(),
            'description' => serialize($attributes['edit_description'])
        ]);
        return redirect()->route('about.index')->with('success', 'Successfully updated');
    }
}
