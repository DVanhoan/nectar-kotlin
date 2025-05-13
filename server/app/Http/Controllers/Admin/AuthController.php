<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            Alert::success('Login successfully');
            Log::info('success');
            return redirect()->route('dashboard');
        } else {
            Log::info('error'  );
            Alert::error('Login failed');
            return back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('request' . json_encode($request->all()) );
        $request->validate([
            'username'         => 'required|string|max:255',
            'email'            => 'required|string|email|max:255|unique:users',
            'password'         => 'required|string|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin'
        ]);

        Auth::login($user);
        Alert::success('Registration successfully');
        return redirect()->route('dashboard');
    }
}
