<?php

namespace Modules\Blogs\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blogs\Entities\Blog;
use Modules\Blogs\Entities\Category;
use Str;
class BlogsController extends Controller
{
    public function getBlogs(Request $request){
        
        $skin = config('app.SITE_LANDING');
        $user = $request->user();

        $filter_category_id = $request->input('category_id');

        $query = Blog::query();
        if(isset($filter_category_id)){
            $query = $query->where('category_id', '=', $filter_category_id);
        }
        if($request->filled('search')) {
            $query = $query->where('title', 'like', '%' . $request->input('search') . '%');
        }
        $categories = Category::active()->orderBy('is_featured', 'desc')->get();
        $data = $query->active()->orderBy('is_featured', 'desc')->paginate(12);
        return view('themes::' . $skin . '.blogs', compact('data', 'user', 'categories', 'filter_category_id'));
    }

    public function getBlog(Request $request, $id, $slug) {
        $blog = Blog::where([
            ['id', '=', $id],
            ['slug', '=', $slug]
        ])->firstOrFail();

        $skin = config('app.SITE_LANDING');
        $user = $request->user();

        $categories = Category::active()->orderBy('is_featured', 'desc')->limit(10)->get();
        $other_blogs = Blog::active()->where('id', '!=', $blog->id)->orderBy('created_at', 'desc')->limit(5)->get();

        return view('themes::' . $skin . '.blog', compact('blog', 'user', 'categories', 'other_blogs'));
    }

    public function index(Request $request)
    {
        $data = Blog::with(['category'])->orderBy('created_at', 'DESC');
        
        if ($request->filled('search'))
        {
            $data->where('title', 'like', '%' . $request->search . '%');
        }
        $data = $data->paginate(10);

        return view('blogs::blogs.index', compact('data'));
    }

    public function create(Request $request)
    {
        $categories = Category::active()->orderBy('is_featured', 'desc')->get();
        return view('blogs::blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    =>  'required',
            'category_id'    =>  'required',
            'content_short'    =>  'required',
            'content'    =>  'required',
            'thumb'    =>  'required',
            'title_seo'    =>  'required',
            'description_seo'    =>  'required',
            'keyword_seo'    =>  'required',
            'time_read'    =>  'required',
        ]);
        

        $inputData = $request->all();
        $inputData['slug'] = Str::slug($inputData['title']);

        !$request->filled('is_featured') ?  $inputData['is_featured'] = false : $inputData['is_featured'] = true;
        !$request->filled('is_active') ?  $inputData['is_active'] = false : $inputData['is_active'] = true;

        $image = $request->file('thumb');
        if ($image != '')
        {
            $request->validate([
                'thumb' => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000', ], 
                ['thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg') , ]
            );
            $path_folder = public_path('storage/blogs/thumbnails');

            $image_name = "thumbnail_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move($path_folder , $image_name);

            $inputData['thumb'] = $image_name;
        }

        Blog::create($inputData);

        return redirect()->route('settings.blogs.index')->with('success', __('Created successfully'));
    }

    public function edit(Request $request, $id)
    {
        $item = Blog::findOrFail($id);
        $categories = Category::active()->orderBy('is_featured', 'desc')->get();
        return view('blogs::blogs.edit', compact('item', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    =>  'required',
            'category_id'    =>  'required',
            'content_short'    =>  'required',
            'content'    =>  'required',
            'title_seo'    =>  'required',
            'description_seo'    =>  'required',
            'keyword_seo'    =>  'required',
            'time_read'    =>  'required',
        ]);
        $inputData = $request->all();
        $inputData['slug'] = Str::slug($inputData['title']);
        !$request->filled('is_featured') ?  $inputData['is_featured'] = false : $inputData['is_featured'] = true;
        !$request->filled('is_active') ?  $inputData['is_active'] = false : $inputData['is_active'] = true;

        $item = Blog::findorFail($id);

        $image = $request->file('thumb');
        if ($image != '')
        {
            $request->validate([
                'thumb' => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000', ], 
                ['thumb.mimes' => __('The :attribute must be an jpg,jpeg,png,svg') , ]
            );
            $path_folder = public_path('storage/blogs/thumbnails');

            $image_name = "thumbnail_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move($path_folder , $image_name);

            if(isset($item->thumb)){
                $path = $path_folder . "/" . $item->thumb;
                deleteImageWithPath($path);                
            }

            $inputData['thumb'] = $image_name;
        }

        $item->update($inputData);

        return redirect()->back()->with('success', __('Updated successfully'));
    }

    public function destroy(Request $request, $id)
    {
        $item = Blog::findOrFail($id);

        // delete image
        if(isset($item->thumb)){
            $path_folder = public_path('storage/blogs/thumbnails');
            $path = $path_folder . "/" . $item->thumb;
            deleteImageWithPath($path);            
        }

        $item->delete();
        return redirect()->route('settings.blogs.index')->with('success', __('Deleted successfully'));
    }

    public function upload_image(Request $request)
    {
        $image = $request->file('file');
        if ($image != '')
        {
            $request->validate([
                'file' => 'sometimes|required|mimes:jpg,jpeg,png,svg|max:20000', ], 
                ['file.mimes' => __('The :attribute must be an jpg,jpeg,png,svg') , ]
            );
            $path_folder = public_path('storage/blogs/contents');

            $image_name = "image_" . rand() . '.' . $image->getClientOriginalExtension();
            $image->move($path_folder , $image_name);

            return response()->json([
                'location' => asset('/storage/blogs/contents/' . $image_name)
            ]);
        }
        abort(422);
    }
}
