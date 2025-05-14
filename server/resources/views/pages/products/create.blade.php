@extends('layout.index')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Add Product</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('dashboard')}}"><div class="text-tiny">Dashboard</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <a href="{{route('products.index')}}"><div class="text-tiny">Products</div></a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Add product</div>
                    </li>
                </ul>
            </div>

            <form class="tf-section-2 form-add-product" method="POST" enctype="multipart/form-data" action="{{route('products.store')}}" >
                @csrf
                <div class="wg-box">
                    <fieldset class="name">
                        <div class="body-title mb-10">Product name <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product name" name="name" tabindex="0" value="" aria-required="true">
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error("name") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset class="name">
                        <div class="body-title mb-10">Slug <span class="tf-color-1">*</span></div>
                        <input class="mb-10" type="text" placeholder="Enter product slug" name="slug" tabindex="0" value="" aria-required="true">
                        <div class="text-tiny">Do not exceed 100 characters when entering the product name.</div>
                    </fieldset>
                    @error("slug") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <div class="gap22 cols">
                        <fieldset class="category">
                            <div class="body-title mb-10">Category <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="category_id">
                                    <option value="">Choose category</option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ request('category_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error("category_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <fieldset class="brand">
                            <div class="body-title mb-10">Brand <span class="tf-color-1">*</span></div>
                            <div class="select">
                                <select name="brand_id">
                                    <option value="">Choose Brand</option>
                                    @foreach($brands as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ request('brand_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </fieldset>
                        @error("brand_id") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>

                    <fieldset class="description">
                        <div class="body-title mb-10">Description <span class="tf-color-1">*</span></div>
                        <textarea class="mb-10" name="description" placeholder="Description" tabindex="0" aria-required="true"></textarea>
                        <div class="text-tiny">Do not exceed 255 characters when entering the product description.</div>
                    </fieldset>
                    @error("description") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                </div>

                <div class="wg-box">
                    <fieldset>
                        <div class="body-title">Upload images <span class="tf-color-1">*</span></div>
                        <div class="upload-image flex-grow">
                            <div class="item" id="imgpreview" style="display:none">
                                <img src="{{asset('images/upload/upload-1.png')}}" class="effect8" alt="">
                            </div>
                            <div id="upload-file" class="item up-load">
                                <label class="uploadfile" for="myFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="body-text">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="myFile" name="image" accept="image/*">
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error("image") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <fieldset>
                        <div class="body-title mb-10">Upload Gallery Images</div>
                        <div class="upload-image mb-16">
                            <div  id ="galUpload" class="item up-load">
                                <label class="uploadfile" for="gFile">
                                    <span class="icon">
                                        <i class="icon-upload-cloud"></i>
                                    </span>
                                    <span class="text-tiny">Drop your images here or select <span class="tf-color">click to browse</span></span>
                                    <input type="file" id="gFile" name="images[]" accept="image/*" multiple>
                                </label>
                            </div>
                        </div>
                    </fieldset>
                    @error("images") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Regular Price <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter regular price" name="price" tabindex="0" value="" aria-required="true">
                        </fieldset>
                        @error("price") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Quantity <span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter quantity" name="stock_quantity" tabindex="0" value="" aria-required="true">
                        </fieldset>
                        @error("stock_quantity") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>


                    <div class="cols gap22">
                        <fieldset class="name">
                            <div class="body-title mb-10">Volume Value<span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter volume value" name="volume_value" tabindex="0" value="" aria-required="true">
                        </fieldset>
                        @error("volume_value") <span class="alert alert-danger text-center">{{$message}}</span> @enderror

                        <fieldset class="name">
                            <div class="body-title mb-10">Volume Unit<span class="tf-color-1">*</span></div>
                            <input class="mb-10" type="text" placeholder="Enter volume unit" name="volume_unit" tabindex="0" value="" aria-required="true">
                        </fieldset>
                        @error("volume_unit") <span class="alert alert-danger text-center">{{$message}}</span> @enderror
                    </div>

                    <div class="cols gap10">
                        <button class="tf-button w-full" type="submit">Add product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(function(){
            $("#myFile").on("change",function(e){
                const photoInp = $("#myFile");
                const [file] = this.files;
                if (file) {
                    $("#imgpreview img").attr('src',URL.createObjectURL(file));
                    $("#imgpreview").show();
                }
            });


            $("#gFile").on("change",function(e){
                $(".gitems").remove();
                const gFile = $("gFile");
                const gphotos = this.files;
                $.each(gphotos,function(key,val){
                    $("#galUpload").prepend(`<div class="item gitems"><img src="${URL.createObjectURL(val)}" alt=""></div>`);
                });
            });


            $("input[name='name']").on("change",function(){
                $("input[name='slug']").val(StringToSlug($(this).val()));
            });

        });
        function StringToSlug(Text) {
            return Text.toLowerCase()
                .replace(/[^\w ]+/g, "")
                .replace(/ +/g, "-");
        }
    </script>
@endpush
