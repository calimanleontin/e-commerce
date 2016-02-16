<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/



Route::group(['middleware' => ['web']], function () {
    Route::get('/home',['as' => 'home', 'uses' => 'ProductController@index']);
    Route::GEt('/','ProductController@index');

    Route::get('auth/login', 'UserController@getLogin');
    Route::post('auth/login', 'UserController@postLogin');
    Route::get('auth/logout', 'UserController@getLogout');

// Registration routes...
    Route::get('auth/register', 'UserController@getRegister');
    Route::post('auth/register', 'UserController@postRegister');
    Route::get('/search','ProductController@search');
    Route::get('/email',function(){
        Mail::send('home',['name'=> 'leontin'],function($message){

            $message->to('calimanleontin@gmail.com', 'leontin')->from('calimanleontin@gmail.com')->subject('welcome');
        });
    });




    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('category/create','CategoryController@create');
        Route::post('category/store','CategoryController@store');
        Route::get('/product/create','ProductController@create');
        Route::post('/product/store','ProductController@store');
        Route::get('/cart/index','CartController@index');
        Route::get('/cart/increase/{id}','CartController@increase');
        Route::get('/cart/decrease/{id}','CartController@decrease');
        Route::get('/cart/delete/{id}','CartController@delete');
        Route::post('/comment/store','CommentController@store');
        Route::post('/finish-order','CartController@finish');
        Route::get('comment/delete/{id}','CommentController@delete');
        Route::get('comment/edit/{id}','CommentController@edit');
        Route::post('comment/update','CommentController@update');
        Route::get('finish-cart','CartController@finish');
        Route::get('/order-history','CartController@history');
        Route::get('/edit-profile','UserController@edit_profile');
        Route::get('/user-profile','UserController@profile');
        Route::post('/profile/update','UserController@update_profile');
        Route::get('/edit/product/{id}','ProductController@edit');
        Route::post('/update/product','ProductController@update');

        Route::get('order-details/{id}','CartController@order_details');


    });
    Route::get('/to-cart/{id}','CartController@add')->where('id', '[0-9]+');

    Route::Get('/product/{slug}','ProductController@show');
    Route::get('/category/{slug}','CategoryController@show');


});
