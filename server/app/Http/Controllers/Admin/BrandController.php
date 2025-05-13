<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(20);
        return view('pages.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('pages.brands.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'logo'     => 'nullable|image|max:2048',
            'slug'     => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $upload = Cloudinary::upload($request->file('logo')->getRealPath(), [
                'folder' => 'brands',
            ]);
            $data['logo_url']  = $upload->getSecurePath();
            $data['public_id'] = $upload->getPublicId();
        }

        Brand::create($data);
        Alert::success('Success', 'Brand created successfully.');
        return redirect()->route('brands.index');
    }

    public function edit(Brand $brand)
    {
        return view('pages.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'logo'     => 'nullable|image|max:2048',
            'slug'     => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            if ($brand->public_id) {
                Cloudinary::destroy($brand->public_id);
            }
            $upload = Cloudinary::upload($request->file('logo')->getRealPath(), [
                'folder' => 'brands',
            ]);
            $data['logo_url']  = $upload->getSecurePath();
            $data['public_id'] = $upload->getPublicId();
        }

        $brand->update($data);
        Alert::success('Success', 'Brand updated successfully.');
        return redirect()->route('brands.index');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->public_id) {
            Cloudinary::destroy($brand->public_id);
        }
        $brand->delete();
        Alert::success('Success', 'Brand deleted successfully.');
        return back();
    }
}
