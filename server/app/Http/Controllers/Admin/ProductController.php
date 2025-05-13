<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category', 'brands', 'images');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->whereHas('brands', fn($q) => $q->where('brands.id', $request->brand_id));
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%'.$request->q.'%');
        }

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

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);

        if ($request->filled('brand_ids')) {
            $product->brands()->sync($request->brand_ids);
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $upload = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'products/' . $product->id,
                ]);

                $url        = $upload->getSecurePath();
                $publicId   = $upload->getPublicId();
                $isPrimary  = ($request->input('is_primary') == $index); // Check index

                $product->images()->create([
                    'url'        => $url,
                    'public_id'  => $publicId,
                    'is_primary' => $isPrimary,
                ]);
            }
        }

        return redirect()
            ->route('pages.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::pluck('name','id');
        $brands     = Brand::pluck('name','id');

        return view('pages.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $product->update($data);
        $product->brands()->sync($request->brand_ids ?? []);

        // Xoá ảnh nếu có yêu cầu
        if ($request->filled('remove_image_ids')) {
            $images = ProductImage::whereIn('id', $request->remove_image_ids)->get();

            foreach ($images as $img) {
                if ($img->public_id) {
                    Cloudinary::destroy($img->public_id);
                }
                $img->delete();
            }
        }

        // Upload ảnh mới
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $file) {
                $upload = Cloudinary::upload($file->getRealPath(), [
                    'folder' => 'products/' . $product->id,
                ]);

                $url        = $upload->getSecurePath();
                $publicId   = $upload->getPublicId();
                $isPrimary  = ($request->input('is_primary') == $index);

                $product->images()->create([
                    'url'        => $url,
                    'public_id'  => $publicId,
                    'is_primary' => $isPrimary,
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
            ->route('pages.products.index')
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
