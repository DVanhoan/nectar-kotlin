<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends Controller
{
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email',
            'password' => 'required|string',
            'phone_number' => 'required|string'
        ]);

        try {
            $body = $request->all();
            $body['password'] = Hash::make($body['password']);
            $user = User::create($body);

            return response()->json($user, 201);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Error during registration', 'error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = Auth::guard('api')->user();

        $expiresIn = Auth::guard('api')->factory()->getTTL() * 60;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiresIn,
            'user' => $user
        ]);
    }

    public function me()
    {
        $user = Auth::guard('api')->user();
        return response()->json($user, 200);
    }


    public function refresh()
    {
        try {
            $newToken = Auth::guard('api')->refresh();

            $expiresIn = Auth::guard('api')->factory()->getTTL() * 60;
            $user = Auth::guard('api')->user();

            return response()->json([
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => $expiresIn,
            ]);
        } catch (TokenInvalidException $e) {
            return response()->json(['message' => 'Invalid token, unable to refresh'], 401);
        } catch (JWTException $e) {
            return response()->json(['message' => 'Token refresh failed'], 500);
        }
    }

    public function logout()
    {
        try {
            auth('api')->logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error during logout', 'error' => $e->getMessage()], 500);
        }
    }

    public function editUser(Request $request) {
        $user = Auth::guard('api')->user();

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|string|email',
            'phone_number' => 'required|string',
            'avatar_url' => 'required|string'
        ]);

        if (!$request->hasAny(array_keys($validatedData))) {
            return response()->json(['error' => 'No data provided'], 400);
        }

        $user->update($validatedData);

        return response()->json($user, 200);
    }

}
