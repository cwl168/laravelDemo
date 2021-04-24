<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2019-12-20
 * Time: 08:52
 */
namespace App\Http\Sms;

interface SmsSenderContract
{
    public function send($phoneNumber, $message);
}