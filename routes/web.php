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

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::post('/add-post', 'PostController@store');
Route::get('/search-posts', 'PostController@search');
Route::get('/show-post/{id}', 'PostController@show');
Route::get('/home', 'PostController@index');
Route::get('/update/{id}', 'PostController@update');
Route::put('/put-post/{id}', 'PostController@put');
Route::get('/get-post-votes', 'PostController@getVotes');
Route::get('/get-comments/{id}', 'CommentController@index');

Route::post('/add-comment/{postId}', 'CommentController@store');
