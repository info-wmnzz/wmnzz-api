<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PushNotificationService;

class NotificationController extends Controller
{
    public function send()
    {
        $sns = new PushNotificationService();

        $deviceEndpointArn = "arn:aws:sns:ap-south-1:108367189631:app/GCM/Wmnzz";

        $sns->sendNotification($deviceEndpointArn, "Hello, you got a push notification!", "Wmnzz App");

        return response()->json(['success' => true]);
    }
}
