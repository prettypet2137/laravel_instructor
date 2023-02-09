<?php

namespace Modules\Feature\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Feature\Entities\Feature;
use Yajra\Datatables\Datatables;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('feature::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('feature::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);
        $data = $request->except("_token");
        $data["user_id"] = auth()->id();
        Feature::create($data);
        return redirect()->back()->with(["success" => "Sent sucesss !"]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $feature = Feature::find($id);
        return view('feature::show', ["feature" => $feature]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        return view('feature::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getFeatures(Request $request) {
        return Datatables::of(Feature::query())
            ->editColumn("username", function($item) {
                return $item->user->name;
            })
            ->editColumn("title", function($item) {
                return "<a href='" . route('feature.show', $item->id) . "'>" . $item->title . "</a>";
            })
            ->rawColumns(["title"])
            ->make(true);
    }
}
