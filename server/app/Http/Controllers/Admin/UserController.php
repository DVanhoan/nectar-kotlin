<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::paginate(20);
        return view('pages.users.index', compact('users'));
    }
    public function show(User $user)
    {
        return view('pages.users.show', compact('user'));
    }
    public function edit(User $user)
    {
        return view('pages.users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        $user->update($request->only(['name','email','phone_number','avatar_url']));
        return redirect()->route('pages.users.index')->with('success','User updated successfully.');
    }
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','User deleted successfully.');
    }
}
