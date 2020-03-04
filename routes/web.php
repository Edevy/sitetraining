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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/contact_me', 'FormController@save')->name('save');
Route::get('/jquery/form/show', 'FormController@showForm')->name('fluid_show');
Route::post('/jquery/form/submit', 'FormController@saveJquery')->name('fluid_save');
