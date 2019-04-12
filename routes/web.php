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
    return view('loginPages.login');
});
Route::post('/auth', 'LoginController@index')->name('login2');
Route::post('/tryAgain', 'LoginController@restart');
Route::post('/newAcc', 'LoginController@getCredentials')->name('newCredentials');
Route::get('/edit', 'EditController@index');
Route::get('/submit', 'EditController@saveInfo');
Route::get('/editDetail/{id}', [
    'uses' => 'EditController@getDetails',
    'as' => 'editDetail'
]);
Route::get('/confirm', function() {
    return view('confirmPages.confirm');
});
Route::get('/search', 'EditController@findBook');