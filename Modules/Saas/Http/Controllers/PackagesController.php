<?php

namespace Modules\Saas\Http\Controllers;

use Modules\Saas\Entities\Package;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        
        $data = Package::paginate(10);

        return view('saas::packages.index', compact(
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
        $permissions = config('saas.PERMISSIONS');

        return view('saas::packages.create', compact(
            'permissions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'                   => 'required',
            'description'                   => 'required',
            'price'                   => 'required',
            'interval'                => 'required',
            'interval_number'         => 'required',
            'settings.no_guests' => 'required|numeric|min:-1',
            'settings.no_events' => 'required|numeric|min:-1',
        ]);



        if (!$request->filled('is_featured')) {
            $request->request->add([
                'is_featured' => false,
            ]);
        } else {
            $request->request->add([
                'is_featured' => true,
            ]);
        }

        if ($request->filled('is_active')) {
            $request->request->add([
                'is_active' => true,
            ]);
        } else {
            $request->request->add([
                'is_active' => false,
            ]);
        }

        $item = Package::create($request->all());
        

        return redirect()->route('settings.packages.index')
            ->with('success', __('Created successfully'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $permissions = config('saas.PERMISSIONS');

        return view('saas::packages.edit', compact(
            'package',
            'permissions'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'title'                   => 'required',
            'description'                   => 'required',
            'price'                   => 'required',
            'interval'                => 'required',
            'interval_number'         => 'required',
            'settings.no_guests' => 'required|numeric|min:-1',
            'settings.no_events' => 'required|numeric|min:-1',
        ]);

        if (!$request->filled('is_featured')) {
            $request->request->add([
                'is_featured' => false,
            ]);
        } else {
            $request->request->add([
                'is_featured' => true,
            ]);
        }

        if (!$request->filled('is_active')) {
            $request->request->add([
                'is_active' => false,
            ]);
        } else {
            $request->request->add([
                'is_active' => true,
            ]);
        }


        $package->update($request->all());


        return redirect()->route('settings.packages.index')
            ->with('success', __('Updated successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();

        // Should we remove post from the Instagram as well?

        return redirect()->route('settings.packages.index')
            ->with('success', __('Deleted successfully'));
    }
}
