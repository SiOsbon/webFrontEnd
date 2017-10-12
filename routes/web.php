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

Route::prefix('admin')->group(function () {
    Route::get('/', 'HomeController@indexAdmin')->name('admin');
    Route::get('/data-contracts/create', 'DataContractController@create')->name('data_contract_create');
    Route::get('/data-contracts/create2', 'DataContractController@create2')->name('data_contract_create2');
    Route::get('/data-contracts/find-create', 'DataContractController@findCreate')->name('data_contract_find_create');
    Route::post('/data-contracts/store-ajax', 'DataContractController@storeAjax')->name('data_contract_store_ajax');
    Route::post('/data-contracts/store', 'DataContractController@store')->name('data_contract_store');
    Route::post('/data-contracts/find-store-ajax', 'DataContractController@findStoreAjax')->name('data_contract_find_store_ajax');

    Route::post('/demo-data-contracts/store', 'DataContractController@demoStore')->name('data_contract_demo_store');

});

/*Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/', 'Auth\LoginController@login');*/
Route::get('/', 'HomeController@index')->name('home');

Route::get('/download', 'HomeController@download')->name('download');

//Route::get('/tasks', 'TaskController@index')->name('tasks');
Route::get('/data-contracts', 'DataContractController@index')->name('data_contracts');
Route::get('/data-contract/{dataContractId}', 'DataContractController@view')->name('data_contract_view');

Route::get('/data-contracts/start/{dataContractId}', 'DataContractController@start')->name('data_contract_start');
Route::get('/data-contracts/stop/{dataContractId}', 'DataContractController@stop')->name('data_contract_stop');
Route::get('/data-contracts/results/{dataContractId}/{page?}', 'DataContractController@results')->name('data_contract_results');

Route::get('/nodes', 'NodeController@index')->name('nodes');
Route::get('/node/{nodeId}', 'NodeController@view')->name('node');
Route::post('/node/{nodeId}', 'NodeController@view');

Route::get('/statistics', 'StatisticsController@index')->name('statistics');
Route::post('/statistics', 'StatisticsController@index');

Route::post('/scrape', 'ScraperController@index')->name('scrape');