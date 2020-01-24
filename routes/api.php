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

    /*
     * Customer App Apis Starts
     */
    $api->group(['middleware' => ['auth:api']], function ($api) {
        $api->get('home', ['as'=>'api.home', 'uses'=>'Auth\Api\LoginController@home']);
        $api->get('make-order', ['as'=>'api.order', 'uses'=>'Customer\Api\OrderController@make']);
        $api->get('make-query/{id}', ['as'=>'api.query', 'uses'=>'Customer\Api\OrderController@makeQuery']);
        $api->get('order-details/{id}', ['as'=>'api.order.details', 'uses'=>'Customer\Api\OrderController@details']);
        $api->get('order-history', ['as'=>'api.order.history', 'uses'=>'Customer\Api\OrderController@history']);
        $api->post('set-address/{id}', ['as'=>'api.order.address', 'uses'=>'Customer\Api\OrderController@setAddress']);
        $api->post('set-time/{id}', ['as'=>'api.order.address', 'uses'=>'Customer\Api\OrderController@setTime']);
        $api->get('date-time-slots', ['as'=>'api.times', 'uses'=>'Customer\Api\OrderController@getTimeSlots']);
        $api->get('get-profile', ['as'=>'api.profileget', 'uses'=>'Customer\Api\ProfileController@getProfile']);
        $api->post('set-profile', ['as'=>'api.profileset', 'uses'=>'Customer\Api\ProfileController@setProfile']);
    });

    $api->get('home', ['as'=>'api.home', 'uses'=>'Customer\Api\HomeController@index']);
    $api->get('category/{id}/subcategory', ['as'=>'api.category', 'uses'=>'Customer\Api\CategoryController@subcategory']);
    $api->get('category/{id}/product', ['as'=>'api.product', 'uses'=>'Customer\Api\CategoryController@cateproduct']);
    $api->get('product/{id}', ['as'=>'api.product', 'uses'=>'Customer\Api\ProductController@details']);
    $api->get('cart-details', ['as'=>'api.cart.details', 'uses'=>'Customer\Api\CartController@getCartDetails']);
    $api->post('add-cart', ['as'=>'api.cart', 'uses'=>'Customer\Api\CartController@store']);
    $api->post('submit-review/{id}', ['as'=>'api.review', 'uses'=>'Customer\Api\OrderController@review']);
    /*
     * Customer App Apis Starts
     */

    $api->group(['middleware' => ['auth:api','acl'], 'is'=>'vendor'], function ($api) {
        $api->get('get-orders', ['as'=>'vendor.api.orders', 'uses'=>'Partner\Api\OrderController@index']);
        $api->get('vendor/order-details/{id}', ['as'=>'vendor.api.details', 'uses'=>'Partner\Api\OrderController@details']);
        $api->get('my-services', ['as'=>'vendor.api.getservices', 'uses'=>'Partner\Api\ProfileController@services']);
        $api->post('add-service', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@addServices']);
        $api->post('delete-service', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@delServices']);
        $api->get('my-times', ['as'=>'vendor.api.gettimes', 'uses'=>'Partner\Api\ProfileController@times']);
        $api->post('add-time', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@addTime']);
        $api->post('delete-time', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@delTime']);

        $api->post('my-availablity', ['as'=>'vendor.api.orders', 'uses'=>'Partner\Api\ProfileController@store']);
        $api->post('complete-service/{id}', ['as'=>'vendor.api.completeorders', 'uses'=>'Partner\Api\OrderController@completeService']);

    });


//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
