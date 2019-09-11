<?php

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

Route::get('/blog', function () {
    return view('blog');
});
Route::get('/', function () {
    return view('welcome1');
});
Route::get('{path}', 'HomeController@index')->where( 'path', '(?:[A-z\\d\\/_.]+)?' );