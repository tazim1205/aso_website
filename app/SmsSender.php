<?php

namespace App;




use Illuminate\Support\Str;

class SmsSender
{
    public function smsSender($to, $message)
    {
        $url = "http://gsms.putulhost.com/smsapi";
        $data = [
            "api_key" => "C200049960e72e0d0d2272.47267153",
            "type" => "{text}",
            "contacts" => "$to",
            "senderid" => "8809601001384",
            "msg" => "$message",
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        //Result
        return $response;
        //Error Display
        //echo curl_error($ch);

    }

}
