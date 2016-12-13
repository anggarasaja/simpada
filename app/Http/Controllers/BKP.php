<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;	
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class BKP extends Controller
{
    //
    public function daftarSetoranSelf(){
    	return view('daftarSelf');
    }

    public function daftarSetoranOfficial(){
    	return view('daftarOfficial');
    }

    public function setoranSelfDt(){
    	$records = DB::table('v_setoran_khusus_self')
    				->select(DB::raw('DISTINCT setorpajret_no_bukti,sprsd_thn,setorpajret_id,spt_nomor,setorpajret_tgl_bayar,koderek,korek_rincian,korek_sub1,korek_nama,npwprd_format,wp_wr_nama,ref_viabaypajret_ket, sprsd_periode_jual1,setorpajret_jlh_bayar'))
    				->orderBy('setorpajret_no_bukti','desc');
    	return Datatables::of($records)
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>
                                <a type='button' class='btn btn-primary' href='/rml/edit/'>Edit</a>
                                </div>";
            return $button;
        })   
        ->editColumn('sprsd_periode_jual1',function($row){
        	return date('M',strtotime($row->sprsd_periode_jual1))."-".$row->sprsd_thn;
        })
        ->make(true);
    }

    public function setoranOfficialDt(){
    	$records = DB::table('v_pembantu_harian');
    				// ->orderBy('periode_tap','DESC')
    				// ->orderBy('setorpajret_tgl_bayar','DESC')
    				// ->orderBy('netapajrek_kohir','DESC');
    	return Datatables::of($records)
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>
                                <a type='button' class='btn btn-primary' href='/rml/edit/'>Edit</a>
                                </div>";
            return $button;
        })   
        ->make(true);
    }
}
