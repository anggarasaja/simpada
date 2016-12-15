<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ref_jenis_pajak_retribusi;
use DB;

class Pendataan extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function rekam_data(){
    	$getpajak = ref_jenis_pajak_retribusi::where('ref_jenparet_id','!=','10')->orderBy('ref_jenparet_id','asc')->get();
    	return view('rekam_data')->with('getpajak',$getpajak);
    }

    public function sptpd($id_pajak){
    	if ($id_pajak == 1) {
    		return view('sptpd_hotel');
    	}elseif ($id_pajak == 2) {
    		return view('sptpd_restoran');
    	}
    }

    public function getnoreg(){
    	$year = date('Y',strtotime($_GET['tgl']));
    	$getdata = DB::select('SELECT COALESCE(max(spt_nomor)+1,1) as max_no_spt FROM spt WHERE spt_periode='.$year);
    	return $getdata[0]->max_no_spt;
    }
}
