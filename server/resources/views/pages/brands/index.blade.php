@extends('layout.index')

@section('content')
    <style>
        .table-striped th:nth-child(1), .table-striped td:nth-child(1) { width: 80px; }
        .table-striped th:nth-child(2), .table-striped td:nth-child(2) { width: 200px; }
        .brand-logo { max-width: 60px; max-height: 60px; object-fit: cover; }
    </style>

    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-6">
                <h3>Brands</h3>
                <a href="{{ route('brands.create') }}" class="tf-button style-1">
                    <i class="icon-plus"></i> Add New Brand
                </a>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between mb-4">
                    <form action="{{ route('brands.index') }}" class="flex gap-2">
                        <input type="text" name="search" class="form-input" placeholder="Search name..."
                               value="{{ request('search') }}">
                        <button type="submit" class="tf-button style-2">
                            <i class="icon-search"></i>
                        </button>
                    </form>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo & Name</th>
                            <th>Slug</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($brands as $brand)
                            <tr>
                                <td>{{ $brand->id }}</td>
                                <td class="flex items-center gap-2">
                                    @if($brand->logo_url)
                                        <img src="{{ $brand->logo_url }}" alt="" class="brand-logo">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                    <span>{{ Str::limit($brand->name, 30) }}</span>
                                </td>
                                <td>{{ $brand->slug }}</td>
                                <td>{{ $brand->products()->count() }}</td>
                                <td class="flex gap-2">
                                    <a href="{{ route('brands.edit', $brand) }}" class="text-primary">
                                        <i class="icon-edit-3"></i>
                                    </a>
                                    <form action="{{ route('brands.destroy', $brand) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this brand?');">
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
                                <td colspan="5" class="text-center">No brands found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $brands->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
@endsection
