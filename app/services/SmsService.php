<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Aws\Sns\SnsClient;

class FirebaseService
{
    protected $sns;

    public function __construct()
    {
        $this->sns = new SnsClient([
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'region'      => 'ap-south-1',
            'version'     => 'latest',
        ]);
    }

    public function sendNotification($targetArn, $message, $title = 'New Notification')
    {
        $payload = [
            'default' => $message,
            'GCM'     => json_encode([
                'notification' => [
                    'title' => $title,
                    'body'  => $message,
                ],
                'data'         => [
                    'extra' => 'value_here',
                ],
            ]),
            'APNS'    => json_encode([
                'aps' => [
                    'alert' => [
                        'title' => $title,
                        'body'  => $message,
                    ],
                    'sound' => 'default',
                ],
            ]),
        ];

        return $this->sns->publish([
            'TargetArn'        => $targetArn, // device endpoint ARN from SNS
            'MessageStructure' => 'json',
            'Message'          => json_encode($payload),
        ]);
    }
}
