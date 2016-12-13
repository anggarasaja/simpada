<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;

class Universal extends Controller
{
    //
    public function nextVal($seq){
    	$query = "SELECT nextval('".$seq."')";
    	$rs = DB::select( DB::raw($query));
    	return $rs[0]->nextval;
    }

    function format_tgl ($tgl, $with_time=false, $char_bulan=false, $period=false) {

	// $arr_bulan = array("JANUARI","FEBRUARI","MARET","APRIL","MEI","JUNI","JULI","AGUSTUS","SEPTEMBER","OKTOBER","NOVEMBER","DESEMBER");

	$arr_bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");

	$arr_bulan_num = array("01","02","03","04","05","06","07","08","09","10","11","12");

		if ($with_time) {
			list($tgl,$time) = explode(" ",$tgl);
		}

		if (!empty($tgl)) {
			$arr_tgl = explode("/",$tgl);
				if (!$char_bulan)
				$tgl = $arr_tgl[2]."-".$arr_tgl[1]."-".$arr_tgl[0];
				else {
					foreach ($arr_bulan as $k => $v) {
						if ($arr_bulan_num[$k] == $arr_tgl[1])
						$arr_tgl[1] = $v;
					}
					if(!$period)
					$tgl = $arr_tgl[0]." ".$arr_tgl[1]." ".$arr_tgl[2];
					else
					$tgl = $arr_tgl[1]." ".$arr_tgl[2];
				}
		}

		if ($with_time) {
			$tgl = $tgl." ".$time;
		}

		return $tgl;
	}
}
