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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/comments/{id}', ['as' => 'comments', 'uses' => 'CommentController@showComments']);
Route::post('/store', 'CommentController@storeComment')->name('store');
Route::get('/get', 'CommentController@getComments');
Route::get('/typing', 'CommentController@typingComment');

