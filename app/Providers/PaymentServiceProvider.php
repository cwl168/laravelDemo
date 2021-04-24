<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2019-12-31
 * Time: 10:38
 */
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use PaymentGateway\Payment;

class PaymentServiceProvider extends ServiceProvider
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


    // 注册一个服务,其实就是把一个类放入ioc中
    public function register()
    {

        $this->app->bind('Pay', function()
        {
            return new Payment();
        });

    }
}