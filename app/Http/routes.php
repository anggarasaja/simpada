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

Route::get('getpass',function(){
	$p = Hash::make('bepeka');
	echo "Pass: ".$p;
	// copy hasilnya ke field opr_passwd di tabel operator.
});

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
Route::get('penetapan/cetak-daftar','Penetapan@cetak_daftarSPT');

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

Route::get('daftar/tutup_wpwr','Pendaftaran@tutup');
Route::post('daftar/proses_tutup_wpwr','Pendaftaran@proses_tutup');
Route::get('daftar/buka_wpwr','Pendaftaran@buka');
Route::post('daftar/proses_buka_wpwr','Pendaftaran@proses_buka');

##### PENDATAAN ######

//form pendataan baru dan edit
Route::get('pendataan/rekam_data','Pendataan@rekam_data');
Route::get('pendataan/sptpd/{id_pajak}/{status?}','Pendataan@sptpd')->name('sptpd');
Route::get('pendataan/sptpd/edit/{id_spt}/{id_pajak}/{status?}','Pendataan@editsptpd')->name('editSptpd');
//end form pendataan baru dan edit

//get history
Route::get('pendataan/gethistory/hotel/{id}','Pendataan@gethistory_hotel');
Route::get('pendataan/gethistory/resto/{id}','Pendataan@gethistory_resto');
Route::get('pendataan/gethistory/hibur/{id}','Pendataan@gethistory_hibur');
Route::get('pendataan/gethistory/rek/{id}','Pendataan@gethistory_rek');
Route::get('pendataan/gethistory/jalan/{id}','Pendataan@gethistory_jalan');
Route::get('pendataan/gethistory/parkir/{id}','Pendataan@gethistory_parkir');
Route::get('pendataan/gethistory/airtanah/{id}','Pendataan@gethistory_airtanah');
Route::get('pendataan/gethistory/sarang/{id}','Pendataan@gethistory_sarang');
Route::get('pendataan/gethistory/retribusi/{id}','Pendataan@gethistory_retribusi');
//end get history

//get cangkunek di pendataan
Route::get('pendataan/getnoreg','Pendataan@getnoreg');
Route::get('pendataan/getnpwpd','Pendataan@getnpwpd');
Route::get('pendataan/getnpwpd/{npwp}','Pendataan@getnpwpd');
// Route::get('pendataan/getnpwpd_tutup','Pendataan@getnpwpd_tutup');
Route::get('pendataan/getnpwpd_tutup/{npwp?}','Pendataan@getnpwpd_tutup');
Route::get('pendataan/getRekening','Pendataan@getRekening');
Route::get('pendataan/hitungReklame','Pendataan@hitungReklame');
Route::get('pendataan/gantiRek','Pendataan@gantiRek');
Route::get('pendataan/getrek','Pendataan@getrek');
Route::get('pendataan/hitungAirTanah','Pendataan@hitungAirTanah');
Route::get('pendataan/getlurah','Pendataan@getlurah');
//end get cangkunek di pendataan

//simpan dan edit pendataaan spt
Route::post('pendataan/store_data_hotel','Pendataan@store_data_hotel');
Route::post('pendataan/edit_data_hotel/{id_spt}','Pendataan@edit_data_hotel');

Route::post('pendataan/store_data_resto','Pendataan@store_data_resto');
Route::post('pendataan/edit_data_resto/{id_spt}','Pendataan@edit_data_resto');

Route::post('pendataan/store_data_hibur','Pendataan@store_data_hibur');
Route::post('pendataan/edit_data_hibur/{id_spt}','Pendataan@edit_data_hibur');

Route::post('pendataan/store_data_reklame','Pendataan@store_data_reklame');
Route::post('pendataan/edit_data_reklame/{id_spt}','Pendataan@edit_data_reklame');

Route::post('pendataan/store_data_jalan','Pendataan@store_data_jalan');
Route::post('pendataan/edit_data_jalan/{id_spt}','Pendataan@edit_data_jalan');

Route::post('pendataan/store_data_parkir','Pendataan@store_data_parkir');
Route::post('pendataan/edit_data_parkir/{id_spt}','Pendataan@edit_data_parkir');

Route::post('pendataan/store_data_airtanah','Pendataan@store_data_airtanah');
Route::post('pendataan/edit_data_airtanah/{id_spt}','Pendataan@edit_data_airtanah');

Route::post('pendataan/store_data_sarang','Pendataan@store_data_sarang');
Route::post('pendataan/edit_data_sarang/{id_spt}','Pendataan@edit_data_sarang');

Route::post('pendataan/store_data_retribusi','Pendataan@store_data_retribusi');
Route::post('pendataan/edit_data_retribusi/{id_spt}','Pendataan@edit_data_retribusi');
//end simpan edit pendataaan spt

//get dan lihat data tabel pendataaan spt
Route::get('pendataan/lihat_data_hotel/{status?}','Pendataan@lihat_data_hotel')->name('lihat_data_hotel');
Route::get('pendataan/get_data_hotel','Pendataan@get_data_hotel');

Route::get('pendataan/lihat_data_resto/{status?}','Pendataan@lihat_data_resto')->name('lihat_data_resto');
Route::get('pendataan/get_data_resto','Pendataan@get_data_resto');

Route::get('pendataan/lihat_data_hibur/{status?}','Pendataan@lihat_data_hibur')->name('lihat_data_hibur');
Route::get('pendataan/get_data_hibur','Pendataan@get_data_hibur');

Route::get('pendataan/lihat_data_reklame/{status?}','Pendataan@lihat_data_reklame')->name('lihat_data_reklame');
Route::get('pendataan/get_data_reklame','Pendataan@get_data_reklame');

Route::get('pendataan/lihat_data_jalan/{status?}','Pendataan@lihat_data_jalan')->name('lihat_data_jalan');
Route::get('pendataan/get_data_jalan','Pendataan@get_data_jalan');

Route::get('pendataan/lihat_data_parkir/{status?}','Pendataan@lihat_data_parkir')->name('lihat_data_parkir');
Route::get('pendataan/get_data_parkir','Pendataan@get_data_parkir');

Route::get('pendataan/lihat_data_airtanah/{status?}','Pendataan@lihat_data_airtanah')->name('lihat_data_airtanah');
Route::get('pendataan/get_data_airtanah','Pendataan@get_data_airtanah');

Route::get('pendataan/lihat_data_sarang/{status?}','Pendataan@lihat_data_sarang')->name('lihat_data_sarang');
Route::get('pendataan/get_data_sarang','Pendataan@get_data_sarang');

Route::get('pendataan/lihat_data_retribusi/{status?}','Pendataan@lihat_data_retribusi')->name('lihat_data_retribusi');
Route::get('pendataan/get_data_retribusi','Pendataan@get_data_retribusi');
//end get dan lihat data tabel pendataaan spt

//delete spt
Route::delete('pendataan/sptpd/delete/{id_spt}','Pendataan@delete_spt');
//end delete spt

##### END PENDATAAN ######
##########################


###########
### LHP ###
Route::get('lhp','lhpController@index');
Route::get('lhp/self/table','lhpController@table_lhp_self');
Route::get('lhp/self/getself','lhpController@getself');
Route::get('lhp/self/create','lhpController@create_self');
### END LHP ###
###############

###############
## PENETAPAN ##
Route::get('ketetapan','Penetapan@ketetapan');
Route::get('ketetapan/skpd','Penetapan@skpd');
Route::get('ketetapan/skrd','Penetapan@skrd');
Route::get('ketetapan/skpdkb','Penetapan@skpdkb');
Route::get('ketetapan/skrdkb','Penetapan@skrdkb');
Route::get('ketetapan/skpdlb','Penetapan@skpdlb');
Route::get('ketetapan/skpdt','Penetapan@skpdt');
Route::get('ketetapan/skrdt','Penetapan@skrdt');

Route::get('ketetapan/getkohir','Penetapan@getkohir');
Route::post('skpd/cetak','Penetapan@cetak_skpd');
Route::post('skrd/cetak','Penetapan@cetak_skrd');
Route::post('skpdkb/cetak','Penetapan@cetak_skpdkb');
Route::post('skprkb/cetak','Penetapan@cetak_skprkb');
Route::post('skpdlb/cetak','Penetapan@cetak_skpdlb');
Route::post('skpdt/cetak','Penetapan@cetak_skpdt');
Route::post('skrdt/cetak','Penetapan@cetak_skrdt');


Route::post('spt/cetak','Penetapan@cetak_daftar_spt_pdf');
## END PENETAPAN ##
###################

########################
####### BKP ############
Route::get('penyetoran','bkpController@penyetoran');

//table self assessment
Route::get('datatables/self','bkpController@setoranSelfDt');
Route::get('bkp/daftar-self','bkpController@daftarSetoranSelf');
//table official assessment
Route::get('datatables/official','bkpController@setoranOfficialDt');
Route::get('bkp/daftar-official','bkpController@daftarSetoranOfficial');
//table lhp
Route::get('datatables/getlhp','bkpController@getlhp');
Route::get('bkp/daftar-lhp','bkpController@daftar_lhp');

//ga pake
// Route::get('bkp/table_setorpajret_official/{status?}','bkpController@table_setorpajret_official');
// Route::get('bkp/getdata_setorpajret','bkpController@getdata_setorpajret');

//menu 1
Route::get('bkp/menu1','bkpController@menu1');
Route::get('bkp/editmenu1/{id}','bkpController@editmenu1');
Route::post('bkp/store_menu1','bkpController@store_menu1');
Route::post('bkp/update_menu1','bkpController@update_menu1');


//menu2
Route::get('bkp/menu2','bkpController@menu2');
Route::get('bkp/editmenu2/{id}','bkpController@editmenu2');
Route::post('bkp/store_menu2','bkpController@store_menu2');
Route::post('bkp/update_menu2','bkpController@update_menu2');

//menu3
Route::get('bkp/menu3','bkpController@menu3');

//menu4
Route::get('bkp/menu4','bkpController@menu4');

// menu 5, 6, & 7
Route::get('bkp/menu5','bkpController@menu5');
Route::get('bkp/menu6','bkpController@menu6');
Route::get('bkp/menu7','bkpController@menu7');
Route::get('bkp/cetak_data_pajak/{id_pajak}','bkpController@cetak_data_pajak');

//delete setorpajret
Route::delete('bkp/setorpajret/delete/{id}','bkpController@delete_setorpajret');

Route::get('getkohir','bkpController@getkohir');
Route::get('getkohir2','bkpController@getkohir2');
Route::get('getkohir3','bkpController@getkohir3');
Route::get('bkp/getpajak','bkpController@getpajak');
Route::get('bkp/getnpwpd/{npwp?}','bkpController@getnpwpd');

// report
Route::post('bkp/cetak_sspd/official','reportBkpController@cetak_sspd_official');
Route::post('bkp/cetak_sspd/self','reportBkpController@cetak_sspd_self');

Route::get('bkp/bpps','reportBkpController@bpps');
Route::post('bkp/cetak_bpps_rek','reportBkpController@cetak_bpps_rek');

####### End BKP ########
########################

###############
### REPORT ####
Route::get('generate_pdf','reportDaftarController@generate_pdf');

Route::get('pendataan/cetak_daftar_list','Pendataan@cetak_daftar_list');
Route::get('pendataan/cetak_daftar','Pendataan@cetak_daftar');
Route::get('pendataan/cetak_daftar_reklame','Pendataan@cetak_daftar_reklame');

Route::post('report/cetak_daftar_pendataan','reportDaftarController@cetak_daftar_pendataan');
Route::post('report/cetak_daftar_reklame','reportDaftarController@cetak_daftar_reklame');

Route::get('pendataan/cetak_induk_wpwr','Pendataan@cetak_induk_wpwr');
Route::get('pendataan/cetak_kembang_wpwr','Pendataan@cetak_kembang_wpwr');
Route::get('pendataan/cetak_list_kembang_wpwr','Pendataan@cetak_list_kembang_wpwr');

Route::post('report/cetak_induk_wpwr','reportDaftarController@cetak_induk_wpwr');
Route::post('report/cetak_kembang_wpwr','reportDaftarController@cetak_kembang_wpwr');
Route::post('report/cetak_list_kembang_wpwr','reportDaftarController@cetak_list_kembang_wpwr');
### END REPORT ####
###################

### User ###
Route::resource('user','userController');
Route::get('getdatauser','userController@getdatauser');
### END User ###
