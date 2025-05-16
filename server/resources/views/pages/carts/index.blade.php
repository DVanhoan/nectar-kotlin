@extends('layout.index')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-6">
                <h3>All Products</h3>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between mb-4">
                    <form action="{{ route('products.index') }}" class="flex gap-2">
                        <select name="category_id" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $id => $name)
                                <option value="{{ $id }}"
                                    {{ request('category_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <select name="brand_id" class="form-select">
                            <option value="">All Brands</option>
                            @foreach($brands as $id => $name)
                                <option value="{{ $id }}"
                                    {{ request('brand_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="text" name="q" class="form-input" placeholder="Search name..."
                               value="{{ request('q') }}">
                        <button type="submit" class="tf-button style-2">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Brands</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->primaryImage)
                                        <img src="{{ $product->primaryImage->url }}" alt=""
                                             style="max-width: 60px; max-height: 60px; object-fit: cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($product->name, 30) }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->brand->name }}</td>
                                <td>${{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>
                                <span class="status-badge {{ $product->active ? 'active' : 'deleted' }}">
                                    {{ $product->active ? 'Active' : 'Inactive' }}
                                </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start gap-4 align-items-center">

                                        <a href="{{ route('products.edit', $product) }}" class="text-primary">
                                            <i class="icon-edit"></i>
                                        </a>

                                        <form action="{{ route('products.destroy', $product) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="btn text-danger p-0 m-0 delete-btn"
                                                    data-id="{{ $product->id }}">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No products found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
