<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/createNewUser' , 'App\Http\Controllers\AdminController@createNewUser');
Route::get('/getUsers' , 'App\Http\Controllers\AdminController@getUsers');
Route::post('/deleteUser/{id}' , 'App\Http\Controllers\AdminController@deleteUser');
Route::patch('/updateUser/{id}' , 'App\Http\Controllers\AdminController@updateUser');

Route::post('/createUser', 'App\Http\Controllers\UserController@store');

Route::post('/booking' , 'App\Http\Controllers\LibrarianController@booking');
Route::get('/getBookingBook' , 'App\Http\Controllers\LibrarianController@getBookingBook');
Route::post('/deleteBooking' , 'App\Http\Controllers\LibrarianController@deleteBooking');
Route::get('/getBooking/{id}', 'App\Http\Controllers\LibrarianController@getBooking');

Route::get('/bookUserId/{id}' , 'App\Http\Controllers\BookController@bookUserId');
Route::get('/getBookUser/{id}' , 'App\Http\Controllers\BookController@getBookUser');
Route::get('/categories', 'App\Http\Controllers\BookController@getCategories');
Route::get('/category/{genre}', 'App\Http\Controllers\BookController@show');
Route::get('/getAuthors', 'App\Http\Controllers\BookController@getAuthors');
Route::get('/getAuthor/{author}', 'App\Http\Controllers\BookController@getAuthor');

Route::group(['prefix' => 'book'], function () {
    Route::get('/getBooks', 'App\Http\Controllers\BookController@getBooks');
    Route::post('/createBook', 'App\Http\Controllers\LibrarianController@store');
    Route::post('/deleteBook/{id}', 'App\Http\Controllers\LibrarianController@deleteBook');
    Route::get('/issueBook/{id}', 'App\Http\Controllers\LibrarianController@issueBook');
    Route::patch('/changeStatus/{id}', 'App\Http\Controllers\LibrarianController@changeStatus');
    Route::post('/getUserBook/{title}', 'App\Http\Controllers\LibrarianController@getUserBook');
});

Route::group(['middleware' => 'auth:sanctum'], function (){
    Route::patch('/booking/{id}', 'App\Http\Controllers\BookController@booking');
});



