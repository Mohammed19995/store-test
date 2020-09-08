<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// admin
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // auth
    Route::get('login', 'AuthController@show_login')->name('admin.auth.login');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');


    Route::group(['middleware' => 'auth:admin'] ,function (){
        Route::get('/', 'HomeController@index')->name('admin.index');

        // profile
        Route::get('profile' , 'ProfileController@index')->name('admin.profile');
        Route::post('profile' , 'ProfileController@update');
        Route::post('change-password' , 'ProfileController@change_password');

        // admins
        Route::resource('admins' , 'AdminController')->names(['index' => 'admin.admins.index']);
        Route::get('get-remote-admins' , 'AdminController@get_remote_admins');
        Route::post('admins/execute-option' , 'AdminController@executeOptions');


        // users
        Route::resource('users' , 'UserController')->names(['index' => 'admin.users.index']);
        Route::get('get-users-ajax' , 'UserController@get_users_ajax');
        Route::post('users/execute-option' , 'UserController@executeOptions');

        // galleries
        Route::resource('galleries' , 'GalleryController')->names(['index' => 'admin.galleries.index']);
        Route::get('get-remote-galleries' , 'GalleryController@get_remote_gallery');

        // countries
        Route::resource('countries' , 'CountryController')->names(['index' => 'admin.countries.index']);
        Route::get('get-remote-countries' , 'CountryController@get_remote_country');
        Route::post('countries/execute-option' , 'CountryController@executeOptions');


        // gallery types
        Route::get('get-remote-gallery-types' , 'GalleryTypeController@get_remote_gallery_types');

        // countries
        Route::resource('categories' , 'CategoryController')->names(['index' => 'admin.categories.index']);
        Route::get('get-remote-categories' , 'CategoryController@get_remote_category');
        Route::post('categories/execute-option' , 'CategoryController@executeOptions');


        // live
        Route::get('make-live' , 'LiveController@live')->name('admin.live.index');
        Route::get('watch' ,'LiveController@watch')->name('admin.live.watch');
    });
});
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


// test


Route::get('test','Test\PDFController@test');
Route::get('test-session',function (){
    return "AAAAA";
});
