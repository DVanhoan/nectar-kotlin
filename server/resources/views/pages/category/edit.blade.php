@extends('layout.index')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
                <h3>Edit Category</h3>
                <ul class="breadcrumbs flex items-center gap-2">
                    <li><a href="{{ route('dashboard') }}"><div class="text-tiny">Dashboard</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('categories.index') }}"><div class="text-tiny">Categories</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Edit Category</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('categories.update', $category) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="form-new-product form-style-1">
                    @csrf
                    @method('PUT')

                    <fieldset class="name mb-4">
                        <label class="body-title">Name <span class="tf-color-1">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name', $category->name) }}"
                               placeholder="Category name"
                               required
                               class="form-input w-full">
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name mb-4">
                        <label class="body-title">Slug <span class="tf-color-1">*</span></label>
                        <input type="text" name="slug"
                               value="{{ old('slug', $category->slug) }}"
                               placeholder="category-slug"
                               required
                               class="form-input w-full">
                        @error('slug')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="mb-4">
                        <label class="body-title">Image</label>
                        <div class="upload-image flex items-center gap-4">
                            @if($category->image)
                                <div id="imgpreview">
                                    <img src="{{ $category->image }}"
                                         alt="{{ $category->name }}"
                                         class="max-w-[80px] max-h-[80px] object-cover">
                                </div>
                            @else
                                <div id="imgpreview" style="display:none">
                                    <img src="#" alt="Preview" class="max-w-[80px] max-h-[80px] object-cover">
                                </div>
                            @endif
                            <label for="image" class="item up-load cursor-pointer">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">
                                Drop your image here or <span class="tf-color">click to browse</span>
                            </span>
                                <input type="file" name="image" id="image" accept="image/*" class="hidden">
                            </label>
                        </div>
                        @error('image')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <div class="flex justify-end">
                        <button type="submit" class="tf-button w208">
                            Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function(){
            const file = this.files[0];
            if (!file) return;
            let preview = document.querySelector('#imgpreview img');
            if (!preview) {
                const div = document.getElementById('imgpreview');
                div.style.display = 'block';
                preview = div.querySelector('img');
            }
            preview.src = URL.createObjectURL(file);
        });

        document.querySelector("input[name='name']").addEventListener('input', function(){
            const slug = this.value.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            document.querySelector("input[name='slug']").value = slug;
        });
    </script>
@endpush
