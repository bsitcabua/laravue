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


// Admin routes
Route::group(['prefix' => 'api'], function () {
    Route::get('/tags', 'TagController@index');
    Route::post('/store-tag', 'TagController@store');
    Route::post('/update-tag', 'TagController@update');
    Route::post('/destroy-tag', 'TagController@destroy');
});

// Route::post('app/edit_tag', 'AdminController@editTag');
// Route::post('app/delete_tag', 'AdminController@deleteTag');
// Route::post('app/upload', 'AdminController@upload');
// Route::post('app/delete_image', 'AdminController@deleteImage');
// Route::post('app/create_category', 'AdminController@addCategory');
// Route::get('app/get_category', 'AdminController@getCategory');
// Route::post('app/edit_category', 'AdminController@editCategory');

Route::get('/', function(){
    return view('index');
});

Route::any('{slug}', function(){
    return view('index');
});
