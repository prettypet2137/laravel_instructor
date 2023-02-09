<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Events\Entities\EventCategory;

class EventCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = EventCategory::query();
        $data = $data->where("user_id", $user_id);
        $query = $request->input('query', null);
        if (isset($query))
            $data->where('name', 'like', '%' . $query . '%');
        $data->orderBy('name', "asc");
        $categories = $data->paginate(10);

        return view('events::event_categories.index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return;
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required"
        ]);
        $data = $request->except("_token");
        $user = auth()->user();
        $category = EventCategory::create([
            'name' => $data['name'],
            'user_id' => $user->id,
            'type' => $user->role
        ]);
        return redirect()->route('categories.index')->with('success', 'Created successully!');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return ;
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return;
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required"
        ]);
        $category = EventCategory::findOrFail($id);
        $category->update([
            "name" => $request->input("name")
        ]);
        return redirect()->route("categories.index")->with("success", "Updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = EventCategory::findOrFail($id);
        $category->delete();
        return redirect()->route("categories.index")->with("success", "Deleted successfully!");
    }
}