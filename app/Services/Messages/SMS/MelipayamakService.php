<?php

namespace App\Services\Messages\SMS;

use Melipayamak;
class MelipayamakService
{
    public function sendSimpleSMS($receiver , $content )
    {
        try {
            $sms = Melipayamak::sms();
            $to = $receiver;
            $from = '50002710064671';
            $text = $content;
            $response = $sms->send($to,$from,$text) ;
            $json = json_decode($response);
            echo $json->Value;
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}
