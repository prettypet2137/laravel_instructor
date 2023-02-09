<?php

namespace Modules\Blogs\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blogs\Entities\Category;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $data = Category::orderBy('created_at', 'DESC');
        
        if ($request->filled('search'))
        {
            $data->where('name', 'like', '%' . $request->search . '%');
        }
        $data = $data->paginate(10);

        return view('blogs::categories.index', compact('data'));
    }

    public function create(Request $request)
    {
        return view('blogs::categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    =>  'required',
        ]);
        $inputData = $request->all();

        !$request->filled('is_featured') ?  $inputData['is_featured'] = false : $inputData['is_featured'] = true;
        !$request->filled('is_active') ?  $inputData['is_active'] = false : $inputData['is_active'] = true;

        $image = $request->file('thumb');
        if ($image != '')
        {
            $request->validate([
                'thumb' => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000', ], 
                ['thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg') , ]
            );
            $path_folder = public_path('storage/blogs/categories');

            $image_name = "thumbnail_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move($path_folder , $image_name);

            $inputData['thumb'] = $image_name;
        }

        Category::create($inputData);

        return redirect()->route('settings.blogs.categories.index')->with('success', __('Created successfully'));
    }

    public function edit(Request $request, $id)
    {
        $item = Category::findOrFail($id);
        
        return view('blogs::categories.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'    =>  'required',
        ]);
        $inputData = $request->all();

        !$request->filled('is_featured') ?  $inputData['is_featured'] = false : $inputData['is_featured'] = true;
        !$request->filled('is_active') ?  $inputData['is_active'] = false : $inputData['is_active'] = true;

        $item = Category::findorFail($id);

        $image = $request->file('thumb');
        if ($image != '')
        {
            $request->validate([
                'thumb' => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000', ], 
                ['thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg') , ]
            );
            $path_folder = public_path('storage/blogs/categories');

            $image_name = "thumbnail_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move($path_folder , $image_name);

            if(isset($item->thumb)){
                $path = $path_folder."/".$item->thumb;
                deleteImageWithPath($path);                
            }

            $inputData['thumb'] = $image_name;
        }

        $item->update($inputData);

        return redirect()->back()->with('success', __('Updated successfully'));
    }

    public function destroy(Request $request, $id)
    {
        $item = Category::findOrFail($id);

        // check relationship
        if ($item->blogs()->exists() > 0) {
            return redirect()->route('settings.blogs.categories.index')->with('error',"Can't delete because it has blogs in it");
        }

        // delete image
        if(isset($item->thumb)){
            $path_folder = public_path('storage/blogs/categories');
            $path = $path_folder."/".$item->thumb;
            deleteImageWithPath($path);            
        }

        $item->delete();
        return redirect()->route('settings.blogs.categories.index')->with('success', __('Deleted successfully'));
    }

}
