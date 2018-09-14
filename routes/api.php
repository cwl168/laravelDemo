<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/**
 * http://domain/api/auth/login
 */

/*Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');


});*/

//dingo demo
$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->post('login', 'App\Http\Controllers\Api\LoginController@login');
    $api->post('register', 'App\Http\Controllers\Api\RegisterController@register');
    $api->group(['middleware' => 'jwt.verify'], function ($api) {
        $api->get('logout', 'App\Http\Controllers\Api\LoginController@logout');
        $api->resource('user', 'App\Http\Controllers\Api\UserController');
    });
    $api->get('refresh', 'App\Http\Controllers\Api\UserController@refresh');
});