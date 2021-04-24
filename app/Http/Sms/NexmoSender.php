<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2019-12-20
 * Time: 08:51
 */
namespace App\Http\Sms;

class NexmoSender implements SmsSenderContract
{

    public function send($phoneNumber, $message)
    {
        return $phoneNumber.$message;
    }
}