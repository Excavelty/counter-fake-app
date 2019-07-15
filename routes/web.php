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

Route::group(['middleware' => 'auth'], function() {

Route::post('/add-post', 'PostController@store');
Route::get('/update/{id}', 'PostController@update');
Route::put('/put-post/{id}', 'PostController@put');
Route::post('/add-comment/{postId}', 'CommentController@store');
Route::post('/upvote-post', 'UpvoteController@add');
Route::post('/downvote-post', 'DownvoteController@add');

});
Route::get('/search-posts', 'PostController@search');
Route::get('/show-post/{id}', 'PostController@show');
Route::get('/', function() {return redirect('/home');});
Route::get('/home', 'PostController@index');
Route::get('/get-post-votes', 'PostController@getVotes');
Route::get('/get-comments/{id}', 'CommentController@index');

Route::get('/media-rank', 'MediaController@show');
Route::get('/get-media-rank', 'MediaController@index');
