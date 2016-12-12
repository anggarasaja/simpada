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
	
// Route::get('pendaftaran-wpwr-pribadi', 'pendaftaranPribadiController@index'	);
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

Route::get('/pss', function () {
    // return view('welcome');
   	// echo Hash::make('bepeka');
   	// Setting::set('harrisanggara', 'bar');
   	// Setting::set('harrisanggarasdf', 'bar');
   	// Setting::save();
   	echo Setting::get('status_strd');
});

Route::post('getKelurahan','pendaftaranPribadiController@getKelurahan');
Route::get('getNomorUrut','pendaftaranPribadiController@getNomorUrut');
Route::get('daftar-pribadi/create/{status?}','Pendaftaran@wpwrpribadi')->name('createPribadi');
Route::get('daftar-pribadi/edit/{edit}/{status?}','Pendaftaran@editPribadi')->name('editPribadi');

Route::get('daftar-pribadi/table','Pendaftaran@tableWpPribadi');
Route::get('daftar-bu/table','Pendaftaran@tableWpBu');

Route::get('penetapan/table','Penetapan@daftarSPT');

Route::post('daftar-pribadi/store','Pendaftaran@savePribadi');

Route::get('datatables/wp-pribadi','Pendaftaran@wpPribadiDt');
Route::get('datatables/wp-bu','Pendaftaran@wpBuDt');

Route::get('datatables/spt','Penetapan@sptDt');

Route::get('datatables/self','BKP@setoranSelfDt');
Route::get('bkp/daftar-self','BKP@daftarSetoranSelf');
Route::get('datatables/official','BKP@setoranOfficialDt');
Route::get('bkp/daftar-official','BKP@daftarSetoranOfficial');



