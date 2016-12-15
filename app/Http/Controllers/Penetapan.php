<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Setting;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class Penetapan extends Controller
{
    //
	public function daftarSPT(){
		return view('daftarSPT');
	}

	public function sptDt(){
		$tables = 'v_penetapan_pajak_retribusi AS a';

		$relations = " (a.netapajrek_jenis_ketetapan NOT IN (".Setting::get('status_stpd').",".Setting::get('status_strd').") OR  a.netapajrek_jenis_ketetapan  IS NULL) ";
		


		$records = DB::table($tables)
			->select(DB::raw('a.*, (SELECT b.koderek FROM v_kode_rekening_pajak b WHERE b.korek_id=a.lhp_kode_rek) AS lhp_koderek, (SELECT c.npwprd FROM v_wp_wr c WHERE c.wp_wr_id=a.lhp_idwpwr) AS lhp_kodewp'))
			->whereRaw($relations);
			// ->orderBy('a.netapajrek_id','desc');
			// ->get();

    	return Datatables::of($records)
        // ->addColumn('action', function ($row) {
        //     $button = "<div class='btn-group-vertical'>
        //                         <a type='button' class='btn btn-primary' href='/rml/edit/".$row->wp_wr_id."'>Edit</a>
        //                         </div>";
        //     return $button;
        // })   
        // ->editColumn('aktif', function($row){
        //     if($row->aktif=="on"){
        //         return '<span class="label label-success">aktif</span>';
        //     } else if($row->aktif==null){
        //         return '<span class="label label-danger">non-aktif</span>';
        //     } else {
        //         return '<span class="label label-default">unknown</span>';
        //     }
        // })
        // ->editColumn('last_update', function($row){
        //     if(isset($row->last_update)){
        //         return $row->last_update;
        //     } else{
        //         return '<span class="label label-danger">Belum diperbaharui</span>';
        //     }
        // })->editColumn('link', function($row){
            
        //         return '<a class="btn btn-info btn-xs" href="'.$row->link.'" target="_blank" data-toggle="tooltip" data-placement="top" title="'.$row->link.'">Link API</a>';
            
        // })->editColumn('deskripsi', function($row){
            
        //         return '<button type="button" class="btn btn-info btn-xs" data-container="body" data-trigger="focus" data-toggle="popover" data-placement="top" data-content="'.$row->deskripsi.'">
        //                   Lihat
        //                 </button>';
            
        // })
        ->orderColumn('netapajrek_kohir', '-netapajrek_id $1')
        ->make(true);
	}
}
