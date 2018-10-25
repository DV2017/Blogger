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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/welcome' , function(){
//     return view('welcome');
// });
// Route::get('/hello', function () {
//     return "<h1>Hello world.<h1>";
// });

// Route::get('/page/{id}/{name}', function ($id, $name) {
//     return 'This is page '.$id. ' with title '. $name;
// });
//BEST PRACTICE: get routes to send files to a controller which sets the views

Route::get('/', 'PagesController@index');
Route::get('/about', 'PagesController@about');
Route::get('/services', 'PagesController@services');
Route::resource('posts', 'PostsController'); //sets route to all functions in PostsController
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
