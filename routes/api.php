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

$api = app('Dingo\Api\Routing\Router');



    $api->post('login', ['as'=>'api.login', 'uses'=>'Auth\Api\LoginController@login']);
    $api->post('verify-otp', ['as'=>'api.otp.verify', 'uses'=>'Auth\Api\LoginController@verifyOTP']);


    $api->group(['middleware' => ['auth:api','acl'], 'is'=>'customer'], function ($api) {
        $api->get('home', ['as'=>'api.home', 'uses'=>'Auth\Api\LoginController@home']);
        $api->post('add-cart', ['as'=>'api.cart', 'uses'=>'Customer\Api\CartController@store']);
        $api->get('make-order', ['as'=>'api.order', 'uses'=>'Customer\Api\OrderController@make']);
        $api->get('order-details/{id}', ['as'=>'api.order.details', 'uses'=>'Customer\Api\OrderController@details']);
        $api->get('order-history', ['as'=>'api.order.history', 'uses'=>'Customer\Api\OrderController@history']);
        $api->get('cancel-order/{id}', ['as'=>'api.order.cancel', 'uses'=>'Customer\Api\OrderController@cancel']);
        $api->get('return/{id}', ['as'=>'api.order.return', 'uses'=>'Customer\Api\OrderController@returnOrder']);
    });

    $api->get('category', ['as'=>'api.category', 'uses'=>'Customer\Api\CategoryController@index']);

    $api->get('category/{id}/product', ['as'=>'api.category', 'uses'=>'Customer\Api\CategoryController@cateproduct']);




//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
