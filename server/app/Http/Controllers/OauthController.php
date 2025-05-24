<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Http;


class OauthController extends Controller
{


    public function facebookLogin(Request $request)
    {
        $accessToken = $request->input('access_token');



        try {
            $fbUser = Socialite::driver('facebook')->userFromToken($accessToken);

            $user = User::firstOrCreate(
                ['facebook_id' => $fbUser->id],
                [
                    'name' => $fbUser->name,
                    'email' => $fbUser->email,
                    'facebook_id' => $fbUser->id,

                    'password' => bcrypt(Str::random(16)),
                ]
            );

            $token = $user->createToken('facebook_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 3600,
                'user' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid Facebook token'], 401);
        }
    }

}
