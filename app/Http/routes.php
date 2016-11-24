<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\User;
use App\bank;

Route::get('/', 'HomeController@index');
	
Route::get('pendaftaran-wpwr-pribadi', 'pendaftaranPribadiController@index'	);
Route::get('tes', 'tes@index');

//demo
Route::get('demo-datatables', 'DatatablesController@index');
Route::get('demo-datatables/api', 'DatatablesController@anyData');
Route::get('demo-opentbs', 'opentbsController@index');
Route::post('demo-opentbs/download', 'opentbsController@getFile');

Route::auth();

//tes
Route::get('/home', function () {
    // return view('welcome');
    $a = App\bank::all();
    dd($a);die;
    return View::make('home');
});

Route::get('daftar-pribadi/create','Pendaftaran@wpwrpribadi');
Route::post('daftar-pribadi/store','Pendaftaran@store_wpwrpribadi');


