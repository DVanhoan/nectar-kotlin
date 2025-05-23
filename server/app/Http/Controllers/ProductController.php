<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with(['category', 'brand', 'images'])->paginate(10);
        return response()->json($products);
    }


    public function show($id)
    {
        $product = Product::with(['category', 'brand', 'images'])->find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }


    public function search(Request $request)
    {
        $query = $request->query('q');

        $products = Product::where('name', 'LIKE', "%$query%")
            ->with(['category', 'brand', 'images'])
            ->paginate(10);

        return response()->json($products);
    }


    public function filter(Request $request)
    {
        $products = Product::query();

        if ($request->has('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        if ($request->has('brand_id')) {
            $products->where('brand_id', $request->brand_id);
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $products->whereBetween('price', [$request->min_price, $request->max_price]);
        }

        $products = $products->with(['category', 'brand', 'images'])->paginate(10);

        return response()->json($products);
    }
}
