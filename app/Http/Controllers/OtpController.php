<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function sendWhatsAppOtp()
    {
      $otp = rand(1000, 9999);
$recipientNumber = '917540039846'; // Ensure this has the country code

$response = \Http::asForm()->withHeaders([
    'apikey' => env('GUPSHUP_API_KEY'), // Ensure this is the sk_4caa... key
    'Cache-Control' => 'no-cache',
])->post('https://api.gupshup.io/wa/api/v1/msg', [ // Changed /sm/ to /wa/
    'channel'     => 'whatsapp',
    'source'      => env('GUPSHUP_SENDER'),
    'destination' => $recipientNumber,
    'src.name'    => 'woomenzz',
    // Message must be a JSON string for the /wa/ endpoint
    'message'     => json_encode([
        'type' => 'text',
        'text' => "Your OTP code is: $otp. Valid for 5 minutes."
    ]),
]);

        if ($response->failed()) {
    return response()->json([
        'status' => 'error',
        'http_code' => $response->status(), // e.g., 401, 403, 400
        'error_body' => $response->body(),   // This shows the actual text from Gupshup
        'handler_error' => $response->reason() // e.g., "Unauthorized" or "Bad Request"
    ]);
}

        if ($response->successful()) {
            // Save $otp in your database or cache to verify later
            return response()->json(['status' => 'success', 'message' => 'OTP Sent!']);
        }

        return response()->json(['status' => 'error', 'data' => $response->json()], 400);
    }
}
