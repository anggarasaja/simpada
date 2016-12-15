<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ref_jenis_pajak_retribusi;
use App\v_penyetoran_sspd;
use App\penetapan_pajak_retribusi;
use Datatables;
use DB;

class bkpController extends Controller
{
    public function __contruct(){
    	$this->middleware('auth');
    }

    public function penyetoran(){
    	$array = array("Entry Setoran Ketetapan Pajak/Retribusi (OFFICIAL ASSESMENT)",
    				"Entry Setoran Khusus WP SELF ASESSMENT",
    				"Entry Setoran Ketetapan Pajak/Retribusi (LHP -- SKPDKB, SKPDT, SKRDT) ",
    				"Entry Setoran dari Dinas-Dinas/Lain-lain",
    				"Cari Nama / NPWPD Wajib Pajak",
    				"Cetak Buku Wajib Pajak",
    				"Pembatalan Setoran");
        $link = array('penyetoran/menu1',
                      'penyetoran/menu2',
                      'penyetoran/menu3',
                      'penyetoran/menu4',
                      'penyetoran/menu5',
                      'penyetoran/menu6',
                      'penyetoran/menu7',
                      );
        $data_pajak = ref_jenis_pajak_retribusi::whereNotIn('ref_jenparet_id',[9,10])->orderBy('ref_jenparet_id')->get();
    	return view('penyetoran')->with(compact('array','link','data_pajak'));
    }

    //rekam pajak retribusi
    public function menu1(){
        $getket = DB::select('select * from keterangan_spt');
        foreach ($getket as $key) {
            $ket[$key->ketspt_singkat] = '['.$key->ketspt_kode.'] '.$key->ketspt_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        $getbayar = DB::select('select * from ref_via_bayar_pajak_retribusi');
        foreach ($getbayar as $key) {
            $viabayar[$key->ref_viabaypajret_id] = $key->ref_viabaypajret_ket;
        }
        return view('menu1')->with(compact('ket','pejda','viabayar'));
    }

    public function store_menu1(Request $request){
        // dd($request);
        dd($request->input());
        $insert = new penetapan_pajak_retribusi;
        $insert->netapajrek_id_spt;

    }

    public function menu2(){
        return view('menu2');
    }

    public function menu3(){
        return view('menu3');
    }

    public function menu4(){
        return view('menu4');
    }

    public function menu5(){
        return view('menu5');
    }

    public function menu6(){
        return view('menu6');
    }

    public function menu7(){
        return view('menu7');
    }

    public function getkohir(){
        $tahun = $_GET['period_spt'];
        $objek_pajak = $_GET['objek_pajak'];
        $get = v_penyetoran_sspd::whereRaw("spt_jenis_pajakretribusi::text LIKE '".$objek_pajak."%'")
                                ->whereRaw("netapajrek_tgl::text LIKE '".$tahun."%'")
                                ->get();

        return Datatables::of($get)
        ->edit_column('netapajrek_kohir','<center><a id="kohirid[]" class="kohir" href="#" data-dismiss="modal">{{$netapajrek_kohir}}</a></center>')
        ->edit_column('netapajrek_besaran','@if($netapajrek_besaran == "") 0
                                            @else {{ $netapajrek_besaran }}
                                            @endif
                                            ')
        ->add_column('periode','<center>{{ date("Y",strtotime($netapajrek_tgl)) }}</center>')
        ->add_column('period_pajak','<center>{{ $spt_periode_jual1 }} s/d {{ $spt_periode_jual2 }}</center>')
        ->make(true);
    }

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
                                <a type='button' class='btn btn-warning btn-sm' href='{{ url('bkp/daftar-official/edit') }}'><i class='fa fa-pencil'></i> Edit</a>
                                <a type='button' class='btn btn-danger btn-sm' href='{{ url('bkp/daftar-official/edit') }}'><i class='fa fa-trash'></i> Hapus</a>
                                </div>";
            return $button;
        })   
        ->make(true);
    }
}
