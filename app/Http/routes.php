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
    Route::get('/category/{slug}','CategoryController@show');

// Registration routes...
    Route::get('auth/register', 'UserController@getRegister');
    Route::post('auth/register', 'UserController@postRegister');


    Route::group(['middleware' => ['auth']], function()
    {
        Route::get('category/create','CategoryController@create');
        Route::post('category/store','CategoryController@store');
        Route::get('/product/create','ProductController@create');
        Route::post('/product/store','ProductController@store');
        Route::get('/to-cart/{id}','CartController@add')->where('id', '[0-9]+');
        Route::get('/cart/index','CartController@index');

    });
});
