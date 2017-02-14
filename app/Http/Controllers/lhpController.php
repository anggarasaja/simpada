<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class lhpController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function table_lhp_self(){
    	return view('table_lhp_self');
    }

    public function getself(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_jenis_pajakretribusi',1) // 1 = hotel
                    ->orderBy('spt_id','DESC')
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'v_wp_wr.wp_wr_nama',
                                    'v_wp_wr.wp_wr_almt',
                                    'v_wp_wr.npwprd',
                                    'kode_rekening.korek_nama',
                                    'spt.spt_pajak',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("M-Y", strtotime($spt_periode_jual1)) }}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->addColumn('aksi', function ($row) {
            $button = "<div class='btn-group-vertical'>";
            if ($row->setorpajret_tgl_bayar != "") {
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/1') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/1') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
                $button .=  Form::open(array('url' => 'pendataan/sptpd/delete/' .$row->spt_id . '', 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            }
            $button .= "</div>";
            return $button;
        })   
        ->make(true);
        // return Datatables::queryBuilder(DB::table('spt'))->make(true);
    }
}
