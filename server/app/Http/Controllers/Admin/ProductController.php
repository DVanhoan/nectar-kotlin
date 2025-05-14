<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'brand', 'images');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

        Log::info('search request'. $request->q);

        $products   = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::pluck('name','id');
        $brands     = Brand::pluck('name','id');

        return view('pages.products.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $categories = Category::pluck('name','id');
        $brands     = Brand::pluck('name','id');

        return view('pages.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required',
                'slug' => 'required|unique:products,slug',
                'price' => 'required',
                'category_id' => 'required',
                'brand_id' => 'required',
                'stock_quantity' => 'required',
                'description' => 'required',
                'volume_value' => 'required',
                'volume_unit' => 'required',
                'image' => 'required',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
            ]
        );

        $product = Product::create($data);

        if ($request->hasFile('image')) {
            $upload = Cloudinary::upload($request->image->getRealPath(), [
                'folder' => 'products/' . $product->id,
            ]);

            $url        = $upload->getSecurePath();
            $publicId   = $upload->getPublicId();

            $product->images()->create([
                'product_id' => $product->id,
                'url'        => $url,
                'public_id'  => $publicId,
                'is_primary' => true,
            ]);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $upload = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'products/' . $product->id,
                ]);

                $url        = $upload->getSecurePath();
                $publicId   = $upload->getPublicId();

                $product->images()->create([
                    'product_id' => $product->id,
                    'url'        => $url,
                    'public_id'  => $publicId,
                ]);
            }
        }

        Alert::success('Success', 'Product created successfully.');

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::pluck('name','id');
        $brands     = Brand::pluck('name','id');

        return view('pages.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:products,slug,' . $product->id,
            'price' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required|exists:brands,id',
            'stock_quantity' => 'required',
            'image' => 'nullable',
            'description' => 'required',
            'volume_value' => 'required',
            'volume_unit' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg'
        ]);

        dd($data);

        $product->update($data);

        if ($request->hasFile('image')) {
            $upload = Cloudinary::upload($request->image->getRealPath(), [
                'folder' => 'products/' . $product->id,
            ]);

            $url        = $upload->getSecurePath();
            $publicId   = $upload->getPublicId();

            $product->images()->create([
                'product_id' => $product->id,
                'url'        => $url,
                'public_id'  => $publicId,
                'is_primary' => true,
            ]);
        }


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $upload = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'products/' . $product->id,
                ]);

                $url        = $upload->getSecurePath();
                $publicId   = $upload->getPublicId();

                $product->images()->create([
                    'product_id' => $product->id,
                    'url'        => $url,
                    'public_id'  => $publicId,

                ]);
            }
        }

        // Đảm bảo chỉ có 1 ảnh là primary
        if ($request->has('is_primary')) {
            $product->images()->update(['is_primary' => false]);
            $selectedIndex = $request->input('is_primary');

            $latestImages = $product->images()->latest()->get();
            if (isset($latestImages[$selectedIndex])) {
                $latestImages[$selectedIndex]->update(['is_primary' => true]);
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $img) {
            if ($img->public_id) {
                Cloudinary::destroy($img->public_id);
            }
            $img->delete();
        }

        $product->delete();

        return back()->with('success', 'Product deleted successfully.');
    }
}
