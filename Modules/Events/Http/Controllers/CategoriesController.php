<?php

namespace Modules\Events\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Events\Http\Requests\CategoryStoreRequest;
use Modules\Events\Http\Requests\CategoryUpdateRequest;
use Modules\Events\Entities\Category;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $builder = Category::query();

        $query = $request->input('query', null);
        if(isset($query)){
            $builder->where('name', 'like', '%' . $query . '%');
        }

        $categories = $builder->paginate(config('events.per_page', 10));

        return view('events::categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(Request $request)
    {
        return view('events::categories.create');
    }

    public function store(CategoryStoreRequest $request)
    {
        $data = $request->validated();
        $category = Category::create([
            'name' => $data['name'],
        ]);
        return redirect()->route('settings.events.categories.edit', ['id' => $category->id])->with('success', __('Created success !'));
    }
    
    public function edit(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        return view('events::categories.edit', [
            'category' => $category,
        ]);
    }
    
    public function update(CategoryUpdateRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $request->validated();
        $category->update([
            'name' => $data['name'],
        ]);
        return redirect()->route('settings.events.categories.edit', ['id' => $id])->with('success', __('Updated success !'));
    }
    
    public function delete(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->back()->with('success', __('Deleted success !'));
    }
}
