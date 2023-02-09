<?php

namespace Modules\Upsell\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\Upsell\Entities\Upsell;
use Yajra\Datatables\Datatables;
class UpsellController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('upsell::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('upsell::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
         try {
            $request->validate([
                "title" => "required",
                "price" => "required",
                "description" => "required"
            ]);
            $prices = [];
            foreach ($request->price as $price) {
                if (!is_null($price)) $prices[] = $price;
            }
            if (!empty($prices)) {
                $data = $request->except("_token");
                $data["user_id"] = auth()->id();
                if ($request->hasFile("image")) {
                    $image = $request->file('image')->store("upsells", 'public');
                    $data["image"] = $image;
                }
                $data["price"] = json_encode($data["price"]);
                Upsell::create($data);
                return redirect()->route("upsell.index");
            } else {
                return redirect()->route("upsell.index")->withErrors([
                    "msg" => "Please put in the price field." 
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->route("upsell.index")->withErrors([
                "msg" => $e->getMessage()
            ]);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('upsell::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        $upsell = Upsell::find($id);
        return view('upsell::edit', ["upsell" => $upsell]);
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
            "title" => "required",
            "price" => "required",
            "description"
        ]);
        $data = $request->except(["_token", "_method"]);
        $upsell = Upsell::findOrfail($id);
        if ($request->hasFile("image")) {
            deleteImageWithPath(public_path("storage/") . $upsell->image);
            $image = $request->file("image")->store("upsells", "public");
            $data["image"] = $image;
        }
        $upsell->update($data);
        return redirect()->route("upsell.edit", $id)->with("success", "Updated success!");
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $upsell = Upsell::findOrFail($id);
        if ($upsell->image) deleteImageWithPath(public_path("storage/" . $upsell->image));
        $upsell->delete();
        return redirect()->route("upsell.index")->with("success", "Delete success !");
    }

    public function getUpsells(Request $request) {
        return Datatables::of(Upsell::where("user_id", auth()->id()))
            ->editColumn("image", function($item) {
                return "<img src='" . asset("storage/" . $item->image) ."' width='50' height='50' style='border: 1px solid #cccccc'/>";
            })
            ->addColumn("action", function($item) {
                return "
                    <a class='btn btn-sm btn-success' href='" . route('upsell.edit', $item->id) . "'><i class='fa fa-edit'></i></a>
                    <button class='btn btn-sm btn-danger delete-btn' data-id='" . $item->id . "'><i class='fa fa-trash'></i></button>'
                ";
            })
            ->rawColumns(["image", "action"])->make(true);
    }
}
