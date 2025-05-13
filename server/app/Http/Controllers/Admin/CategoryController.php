<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::paginate(20);
        return view('pages.category.index', compact('categories'));
    }

    public function create()
    {
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
            'slug'        => 'nullable|string|max:255',
        ]);

        $data = $request->only('name','description', 'image', 'slug');

        if ($request->hasFile('image')) {
            $upload = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'categories'
            ]);
            $data['image']     = $upload->getSecurePath();
            $data['public_id'] = $upload->getPublicId();
        }

        Category::create($data);
        Alert::success('Success', 'Category created successfully.');
        return redirect()->route('categories.index');
    }

    public function edit(Category $category)
    {
        return view('pages.category.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name','description');

        if ($request->hasFile('image')) {

            if ($category->public_id) {
                Cloudinary::destroy($category->public_id);
            }
            $upload = Cloudinary::upload($request->file('image')->getRealPath(), [
                'folder' => 'categories'
            ]);
            $data['image']     = $upload->getSecurePath();
            $data['public_id'] = $upload->getPublicId();
        }

        $category->update($data);
        Alert::success('Success', 'Category updated successfully.');
        return redirect()->route('categories.index');
    }

    public function destroy(Category $category)
    {
        if ($category->public_id) {
            Cloudinary::destroy($category->public_id);
        }
        $category->delete();
        Alert::success('Success', 'Category deleted successfully.');
        return back();
    }
}
