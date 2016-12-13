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

// Route::get('getpass',function(){
// 	$p = Hash::make('admin');
// 	echo "Pass: ".$p;
// 	// copy hasilnya ke field opr_passwd di tabel operator.
// });

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

Route::get('daftar-pribadi/','Pendaftaran@show_wpwrpribadi');
Route::get('daftar-pribadi/create','Pendaftaran@wpwrpribadi');
Route::post('daftar-pribadi/store','Pendaftaran@store_wpwrpribadi');

Route::get('daftar-badan','Pendaftaran@show_wpwrbadan');
Route::get('daftar-badan/create','Pendaftaran@wpwrbadan');
Route::post('daftar-badan/store','Pendaftaran@store_wpwrbadan');

Route::get('cetak_kartu','Pendaftaran@cetak_kartu');

Route::get('sptpd_hotel','Pendataan@sptpd_hotel');
Route::get('sptpd_restoran','Pendataan@sptpd_restoran');

Route::get('penyetoran','bkpController@penyetoran');
Route::get('penyetoran/menu1','bkpController@menu1');
Route::post('penyetoran/store_menu1','bkpController@store_menu1');
Route::get('penyetoran/menu2','bkpController@menu2');
Route::get('penyetoran/menu3','bkpController@menu3');
Route::get('penyetoran/menu4','bkpController@menu4');
Route::get('penyetoran/menu5','bkpController@menu5');
Route::get('penyetoran/menu6','bkpController@menu6');
Route::get('penyetoran/menu7','bkpController@menu7');

Route::get('getkohir','bkpController@getkohir');


