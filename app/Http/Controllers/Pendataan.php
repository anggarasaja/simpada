<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ref_jenis_pajak_retribusi;
use App\wp_wr;
use App\v_wp_wr;
use DB;
use Datatables;

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
    	}
        elseif ($id_pajak == 2) {
            return view('sptpd_restoran');
        }
        elseif ($id_pajak == 4) {
    		return view('sptpd_reklame');
    	}
    }

    public function store_data_reklame(Request $request){
        $this->validate($request, [

        ]);

    }

    public function getnoreg(){
    	$__thnproses = date("Y");
        $sql_find = DB::select("SELECT COALESCE(max(spt_nomor)+1,1) as max_no_spt FROM spt WHERE spt_periode=? ",[$__thnproses]);
        $spt_no = $sql_find[0]->max_no_spt;

        $sql_find = DB::select("SELECT COALESCE(max(netapajrek_kohir)+1,1) as max_no_spt FROM penetapan_pajak_retribusi
                     LEFT JOIN SPT ON SPT.spt_id=netapajrek_id_spt
                     WHERE EXTRACT(YEAR FROM netapajrek_tgl)=? and
                       spt.spt_periode=? ",[$__thnproses,$__thnproses]);
        $spt_kohir = $sql_find[0]->max_no_spt;
        $last_kohir=0;
        if($spt_no>$spt_kohir) $last_kohir=$spt_no;else
        if($spt_kohir>$spt_no) $last_kohir=$spt_kohir;else $last_kohir=$spt_no;

        return $last_kohir;
    }

    public function getnpwpd(){
        $get = v_wp_wr::where('wp_wr_status_aktif','true')->orderBy('no_reg','DESC')->get();

        return Datatables::of($get)

        ->make(true);
    }
}
