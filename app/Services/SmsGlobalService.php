<?php

namespace App\Services;

use GuzzleHttp\Client;

class SmsGlobalService
{
    public static function sendSms($customer, string $message)
    {
        // $apiUrl = config('services.smsglobal.api_url');
        // $user = config('services.smsglobal.user');
        // $password = config('services.smsglobal.password');
        // $origin = config('services.smsglobal.origin');

        // $client = new Client();
        // $response = $client->post($apiUrl, [
        //     'form_params' => [
        //         'action' => 'sendsms',
        //         'user' => $user,
        //         'password' => $password,
        //         'from' => $origin,
        //         'to' => $customer->phone,
        //         'text' => $message,
        //     ],
        // ]);

        $api_id = config('services.smsala.api_id');
        $api_password = config('services.smsala.api_password');
        $sender_id = config('services.smsala.sender_id');

        $curl = curl_init();
        $url = 'https://api.smsala.com/api/SendSMS?' . http_build_query([
            'api_id' => $api_id,
            'api_password' => $api_password,
            'sms_type' => 'T',
            'encoding' => 'T',
            'sender_id' => $sender_id,
            'phonenumber' => $customer->phone,
            'textmessage' => $message,
            'uid' => 'knexpress',
            'callback_url' => 'https://knexpress.ae/',
        ]);

        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
