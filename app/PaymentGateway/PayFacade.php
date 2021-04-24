<?php
/**
 * Created by PhpStorm.
 * User: caoweilin
 * Date: 2019-12-31
 * Time: 10:35
 */
namespace PaymentGateway;
use Illuminate\Support\Facades\Facade;
class PayFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Pay';
    }
}