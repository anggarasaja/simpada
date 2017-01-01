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
//badan usaha
Route::get('daftar-bu/create/{status?}','Pendaftaran@wpwrbadan')->name('createBU');
Route::get('daftar-bu/edit/{edit}/{status?}','Pendaftaran@editBU')->name('editBU');
//pribadi
Route::get('daftar-pribadi/create/{status?}','Pendaftaran@wpwrpribadi')->name('createPribadi');
Route::get('daftar-pribadi/edit/{edit}/{status?}','Pendaftaran@editPribadi')->name('editPribadi');

Route::get('daftar-pribadi/table','Pendaftaran@tableWpPribadi');
Route::get('daftar-bu/table','Pendaftaran@tableWpBu');

Route::get('penetapan/table','Penetapan@daftarSPT');

Route::post('daftar-pribadi/store','Pendaftaran@savePribadi');
Route::post('daftar-bu/store','Pendaftaran@saveBU');

Route::get('datatables/wp-pribadi','Pendaftaran@wpPribadiDt');
Route::get('datatables/wp-bu','Pendaftaran@wpBuDt');
Route::get('datatables/cetak-npwpd','Pendaftaran@cetakNpwpdDt');

Route::get('datatables/spt','Penetapan@sptDt');

// Route::get('daftar-pribadi/','Pendaftaran@show_wpwrpribadi');
// Route::get('daftar-pribadi/create','Pendaftaran@wpwrpribadi');
// Route::post('daftar-pribadi/store','Pendaftaran@store_wpwrpribadi');

Route::get('daftar-badan','Pendaftaran@show_wpwrbadan');
Route::get('daftar-badan/create','Pendaftaran@wpwrbadan');
Route::post('daftar-badan/store','Pendaftaran@store_wpwrbadan');

Route::get('cetak_kartu','Pendaftaran@cetak_kartu');
Route::get('cetak-npwpd-pdf/{wpwrid}','Pendaftaran@cetakNpwpd');

// Route::get('cetak_npwpd','Pendaftaran@cetak_npwpd');

//Pendataan
Route::get('pendataan/rekam_data','Pendataan@rekam_data');
Route::get('pendataan/{id_pajak}/sptpd','Pendataan@sptpd');
Route::get('pendataan/getnoreg','Pendataan@getnoreg');
Route::get('pendataan/getnpwpd','Pendataan@getnpwpd');
Route::get('pendataan/getnpwpd/{npwp}','Pendataan@getnpwpd');
Route::get('pendataan/gethistory/{id}','Pendataan@gethistory');
Route::get('pendataan/getRekening','Pendataan@getRekening');

Route::post('pendataan/store_data_reklame','Pendataan@store_data_reklame');

//BKP
Route::get('datatables/self','bkpController@setoranSelfDt');
Route::get('bkp/daftar-self','bkpController@daftarSetoranSelf');
Route::get('datatables/official','bkpController@setoranOfficialDt');
Route::get('bkp/daftar-official','bkpController@daftarSetoranOfficial');

Route::get('penyetoran','bkpController@penyetoran');
Route::get('penyetoran/menu1','bkpController@menu1');
Route::get('penyetoran/editmenu1/{id}','bkpController@editmenu1');
Route::post('penyetoran/store_menu1','bkpController@store_menu1');
Route::post('penyetoran/update_menu1','bkpController@update_menu1');

Route::get('penyetoran/menu2','bkpController@menu2');
Route::get('penyetoran/menu3','bkpController@menu3');
Route::get('penyetoran/menu4','bkpController@menu4');
Route::get('penyetoran/menu5','bkpController@menu5');
Route::get('penyetoran/menu6','bkpController@menu6');
Route::get('penyetoran/menu7','bkpController@menu7');

Route::get('getkohir','bkpController@getkohir');


