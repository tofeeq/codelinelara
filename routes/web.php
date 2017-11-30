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

//redirecting / to /films
Route::get('/', function () {
    return redirect('films');
});

//get films to show on home page
Route::get('/films', 'FilmController@home');

//create films
Route::get('films/create', 'Film@create')->name('films-create');
Route::post('films/create', 'Film@store')->name('films.store');

//define routes related to login/logout user
Auth::routes();
