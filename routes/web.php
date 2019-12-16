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
    Route::get('/users','Admin\UsersController@users')->name('users');
    Route::get('/usersdetail/{id}','Admin\UsersController@usersdetail')->name('usersdetail');
    Route::group(['prefix'=>'category'], function(){
        Route::get('/','Admin\CategoryController@index')->name('category.list');
        Route::get('create','Admin\CategoryController@create')->name('category.create');
        Route::post('store','Admin\CategoryController@store')->name('category.store');
        Route::get('edit/{id}','Admin\CategoryController@edit')->name('category.edit');
        Route::post('update/{id}','Admin\CategoryController@update')->name('category.update');
    });
    Route::group(['prefix'=>'partners'],function (){
        Route::get('/','Admin\PartnersController@index')->name('partners.list');
        Route::get('create','Admin\PartnersController@create')->name('partners.create');
        Route::post('store','Admin\PartnersController@store')->name('partners.store');
        Route::get('edit/{id}','Admin\PartnersController@edit')->name('partners.edit');
        Route::post('update/{id}','Admin\PartnersController@update')->name('partners.update');
    });
    Route::group(['prefix'=>'products'],function (){
        Route::get('/','Admin\ProductsController@index')->name('products.list');
        Route::get('create','Admin\ProductsController@create')->name('products.create');
        Route::post('store','Admin\ProductsController@store')->name('products.store');
        Route::get('detail/{id}','Admin\ProductsController@detail')->name('products.detail');
        Route::get('edit/{id}','Admin\ProductsController@edit')->name('products.edit');
        Route::post('update/{id}','Admin\ProductsController@update')->name('products.update');
    });
    Route::group(['prefix'=>'orders'],function (){
        Route::get('/','Admin\OrdersController@index')->name('orders.list');
        Route::get('detail/{id}','Admin\OrdersController@detail')->name('orders.detail');
    });

});

Route::group(['middleware'=>['auth', 'acl'], 'prefix'=>'partner', 'is'=>'partner'], function(){
    Route::get('dashboard', 'Partner\DashboardController@index')->name('partner.dashboard');
});
