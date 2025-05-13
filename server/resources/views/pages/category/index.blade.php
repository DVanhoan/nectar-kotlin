@extends('layout.index')

@section('content')
    <style>
        .table-striped th:nth-child(1), .table-striped td:nth-child(1) { width: 80px; }
        .table-striped th:nth-child(2), .table-striped td:nth-child(2) { width: 250px; }
        .category-image { max-width: 60px; max-height: 60px; object-fit: cover; }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-6">
                <h3>All Categories</h3>
                <a href="{{ route('categories.create') }}" class="tf-button style-1">
                    <i class="icon-plus"></i> Add New Category
                </a>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between mb-4">
                    <form action="{{ route('categories.index') }}" class="flex gap-2">
                        <input type="text" name="search" class="form-input" placeholder="Search name..."
                               value="{{ request('search') }}">
                        <button type="submit" class="tf-button style-2">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                </div>

                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name & Image</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td class="pname flex items-center gap-2">
                                @if($category->image)
                                    <img src="{{ $category->image }}"
                                         class="category-image" alt="{{ $category->name }}">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                                <span>{{ Str::limit($category->name, 30) }}</span>
                            </td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->products()->count() }}</td>
                            <td class="flex items-center gap-2">
                                <a href="{{ route('categories.edit', $category) }}" class="text-primary">
                                    <i class="icon-edit-3"></i>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                      onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger btn-unstyled">
                                        <i class="icon-trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No categories found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $categories->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
