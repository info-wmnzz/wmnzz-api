<?php

use Laravolt\Avatar\Facade as Avatar;

if (! function_exists('generateId')) {
    function generateId($name, $length = 6)
    {
        $prefix = 'WMNZ';
        $shortName = strtoupper(substr(preg_replace('/\s+/', '', $name), 0, 3));
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $random = '';

        for ($i = 0; $i < $length; $i++) {
            $random .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $prefix.$shortName.$random;
    }
}

if (! function_exists('createSlug')) {
    function createSlug($string)
    {
        return \Str::slug($string, '-');
    }
}

if (! function_exists('avatarCreation')) {
    function avatarCreation($name, $surName)
    {
        // Create avatar
        $name = strtoupper(trim($name.' '.$surName));
        $avatar = Avatar::create($name)->getImageObject();

        // Save avatar to temporary path
        $filename = 'avatar_'.Str::slug($name).'.png';
        $tempPath = storage_path('app/public/'.$filename);
        $avatar->save($tempPath, 'png');

        // Add avatar to media library
        $user->addMedia($tempPath)->toMediaCollection('userprofile');

        // Optionally delete the temp file
        unlink($tempPath);
    }
}

if (! function_exists('sendSms')) {
    function sendSms($phoneNumber)
    {
        try {
            if (env('APP_ENV') == 'local') {
                $otp = '123456';
            } else {
                $otp = substr(str_shuffle('123456789'), 0, 6);
                $passMobileNumber = '+91'.$phoneNumber;
                $params = [
                    'credentials' => [
                        'key' => env('AWS_ACCESS_KEY_ID'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),
                    ],
                    'region' => 'ap-south-1',
                    'version' => 'latest',
                ];
                $sns = new \Aws\Sns\SnsClient($params);

                $args = [
                    'MessageAttributes' => [
                        'AWS.SNS.SMS.SMSType' => [
                            'DataType' => 'String',
                            'StringValue' => 'Transactional',
                        ],
                    ],
                    'Message' => 'Wmnzz 🔐: Your magic code is,'.$otp.' Valid for 5 mins — don’t spill it 💅',
                    'PhoneNumber' => $passMobileNumber,
                ];
                $result = $sns->publish($args);
            }

            return $otp;
        } catch (\ClientException $ex) {
            $otp = '';

            return $otp;
        }
    }
}

if (! function_exists('sendWhatsAppOtp')) {

    function sendWhatsAppOtp($phoneNumber)
    {
        try {
            
            $allowedNumbers = [
                '919842999076',
                '917540039846',
            ];

            $otp = rand(100000, 999999);

            if (! in_array($phoneNumber, $allowedNumbers)) {
                return '666666';
            }

            $response = \Http::asForm()->withHeaders([
                'apikey' => env('GUPSHUP_API_KEY'),
                'Cache-Control' => 'no-cache',
            ])->post('https://api.gupshup.io/wa/api/v1/msg', [
                'channel' => 'whatsapp',
                'source' => env('GUPSHUP_SENDER'),
                'destination' => $phoneNumber,
                'src.name' => env('GUPSHUP_APP_NAME', 'app'),
                'message' => json_encode([
                    'type' => 'text',
                    'text' => "Your OTP code is: $otp. Valid for 5 minutes.",
                ]),
            ]);
            if ($response->failed()) {
                \Log::error('WhatsApp OTP Failed', [
                    'phone' => $phoneNumber,
                    'response' => $response->body(),
                ]);

                return null;
            }
            return $otp;

        } catch (\Exception $ex) {

            \Log::error('WhatsApp OTP Exception', [
                'error' => $ex->getMessage(),
            ]);

            return null;
        }
    }
}
