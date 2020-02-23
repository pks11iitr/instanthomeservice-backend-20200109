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
        $api->post('submit-review/{id}', ['as'=>'api.review', 'uses'=>'Customer\Api\OrderController@review']);
        $api->get('pay-now/{id}', ['as'=>'api.pay', 'uses'=>'Customer\Api\OrderController@paynow']);
        $api->post('verify-payment', ['as'=>'api.pay.verify', 'uses'=>'Customer\Api\OrderController@verifyPayment']);
        $api->post('add-money', ['as'=>'api.pay', 'uses'=>'Customer\Api\WalletController@addMoney']);
        $api->post('verify-recharge/{id}', ['as'=>'api.pay.verify', 'uses'=>'Customer\Api\WalletController@verifyRecharge']);
        $api->get('wallet-balance', ['as'=>'api.balance', 'uses'=>'Customer\Api\WalletController@getWalletBalance']);
        $api->get('wallet-history', ['as'=>'api.history', 'uses'=>'Customer\Api\WalletController@history']);
        $api->post('coupon-check', ['as'=>'api.coupon', 'uses'=>'Customer\Api\OrderController@checkCoupon']);
        $api->get('complaints', ['as'=>'api.history', 'uses'=>'Customer\Api\CompaintController@index']);
        $api->post('complaints', ['as'=>'api.history.post', 'uses'=>'Customer\Api\CompaintController@store']);
        $api->get('orderid-list', ['as'=>'api.order.idlist', 'uses'=>'Customer\Api\CompaintController@orderlist']);

    });

    $api->get('home', ['as'=>'api.home', 'uses'=>'Customer\Api\HomeController@index']);
    $api->get('category/{id}/subcategory', ['as'=>'api.category', 'uses'=>'Customer\Api\CategoryController@subcategory']);
    $api->get('category/{id}/product', ['as'=>'api.product', 'uses'=>'Customer\Api\CategoryController@cateproduct']);
    $api->get('product/{id}', ['as'=>'api.product', 'uses'=>'Customer\Api\ProductController@details']);
    $api->get('cart-details', ['as'=>'api.cart.details', 'uses'=>'Customer\Api\CartController@getCartDetails']);
    $api->post('add-cart', ['as'=>'api.cart', 'uses'=>'Customer\Api\CartController@store']);
    /*
     * Customer App Apis Starts
     */

    $api->group(['middleware' => ['auth:api','acl'], 'is'=>'vendor'], function ($api) {
        $api->get('get-orders', ['as'=>'vendor.api.orders', 'uses'=>'Partner\Api\OrderController@index']);
        $api->post('update-availability', ['as'=>'vendor.api.availability', 'uses'=>'Partner\Api\ProfileController@updateAvailability']);
        $api->get('vendor/order-details/{id}', ['as'=>'vendor.api.details', 'uses'=>'Partner\Api\OrderController@details']);
        $api->get('my-services', ['as'=>'vendor.api.getservices', 'uses'=>'Partner\Api\ProfileController@services']);
        $api->post('add-service', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@addServices']);
        $api->post('delete-service', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@delServices']);
        $api->get('my-times', ['as'=>'vendor.api.gettimes', 'uses'=>'Partner\Api\ProfileController@times']);
        $api->post('add-time', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@addTime']);
        $api->post('delete-time', ['as'=>'vendor.api.setsetvices', 'uses'=>'Partner\Api\ProfileController@delTime']);
        $api->get('accept-agreement', ['as'=>'vendor.api.aggrement', 'uses'=>'Partner\Api\ProfileController@acceptAggrement']);
        $api->get('get-agreement', ['as'=>'vendor.api.getaggrement', 'uses'=>'Partner\Api\ProfileController@getAggrementDetails']);
        $api->post('my-availablity', ['as'=>'vendor.api.orders', 'uses'=>'Partner\Api\ProfileController@store']);
        $api->post('complete-service/{id}', ['as'=>'vendor.api.completeorders', 'uses'=>'Partner\Api\OrderController@completeService']);
        $api->get('accept-order/{id}', ['as'=>'vendor.api.accept', 'uses'=>'Partner\Api\OrderController@acceptOrder']);
        $api->get('reject-order/{id}', ['as'=>'vendor.api.reject', 'uses'=>'Partner\Api\OrderController@rejectOrder']);
        $api->get('start-processing/{id}', ['as'=>'vendor.api.start', 'uses'=>'Partner\Api\OrderController@startProcessing']);

    });

$api->get('download-invoice/{id}', 'Customer\Api\OrderController@invoice')->name('download.invoice');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
