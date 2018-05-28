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

Route::get('/home', 'ProjectController@index')->name('home');
Route::get('/settings', 'HomeController@settings')->name('settings');
Route::post('/settings/update/compiler', 'HomeController@updateCompiler')->name('settings.update.compiler');
Route::post('/settings/update/player', 'HomeController@updatePlayer')->name('settings.update.player');



Route::get('/projects/{id}/file/mwx', 'ProjectController@downloadOriginal')->name('download_mwx');
Route::get('/projects/{id}/file/data.js', 'ProjectController@downloadCompiled')->name('download_js');
Route::get('/projects/{id}/play', 'ProjectController@play')->name('play_project');

Route::resource('/projects', 'ProjectController');