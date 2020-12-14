<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'welcomeController@index');

Auth::routes();

Route::get('/verify', function () {
    return view('auth.verify');
})->name('verify');

Route::post('/register', 'AuthController@create')->name('register');
Route::post('/verify', 'AuthController@verify')->name('verify');

Route::group([
    'prefix' => 'admin',
    'middleware' => ['role:admin'],
], function () {

    Route::get('/', 'adminController@index')->name('admin');

    Route::resource('/users', 'UsersController');
    Route::resource('/images', 'imagesController');
    Route::resource('/categories', 'categoriesController');
    Route::resource('/locations', 'locationsController');

    Route::post('admin/ajaxRequest', 'usersController@resetPassword')->name('resetPass');

});

Route::group([
    'middleware' => ['role:user|admin'],
], function () {

    Route::get('/home', function () {
        return view('home');
    })->name('home');

});
