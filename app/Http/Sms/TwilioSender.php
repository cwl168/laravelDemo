<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2019-12-20
 * Time: 08:53
 */
namespace App\Http\Sms;

class TwilioSender implements SmsSenderContract
{
    public function send($phoneNumber, $message)
    {
        return $phoneNumber.$message;
    }
}