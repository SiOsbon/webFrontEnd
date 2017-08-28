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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    /*Route::get('/home', 'TaskController@index')->name('home');

    Route::post('/task/create', 'TaskController@create')->name('task_create');*/
});

/*Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');*/
Route::get('/', 'HomeController@index');

Route::get('/tasks', 'TaskController@index')->name('tasks');
Route::get('/task/{id}', 'TaskController@view')->name('task_view');
Route::get('/task-create', 'TaskController@create')->name('task_create');
Route::post('/task-store', 'TaskController@store')->name('task_store');
