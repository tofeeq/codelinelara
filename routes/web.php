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


//redirecting / to /films
Route::get('/', function () {
    return redirect('films');
});

//create films
Route::get('films/create', 'FilmController@create')->name('films-create');
Route::post('films/create', 'FilmController@storeform')->name('films.store');


//get films to show on home page
Route::get('/films', 'FilmController@home');
Route::get('films/{slug}', 'FilmController@single');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
