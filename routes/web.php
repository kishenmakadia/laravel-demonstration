<?php

use Illuminate\Support\Facades\Auth;
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
})->name('landing');

/* not using authentication routes as I dont need registration and password reset features */
// Auth::routes();

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', 'UserController')->except(['show']);
        Route::resource('categories', 'CategoryController')->except(['show']);
        Route::resource('products', 'ProductController')->except(['show']);
    });
});
