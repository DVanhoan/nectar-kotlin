@extends('layout.index')

@section('content')
    <div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center justify-between mb-6 gap-4 flex-wrap">
                <h3>Edit User</h3>
                <ul class="breadcrumbs flex items-center gap-2">
                    <li><a href="{{ route('dashboard') }}"><div class="text-tiny">Dashboard</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><a href="{{ route('users.index') }}"><div class="text-tiny">Users</div></a></li>
                    <li><i class="icon-chevron-right"></i></li>
                    <li><div class="text-tiny">Edit User</div></li>
                </ul>
            </div>

            <div class="wg-box">
                <form action="{{ route('users.update', $user) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="form-style-1">
                    @csrf
                    @method('PUT')

                    <fieldset class="name mb-4">
                        <label class="body-title">Name <span class="tf-color-1">*</span></label>
                        <input type="text" name="name"
                               value="{{ old('name', $user->name) }}"
                               placeholder="Full name"
                               required
                               class="form-input w-full">
                        @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name mb-4">
                        <label class="body-title">Email <span class="tf-color-1">*</span></label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               placeholder="Email address"
                               required
                               class="form-input w-full">
                        @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name mb-4">
                        <label class="body-title">Phone Number</label>
                        <input type="text" name="phone_number"
                               value="{{ old('phone_number', $user->phone_number) }}"
                               placeholder="Phone number"
                               class="form-input w-full">
                        @error('phone_number')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="name mb-4">
                        <label class="body-title">Role</label>
                        <select name="role" class="form-input w-full">
                            <option value="admin"    {{ $user->role === 'admin'    ? 'selected' : '' }}>Admin</option>
                            <option value="customer"    {{ $user->role === 'customer'    ? 'selected' : '' }}>Customer</option>
                            <option value="shipper"   {{ $user->role === 'shipper'   ? 'selected' : '' }}>Shipper</option>
                        </select>
                        @error('role')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <fieldset class="mb-4">
                        <label class="body-title">Avatar</label>
                        <div class="upload-image flex items-center gap-4">
                            <div id="imgpreview" style="display: {{ $user->avatar_url ? 'block' : 'none' }};">
                                <img
                                    src="{{ $user->avatar_url ?? '#' }}"
                                    alt="Avatar"
                                    class="max-w-[80px] max-h-[80px] object-cover rounded-full"
                                >
                            </div>
                            <label for="avatar" class="item up-load cursor-pointer">
                                <span class="icon"><i class="icon-upload-cloud"></i></span>
                                <span class="body-text">
                                    Drop your image here or <span class="tf-color">click to browse</span>
                                </span>
                                <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden">
                            </label>
                        </div>
                        @error('avatar')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </fieldset>

                    <div class="flex justify-end">
                        <button type="submit" class="tf-button w208">
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const input = document.getElementById('avatar');
        const previewDiv = document.getElementById('imgpreview');
        const previewImg = previewDiv.querySelector('img');

        input.addEventListener('change', function(){
            const file = this.files[0];
            if (!file) return;

            previewImg.src = URL.createObjectURL(file);
            previewDiv.style.display = 'block';
        });
    </script>

@endpush
