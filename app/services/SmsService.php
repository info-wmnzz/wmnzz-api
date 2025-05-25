<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirebaseService
{
    protected $serverKey;

    public function __construct()
    {
        $this->serverKey = env('FIREBASE_SERVER_KEY');
    }

    public function sendNotification($deviceToken, $title, $body)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $data = [
            "to" => $deviceToken,  // Device token of the target device
            "notification" => [
                "title" => $title,
                "body" => $body,
            ],
            "priority" => "high"
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' . $this->serverKey,
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        return $response->body();
    }
}
