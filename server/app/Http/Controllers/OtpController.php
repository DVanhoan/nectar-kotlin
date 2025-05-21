<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OtpService;

class OtpController extends Controller
{
    public function sendOtp(Request $request, OtpService $otpService)
    {
        $phone = $request->input('phone');
        $result = $otpService->sendOtp($phone);
        return response()->json($result);
    }

    public function verifyOtp(Request $request, OtpService $otpService)
    {
        $phone = $request->input('phone');
        $otp = $request->input('otp');
        $result = $otpService->verifyOtp($phone, $otp);
        return response()->json($result);
    }
}
