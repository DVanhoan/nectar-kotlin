<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OtpService
{
    protected $authkey;
    protected $templateId;
    protected $sender;

    public function __construct()
    {
        $this->authkey     = config('services.msg91.auth_key');
        $this->templateId  = config('services.msg91.template_id');
        $this->sender      = config('services.msg91.sender_id');
    }

    public function sendOtp(string $phone): array
    {
        $response = Http::withHeaders([
            'authkey' => $this->authkey,
        ])->post('https://control.msg91.com/api/v5/otp', [
            'mobile'      => $phone,
            'template_id' => $this->templateId,
            'sender'      => $this->sender,
        ]);

        return $response->json();
    }

    public function verifyOtp(string $phone, string $otp): array
    {
        $response = Http::withHeaders([
            'authkey' => $this->authkey,
        ])->get('https://control.msg91.com/api/v5/otp/verify', [
            'mobile' => $phone,
            'otp'    => $otp,
        ]);

        return $response->json();
    }
}

