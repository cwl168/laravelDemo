<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2019-12-20
 * Time: 08:54
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Sms\SmsSenderContract;
use App\Http\Sms\TwilioSender;
use App\Http\Sms\NexmoSender;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        /*$this->app->bind(
            SmsSenderContract::class, function () {
            return new TwilioSender();
        });*/
        //$this->app->bind(SmsSenderContract::class,NexmoSender::class);

    }
}