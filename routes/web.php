<?php

Route::get('/', function () {
    return view('welcome');
    //return redirect(route('login'));
});

Auth::routes();

//this will be removed after setting proper redirection

Route::group(['middleware'=>['auth', 'acl'], 'prefix'=>'admin', 'is'=>'admin'], function(){
    Route::get('dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');

//Route::get('/dashboard', 'HomeController@index')->name('dashboard');
Route::get('/users','UsersController@users')->name('users');
Route::get('/usersdetail/{id}','UsersController@usersdetail')->name('usersdetail');
Route::get('/roleuser','RoleuserController@roleuser')->name('roleuser');
Route::get('/role','RoleController@role')->name('role');
Route::get('/otps','OtpsController@otps')->name('otps');
Route::group(['prefix'=>'category'], function(){
    Route::get('/','CategoryController@index')->name('category.list');
    Route::get('create','CategoryController@create')->name('category.create');
    Route::post('store','CategoryController@store')->name('category.store');
    Route::get('edit/{id}','CategoryController@edit')->name('category.edit');
    Route::post('update/{id}','CategoryController@update')->name('category.update');
});
Route::group(['prefix'=>'partners'],function (){
    Route::get('/','PartnersController@index')->name('partners.list');
    Route::get('create','PartnersController@create')->name('partners.create');
    Route::post('store','PartnersController@store')->name('partners.store');
    Route::get('edit/{id}','PartnersController@edit')->name('partners.edit');
    Route::post('update/{id}','PartnersController@update')->name('partners.update');
});
Route::group(['prefix'=>'products'],function (){
    Route::get('/','ProductsController@index')->name('products.list');
    Route::get('create','ProductsController@create')->name('products.create');
    Route::post('store','ProductsController@store')->name('products.store');
    Route::get('detail/{id}','ProductsController@detail')->name('products.detail');
    Route::get('edit/{id}','ProductsController@edit')->name('products.edit');
    Route::post('update/{id}','ProductsController@update')->name('products.update');
});
Route::group(['prefix'=>'orders'],function (){
    Route::get('/','OrdersController@index')->name('orders.list');
    Route::get('/permissions','PermissionsController@permissions')->name('permissions');
    Route::get('/permissionrole','PermissionroleController@permissionrole')->name('permissionrole');
    Route::get('detail/{id}','OrdersController@detail')->name('orders.detail');
});
Route::get('/cart','CartController@cart')->name('cart');
Route::get('/permissionuser','PermissionuserController@permissionuser')->name('permissionuser');

});
