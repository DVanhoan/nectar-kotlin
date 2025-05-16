<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(20);
        return view('pages.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->only(['name', 'email', 'phone_number']);

        if ($request->hasFile('avatar')) {
            $uploadedFileUrl = Cloudinary::upload(
                $request->file('avatar')->getRealPath(),
                ['folder' => 'avatars']
            )->getSecurePath();
            $data['avatar_url'] = $uploadedFileUrl;
        }

        $user->update($data);

        Alert::success('Success', 'User updated successfully.');

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        Alert::success('Deleted', 'User deleted successfully.');
        return back();
    }
}
