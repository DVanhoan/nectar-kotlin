@extends('layout.index')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
                <h3>New Brand</h3>
                <ul class="breadcrumbs flex items-center gap-2">
                    <li><a href="{{ route('dashboard') }}"><div class="text-tiny">Dashboard</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('brands.index') }}"><div class="text-tiny">Brands</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">New Brand</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('brands.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="form-new-product form-style-1">
                    @csrf

                    <fieldset class="mb-4">
                        <label class="body-title">Name <span class="tf-color-1">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name') }}"
                               placeholder="Brand name"
                               required
                               class="form-input w-full">
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="mb-4">
                        <label class="body-title">Slug</label>
                        <input type="text" name="slug"
                               value="{{ old('slug') }}"
                               placeholder="brand-slug"
                               class="form-input w-full">
                        @error('slug')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="mb-4">
                        <label class="body-title">Logo</label>
                        <div class="upload-image flex items-center gap-4">
                            <div id="imgpreview" style="display:none">
                                <img src="#" alt="Preview" class="max-w-[80px] max-h-[80px] object-cover">
                            </div>
                            <label for="logo" class="item up-load cursor-pointer">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">
                                Drop your logo here or <span class="tf-color">click to browse</span>
                            </span>
                                <input type="file" name="logo" id="logo" accept="image/*" class="hidden">
                            </label>
                        </div>
                        @error('logo')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <div class="flex justify-end">
                        <button type="submit" class="tf-button w208">
                            Save Brand
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('logo').addEventListener('change', function(){
            const file = this.files[0];
            if (!file) return;
            const preview = document.querySelector('#imgpreview img');
            preview.src = URL.createObjectURL(file);
            document.getElementById('imgpreview').style.display = 'block';
        });

        document.querySelector("input[name='name']").addEventListener('input', function(){
            const slug = this.value.toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
            document.querySelector("input[name='slug']").value = slug;
        });
    </script>
@endpush
