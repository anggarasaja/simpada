<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ref_jenis_pajak_retribusi;
use App\wp_wr;
use App\v_wp_wr;
use App\ref_reklame_wilayah;
use App\ref_reklame_jenis;
use App\ref_reklame_biaya;
use App\kode_rekening;
use App\spt;
use App\spt_detail;
use App\spt_detailreklame;
use App\setoran_pajak_retribusi;
use App\penetapan_pajak_retribusi;
use App\spt_listrik;
use App\spt_airtanah;
use DB;
use Datatables;
use URL;
use Auth;
use Form;

class Pendataan extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    #########################
    ## FORM REKAM DATA SPT ##
    public function rekam_data(){
    	$getpajak = ref_jenis_pajak_retribusi::where('ref_jenparet_id','!=','6')->orderBy('ref_jenparet_id','asc')->get();
    	return view('rekam_data')->with('getpajak',$getpajak);
    }

    public function sptpd($id_pajak,$status=''){
    	if ($id_pajak == 1) {
    		return view('sptpd_hotel')->with(compact('status'));
    	}
        elseif ($id_pajak == 2) {
            return view('sptpd_restoran')->with(compact('status'));
        }
        elseif ($id_pajak == 3) {
            $korek = kode_rekening::where('korek_rincian','!=','00')
                                    ->where('korek_tipe','4')
                                    ->where('korek_kelompok','1')
                                    ->where('korek_jenis','1')
                                    ->where('korek_objek','03')
                                    ->orderBy('korek_rincian')
                                    ->get();
            return view('sptpd_hiburan')->with(compact('status','korek'));
        }
        elseif ($id_pajak == 4) {
            $wilayah = ref_reklame_wilayah::get();
            $jenis_reklame = ref_reklame_jenis::orderBy('nid','asc')->get();
    		return view('sptpd_rek')->with(compact("wilayah","jenis_reklame",'status'));
    	}
        elseif ($id_pajak == 5) {
            $listrik = DB::table('ref_listrik_keperluan')->get();
            return view('sptpd_jalan')->with(compact('status','listrik'));
        }
        elseif ($id_pajak == 7) {
            $korek = kode_rekening::where('korek_rincian','!=','00')
                                    ->where('korek_tipe','4')
                                    ->where('korek_kelompok','1')
                                    ->where('korek_jenis','1')
                                    ->where('korek_objek','07')
                                    ->orderBy('korek_rincian')
                                    ->get();
            return view('sptpd_parkir')->with(compact('status','korek'));
        }
        elseif ($id_pajak == 8) {
            $kelompok = DB::table('ref_air_tanah_kelompok')
                            // ->where('nid','!=',6)
                            ->orderBy('nid')->get();
            return view('sptpd_airtanah')->with(compact('status','kelompok'));
        }
        elseif ($id_pajak == 9) {
            $korek = kode_rekening::where('korek_rincian','!=','00')
                                    ->where('korek_tipe','4')
                                    ->where('korek_kelompok','1')
                                    ->where('korek_jenis','1')
                                    ->where('korek_objek','09')
                                    ->orderBy('korek_rincian')
                                    ->get();
            return view('sptpd_sarang')->with(compact('status','korek'));
        }
        elseif ($id_pajak == 10) {
            return view('sptpd_retribusi')->with(compact('status'));
        }
    }

    public function editSptpd($id_spt,$id_pajak,$status=''){
        $spt = spt::find($id_spt);
        $spt_detail = spt_detail::where('spt_dt_id_spt',$id_spt)->get();
        $korek = kode_rekening::where('korek_id',$spt->spt_kode_rek)->get();
        $spr = DB::table('setoran_pajak_retribusi')->where('setorpajret_id_penetapan',$id_spt)->get();
        $wp_wr = v_wp_wr::find($spt->spt_idwpwr);
        if ($id_pajak == 1) {
            return view('sptpd_hotel')->with(compact("id_spt",'spt','spt_detail','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 2) {
            return view('sptpd_restoran')->with(compact("id_spt",'spt','spt_detail','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 3) {
            $korek = kode_rekening::where('korek_rincian','!=','00')
                                    ->where('korek_tipe','4')
                                    ->where('korek_kelompok','1')
                                    ->where('korek_jenis','1')
                                    ->where('korek_objek','03')
                                    ->orderBy('korek_rincian')
                                    ->get();
            return view('sptpd_hiburan')->with(compact("id_spt",'spt','spt_detail','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 4) {
            $wilayah = ref_reklame_wilayah::get();
            $jenis_reklame = ref_reklame_jenis::orderBy('nid','asc')->get();
            $spt_dt_rek = spt_detailreklame::where('nid_spt',$id_spt)->get();

            $ppr = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();

            $tambah_spt = spt::where('spt_periode',$spt->spt_periode)
                                ->where('spt_nomor',$spt->spt_nomor)
                                ->where('spt_kode_rek',48)
                                ->get();

            return view('sptpd_rek')->with(compact("id_spt",'spt','tambah_spt','ppr','spt_detail','spt_dt_rek','korek','wp_wr','spr',"wilayah","jenis_reklame",'status'));
        }
        elseif ($id_pajak == 5) {
            $listrik = DB::table('ref_listrik_keperluan')->get();
            $spt_listrik = spt_listrik::where('nid_spt',$id_spt)->get();
            $ref = DB::table('ref_listrik_keperluan')->where('nid',$spt_listrik[0]->nid_listrik_keperluan)->get();

            if($spt->spt_kode_rek == 23){
                $dasar = ($spt->spt_pajak * 100) / $korek[0]->korek_persen_tarif;
            }else{
                $dasar = ($spt->spt_pajak * 100) / $ref[0]->npercent;
            }
                            
            return view('sptpd_jalan')->with(compact("id_spt",'dasar','listrik','spt','spt_detail','spt_listrik','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 7) {
            $listkorek = kode_rekening::where('korek_rincian','!=','00')
                                    ->where('korek_tipe','4')
                                    ->where('korek_kelompok','1')
                                    ->where('korek_jenis','1')
                                    ->where('korek_objek','07')
                                    ->orderBy('korek_rincian')
                                    ->get();
            $dasar = ($spt->spt_pajak * 100) / $korek[0]->korek_persen_tarif;
    
            return view('sptpd_parkir')->with(compact("id_spt",'spt','spt_detail','dasar','korek','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 8) {
            $kelompok = DB::table('ref_air_tanah_kelompok')
                            ->orderBy('nid')->get();

            $ppr = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();

            $spt_airtanah = spt_airtanah::where('nid_spt',$id_spt)->get();
            $spt_airtanah_vol = DB::table('spt_airtanah_volume')->where('nid_spt',$id_spt)->get();
            return view('sptpd_airtanah')->with(compact('kelompok','ppr','spt_airtanah_vol','spt_airtanah',"id_spt",'spt','spt_detail','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 9) {
            $korek = kode_rekening::where('korek_rincian','!=','00')
                                    ->where('korek_tipe','4')
                                    ->where('korek_kelompok','1')
                                    ->where('korek_jenis','1')
                                    ->where('korek_objek','09')
                                    ->orderBy('korek_rincian')
                                    ->get();
            return view('sptpd_sarang')->with(compact("id_spt",'spt','spt_detail','korek','status','wp_wr','spr'));
        }
        elseif ($id_pajak == 10) {
            $ppr = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();

            return view('sptpd_retribusi')->with(compact("id_spt",'ppr','spt','spt_detail','korek','status','wp_wr','spr'));
        }
    }
    ## END FORM REKAM DATA SPT ##
    #############################



    ###########################################
    ##  PENYIMPANAN DAN PENGUBAHAN DATA SPT ###
    public function store_data_hotel(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->dasar_pengenaan);
        $nsr = str_replace(",00", "", $nsr);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "1"; //Pajak HOTEL !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $spt_detail = new spt_detail;
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $nsr;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>1, 'status'=>1]);
    }

    public function edit_data_hotel(Request $request,$id_spt){
        $this->validate($request, [

        ]);

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->dasar_pengenaan);
        $nsr = str_replace(",00", "", $nsr);

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $request->noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "1"; //Pajak HOTEL !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getsptdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();

        $spt_detail = spt_detail::find($getsptdt[0]->spt_dt_id);
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $nsr;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>1, 'status'=>2]);
    }

    public function store_data_resto(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->dasar_pengenaan);
        $nsr = str_replace(",00", "", $nsr);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD (tabel keterangan spt)
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "2"; //Pajak Restoran !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $spt_detail = new spt_detail;
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $nsr;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>2, 'status'=>1]);
    }

    public function edit_data_resto(Request $request,$id_spt){
        $this->validate($request, [

        ]);
        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->dasar_pengenaan);
        $nsr = str_replace(",00", "", $nsr);

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $request->noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "2"; //Pajak Restoran !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getsptdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();

        $spt_detail = spt_detail::find($getsptdt[0]->spt_dt_id);
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $nsr;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>2, 'status'=>2]);
    }

    public function store_data_hibur(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();
        // echo "<pre>";l

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $total_pajak = 0;
        for ($i=0; $i < count($request->pajak); $i++) { 
            $paj = round($request->pajak[$i]);
            $total_pajak = $total_pajak + $paj;
        }

        $kr = $request->korek[0];
        $pecah = explode(";", $kr);
        $koderek = $pecah[0];

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $koderek;
        $spt->spt_alamat_penerima = $request->keterangan;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD 
        $spt->spt_pajak = $total_pajak;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "3"; //Pajak Hiburan !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        for ($j=0; $j < count($request->pajak); $j++) { 
            $spt_detail = new spt_detail;
            $pecah_korek = explode(";", $request->korek[$j]);
            $korek_id = $pecah_korek[0];
            $spt_detail->spt_dt_id_spt = $spt->spt_id;
            $spt_detail->spt_dt_korek = $korek_id;
            $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan[$j];
            $spt_detail->spt_dt_persen_tarif = $request->persen[$j];
            $spt_detail->spt_dt_pajak = round($request->pajak[$j]);
            $spt_detail->spt_dt_diskon = 100;
            $spt_detail->spt_dt_jam = 1;
            $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
            $spt_detail->spt_dt_diskon = 0;
            $spt_detail->spt_dt_jam = 0;
            $spt_detail->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>3, 'status'=>1]);
    }

    public function edit_data_hibur(Request $request, $id_spt){
        $this->validate($request, [

        ]);
        // $noreg = $this->getnoreg();
        // echo "<pre>";l

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $total_pajak = 0;
        for ($i=0; $i < count($request->pajak); $i++) { 
            $paj = round($request->pajak[$i]);
            $total_pajak = $total_pajak + $paj;
        }

        $kr = $request->korek[0];
        $pecah = explode(";", $kr);
        $koderek = $pecah[0];

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $request->noreg;
        $spt->spt_kode_rek = $koderek;
        $spt->spt_alamat_penerima = $request->keterangan;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //MASIH BELUM TAU DARI MANA????????
        $spt->spt_pajak = $total_pajak;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "3"; //Pajak Hiburan !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg; 
        $spt->save();

        $getdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();
        foreach ($getdt as $key) {
            $sptdt = spt_detail::find($key->spt_dt_id);
            $sptdt->delete();
        }

        for ($j=0; $j < count($request->pajak); $j++) { 
            $spt_detail = new spt_detail;
            $pecah_korek = explode(";", $request->korek[$j]);
            $korek_id = $pecah_korek[0];
            $spt_detail->spt_dt_id_spt = $spt->spt_id;
            $spt_detail->spt_dt_korek = $korek_id;
            $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan[$j];
            $spt_detail->spt_dt_persen_tarif = $request->persen[$j];
            $spt_detail->spt_dt_pajak = round($request->pajak[$j]);
            $spt_detail->spt_dt_diskon = 100;
            $spt_detail->spt_dt_jam = 1;
            $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
            $spt_detail->spt_dt_diskon = 0;
            $spt_detail->spt_dt_jam = 0;
            $spt_detail->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>3, 'status'=>2]);
    }

    public function store_data_reklame(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $mili = explode(".",$date_array[0]);
        $datenow = date("Y-m-d H:i:s",$date_array[1]) . '.'. $mili[1];

        // echo "<pre>";
        // dd($request);die;

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_daftar);
        $tgl_daftar  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $jatuh_tempo = date('Y-m-d',strtotime('+10 day', strtotime($tgl_daftar)));

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->nsr);
        $nsr = str_replace(",00", "", $nsr);
        $rethutang = str_replace(".", "", $request->ret_hutang);
        $rethutang = str_replace(",00", "", $rethutang);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "1";  //SKPD
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "4"; //Pajak Reklame !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        if ($rethutang != '0' && $rethutang != '') {
            $spt2 = new spt;
            $spt2->spt_periode = date("Y");
            $spt2->spt_nomor = $noreg;
            $spt2->spt_kode_rek = '48'; //MASIH BELUM TAU DARI MANA????????
            $spt2->spt_periode_jual1 = $pajak_awal;
            $spt2->spt_periode_jual2 = $pajak_akhir;
            $spt2->spt_status = "9";  //Retribusi SKRD
            $spt2->spt_pajak = $rethutang;
            $spt2->spt_operator = Auth::user()->opr_id;
            $spt2->spt_jenis_pajakretribusi = "10"; //Retribusi !!
            $spt2->spt_idwpwr = $request->id_wpwr;
            $spt2->spt_jenis_pemungutan = $request->pemungutan;
            $spt2->spt_tgl_proses = $pajak_awal;
            $spt2->spt_tgl_entry = $tgl_entry;
            $spt2->spt_no_register = $request->noreg;
            $spt2->save();
        }

        $spt_detail = new spt_detail;
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $nsr;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        if ($rethutang != '0' && $rethutang != '') {
            $spt_detail2 = new spt_detail;
            $spt_detail2->spt_dt_id_spt = $spt2->spt_id;
            $spt_detail2->spt_dt_korek = '48';
            $spt_detail2->spt_dt_jumlah = $nsr;
            $spt_detail2->spt_dt_persen_tarif = $request->korek_persen_tarif;
            $spt_detail2->spt_dt_pajak = $rethutang;
            $spt_detail2->spt_dt_tarif_dasar = 0; //i did not know!!
            $spt_detail2->spt_dt_diskon = 0;
            $spt_detail2->spt_dt_jam = 0;
            $spt_detail2->save();
        }

        $spt_dt_reklame = new spt_detailreklame;
        $spt_dt_reklame->nid_spt = $spt->spt_id;
        $spt_dt_reklame->nid_wilayah = $request->nid_wilayah;
        $spt_dt_reklame->nid_reklame = $request->nid_reklame;
        $spt_dt_reklame->cnaskah = $request->nama_naskah;
        $spt_dt_reklame->clokasi = $request->lokasi;
        $spt_dt_reklame->npanjang = $request->panjang;
        $spt_dt_reklame->nlebar = $request->lebar;
        $spt_dt_reklame->nmuka = $request->muka;
        $spt_dt_reklame->njumlah = $request->jumlah;
        $spt_dt_reklame->njangka_waktu = $request->jangka_waktu;
        $spt_dt_reklame->cjangka_waktu = $request->satuan;
        $spt_dt_reklame->keterangan_pajak = $request->keterangan;
        $spt_dt_reklame->save();

        $netapajrek = new penetapan_pajak_retribusi;
        $netapajrek->netapajrek_id_spt = $spt->spt_id;
        $netapajrek->netapajrek_tgl = $tgl_daftar;
        $netapajrek->netapajrek_wkt_proses = $datenow;
        $netapajrek->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
        $netapajrek->netapajrek_kohir = $noreg;
        $netapajrek->netapajrek_jenis_ketetapan = '1'; //SKPD
        $netapajrek->save();

        if ($rethutang != '0' && $rethutang != '') {
            $netapajrek2 = new penetapan_pajak_retribusi;
            $netapajrek2->netapajrek_id_spt = $spt2->spt_id;
            $netapajrek2->netapajrek_tgl = $tgl_daftar;
            $netapajrek2->netapajrek_wkt_proses = $datenow;
            $netapajrek2->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
            $netapajrek2->netapajrek_kohir = $noreg;
            $netapajrek2->netapajrek_jenis_ketetapan = '9'; //SKRD
            $netapajrek2->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>4, 'status'=>1]);
    }

    public function edit_data_reklame(Request $request, $id_spt){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $mili = explode(".",$date_array[0]);
        $datenow = date("Y-m-d H:i:s",$date_array[1]) . '.'. $mili[1];

        // echo "<pre>";
        // dd($request);die;

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_daftar);
        $tgl_daftar  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $jatuh_tempo = date('Y-m-d',strtotime('+10 day', strtotime($tgl_daftar)));

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->nsr);
        $nsr = str_replace(",00", "", $nsr);
        $rethutang = str_replace(".", "", $request->ret_hutang);
        $rethutang = str_replace(",00", "", $rethutang);

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "1";  //SKPD
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "4"; //Pajak Reklame !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        if ($rethutang != '0' && $rethutang != '') {
            $spt2 = spt::find($request->id_spt2);
            $spt2->spt_periode = date("Y");
            $spt2->spt_nomor = $noreg;
            $spt2->spt_kode_rek = '48'; //MASIH BELUM TAU DARI MANA????????
            $spt2->spt_periode_jual1 = $pajak_awal;
            $spt2->spt_periode_jual2 = $pajak_akhir;
            $spt2->spt_status = "9";  //Retribusi SKRD
            $spt2->spt_pajak = $rethutang;
            $spt2->spt_operator = Auth::user()->opr_id;
            $spt2->spt_jenis_pajakretribusi = "10"; //Retribusi !!
            $spt2->spt_idwpwr = $request->id_wpwr;
            $spt2->spt_jenis_pemungutan = $request->pemungutan;
            $spt2->spt_tgl_proses = $pajak_awal;
            $spt2->spt_tgl_entry = $tgl_entry;
            $spt2->spt_no_register = $request->noreg;
            $spt2->save();
        }

        $getdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();

        $spt_detail = spt_detail::find($getdt[0]->spt_dt_id);
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $nsr;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0; //i did not know!!
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        if ($rethutang != '0' && $rethutang != '') {
            $getdt2 = spt_detail::where('spt_dt_id_spt',$request->id_spt2)->get();

            $spt_detail2 = spt_detail::find($getdt2[0]->spt_dt_id);
            $spt_detail2->spt_dt_id_spt = $spt2->spt_id;
            $spt_detail2->spt_dt_korek = '48';
            $spt_detail2->spt_dt_jumlah = $nsr;
            $spt_detail2->spt_dt_persen_tarif = $request->korek_persen_tarif;
            $spt_detail2->spt_dt_pajak = $rethutang;
            $spt_detail2->spt_dt_tarif_dasar = 0; //i did not know!!
            $spt_detail2->spt_dt_diskon = 0;
            $spt_detail2->spt_dt_jam = 0;
            $spt_detail2->save();
        }

        $getdtrek = spt_detailreklame::where('nid_spt',$id_spt)->get();

        $spt_dt_reklame = spt_detailreklame::find($getdtrek[0]->nid);
        $spt_dt_reklame->nid_spt = $spt->spt_id;
        $spt_dt_reklame->nid_wilayah = $request->nid_wilayah;
        $spt_dt_reklame->nid_reklame = $request->nid_reklame;
        $spt_dt_reklame->cnaskah = $request->nama_naskah;
        $spt_dt_reklame->clokasi = $request->lokasi;
        $spt_dt_reklame->npanjang = $request->panjang;
        $spt_dt_reklame->nlebar = $request->lebar;
        $spt_dt_reklame->nmuka = $request->muka;
        $spt_dt_reklame->njumlah = $request->jumlah;
        $spt_dt_reklame->njangka_waktu = $request->jangka_waktu;
        $spt_dt_reklame->cjangka_waktu = $request->satuan;
        $spt_dt_reklame->keterangan_pajak = $request->keterangan;
        $spt_dt_reklame->save();

        $getnetapajrek = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();

        $netapajrek = penetapan_pajak_retribusi::find($getnetapajrek[0]->netapajrek_id);
        $netapajrek->netapajrek_id_spt = $spt->spt_id;
        $netapajrek->netapajrek_tgl = $tgl_daftar;
        $netapajrek->netapajrek_wkt_proses = $datenow;
        $netapajrek->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
        $netapajrek->netapajrek_kohir = $noreg;
        $netapajrek->netapajrek_jenis_ketetapan = '1'; //SKPD
        $netapajrek->save();

        if ($rethutang != '0' && $rethutang != '') {
            $getnetapajrek2 = penetapan_pajak_retribusi::where('netapajrek_id_spt',$request->id_spt2)->get();
            
            $netapajrek2 = penetapan_pajak_retribusi::find($getnetapajrek2[0]->netapajrek_id);
            $netapajrek2->netapajrek_id_spt = $spt2->spt_id;
            $netapajrek2->netapajrek_tgl = $tgl_daftar;
            $netapajrek2->netapajrek_wkt_proses = $datenow;
            $netapajrek2->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
            $netapajrek2->netapajrek_kohir = $noreg;
            $netapajrek2->netapajrek_jenis_ketetapan = '9'; //SKRD
            $netapajrek2->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>4, 'status'=>2]);
    }

    public function store_data_jalan(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->dasar_pengenaan);
        $nsr = str_replace(",00", "", $nsr);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "5"; //Pajak Penerangan Jalan !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $spt_detail = new spt_detail;
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0;
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        $getidlistrik = DB::select('select max(nid) from spt_listrik');
        $noid = $getidlistrik[0]->max + 1; 

        $pecah = explode(";", $request->penggunaan);
        $penggunaan = $pecah[0];

        $spt_listrik = new spt_listrik;
        $spt_listrik->nid = $noid;
        $spt_listrik->nid_spt = $spt->spt_id;
        if ($request->id_korek == 23) {
            $spt_listrik->ndaya = 0;
            $spt_listrik->njam = 0;
            $spt_listrik->nid_listrik_keperluan = 0;
        }else{
            $spt_listrik->ndaya = $request->daya_listrik;
            $spt_listrik->njam = $request->jangka_waktu;
            $spt_listrik->nid_listrik_keperluan = $penggunaan;
        }
        $spt_listrik->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>5, 'status'=>1]);
    }

    public function edit_data_jalan(Request $request,$id_spt){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->dasar_pengenaan);
        $nsr = str_replace(",00", "", $nsr);

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "5"; //Pajak Penerangan Jalan !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getdt = DB::table('spt_detail')->where('spt_dt_id_spt',$id_spt)->get();

        $spt_detail = spt_detail::find($getdt[0]->spt_dt_id);
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_tarif_dasar = 0;
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        $getidlistrik = DB::table('spt_listrik')->where('nid_spt',$id_spt)->get();
        $noid = $getidlistrik[0]->nid; 

        $pecah = explode(";", $request->penggunaan);
        $penggunaan = $pecah[0];

        $spt_listrik = spt_listrik::find($noid);
        $spt_listrik->nid_spt = $spt->spt_id;
        if ($request->id_korek == 23) {
            $spt_listrik->ndaya = 0;
            $spt_listrik->njam = 0;
            $spt_listrik->nid_listrik_keperluan = 0;
        }else{
            $spt_listrik->ndaya = $request->daya_listrik;
            $spt_listrik->njam = $request->jangka_waktu;
            $spt_listrik->nid_listrik_keperluan = $penggunaan;
        }
        $spt_listrik->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>5, 'status'=>2]);
    }

    public function store_data_parkir(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $total_pajak = 0;
        for ($i=0; $i < count($request->pajak); $i++) { 
            $paj = round($request->pajak[$i]);
            $total_pajak = $total_pajak + $paj;
        }
        $dasar_pengenaan = 0;
        for ($i=0; $i < count($request->dasar_pengenaan); $i++) { 
            $paj = round($request->dasar_pengenaan[$i]);
            $dasar_pengenaan = $dasar_pengenaan + $paj;
        }

        $kr = $request->korek[0];
        $pecah = explode(";", $kr);
        $koderek = $pecah[0];

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $koderek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD 
        $spt->spt_pajak = $total_pajak;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "7"; //Pajak parkir !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        for ($j=0; $j < count($request->pajak); $j++) { 
            $spt_detail = new spt_detail;
            $pecah_korek = explode(";", $request->korek[$j]);
            $korek_id = $pecah_korek[0];
            $spt_detail->spt_dt_id_spt = $spt->spt_id;
            $spt_detail->spt_dt_korek = $korek_id;
            $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan[$j];
            $spt_detail->spt_dt_persen_tarif = $request->persen[$j];
            $spt_detail->spt_dt_pajak = round($request->pajak[$j]);
            $spt_detail->spt_dt_diskon = 100;
            $spt_detail->spt_dt_jam = 1;
            $spt_detail->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>7, 'status'=>1]);
    }

    public function edit_data_parkir(Request $request, $id_spt){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $total_pajak = 0;
        for ($i=0; $i < count($request->pajak); $i++) { 
            $paj = round($request->pajak[$i]);
            $total_pajak = $total_pajak + $paj;
        }

        $kr = $request->korek[0];
        $pecah = explode(";", $kr);
        $koderek = $pecah[0];

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $koderek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //SPTPD 
        $spt->spt_pajak = $total_pajak;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "7"; //Pajak parkir !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();
        foreach ($getdt as $key) {
            $sptdt = spt_detail::find($key->spt_dt_id);
            $sptdt->delete();
        }

        for ($j=0; $j < count($request->pajak); $j++) { 
            $spt_detail = new spt_detail;
            $pecah_korek = explode(";", $request->korek[$j]);
            $korek_id = $pecah_korek[0];
            $spt_detail->spt_dt_id_spt = $spt->spt_id;
            $spt_detail->spt_dt_korek = $korek_id;
            $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan[$j];
            $spt_detail->spt_dt_persen_tarif = $request->persen[$j];
            $spt_detail->spt_dt_pajak = round($request->pajak[$j]);
            $spt_detail->spt_dt_diskon = 100;
            $spt_detail->spt_dt_jam = 1;
            $spt_detail->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>7, 'status'=>2]);
    }

    public function store_data_airtanah(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $mili = explode(".",$date_array[0]);
        $datenow = date("Y-m-d H:i:s",$date_array[1]) . '.'. $mili[1];

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_daftar);
        $tgl_daftar  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jatuh_tempo = date('Y-m-d',strtotime('+10 day', strtotime($tgl_daftar)));

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->kd_rek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "1";  //SKPD 
        $spt->spt_pajak = round($pajak_terhutang);
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "8"; //Pajak airtanah !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $spt_detail = new spt_detail;
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = 0;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = round($pajak_terhutang);
        $spt_detail->spt_dt_diskon = 100;
        $spt_detail->spt_dt_jam = 1;
        $spt_detail->save();

        $spt_airtanah = new spt_airtanah;
        $spt_airtanah->nid_spt = $spt->spt_id;
        $spt_airtanah->nid_wilayah = $request->wilayah;
        $spt_airtanah->nid_kelompok = $request->kelompok;
        $spt_airtanah->nvolume = $request->volume_m3;
        $spt_airtanah->npajak = round($pajak_terhutang);
        $spt_airtanah->nsumur = $request->sumur;
        $spt_airtanah->save();

        for ($i=1; $i <= 6 ; $i++) { 
            if ($i==1) {
                DB::table('spt_airtanah_volume')->insert(
                    ['nid_spt' => $spt->spt_id, 
                    'cvolume' => $request->volume_m3,
                    'nm' => 0,
                    'ntarif' => $request->harga_dasar,
                    'njumlah' => $request->tarif_pajak,
                    'nharga' => round($pajak_terhutang),
                    'norder' => $i
                    ]
                );
            }else{
                DB::table('spt_airtanah_volume')->insert(
                    ['nid_spt' => $spt->spt_id, 
                    'cvolume' => 0,
                    'nm' => 0,
                    'ntarif' => 0,
                    'njumlah' => 0,
                    'nharga' => 0,
                    'norder' => $i
                    ]
                );
            }
        }

        $netapajrek = new penetapan_pajak_retribusi;
        $netapajrek->netapajrek_id_spt = $spt->spt_id;
        $netapajrek->netapajrek_tgl = $tgl_daftar;
        $netapajrek->netapajrek_wkt_proses = $datenow;
        $netapajrek->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
        $netapajrek->netapajrek_kohir = $noreg;
        $netapajrek->netapajrek_jenis_ketetapan = '1'; //SKPD
        $netapajrek->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>8, 'status'=>1]);
    }

    public function edit_data_airtanah(Request $request, $id_spt){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $mili = explode(".",$date_array[0]);
        $datenow = date("Y-m-d H:i:s",$date_array[1]) . '.'. $mili[1];

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_daftar);
        $tgl_daftar  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jatuh_tempo = date('Y-m-d',strtotime('+10 day', strtotime($tgl_daftar)));

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->kd_rek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "1";  //SKPD 
        $spt->spt_pajak = round($pajak_terhutang);
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "8"; //Pajak airtanah !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();

        $spt_detail = spt_detail::find($getdt[0]->spt_dt_id);
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = 0;
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = round($pajak_terhutang);
        $spt_detail->spt_dt_diskon = 100;
        $spt_detail->spt_dt_jam = 1;
        $spt_detail->save();

        $getairtanah = spt_airtanah::where('nid_spt',$id_spt)->get();

        $spt_airtanah = spt_airtanah::find($getairtanah[0]->nid);
        $spt_airtanah->nid_spt = $spt->spt_id;
        $spt_airtanah->nid_wilayah = $request->wilayah;
        $spt_airtanah->nid_kelompok = $request->kelompok;
        $spt_airtanah->nvolume = $request->volume_m3;
        $spt_airtanah->npajak = round($pajak_terhutang);
        $spt_airtanah->nsumur = $request->sumur;
        $spt_airtanah->save();

        DB::table('spt_airtanah_volume')->where('nid_spt',$id_spt)->delete();

        for ($i=1; $i <= 6 ; $i++) { 
            if ($i==1) {
                DB::table('spt_airtanah_volume')->insert(
                    ['nid_spt' => $spt->spt_id, 
                    'cvolume' => $request->volume_m3,
                    'nm' => 0,
                    'ntarif' => $request->harga_dasar,
                    'njumlah' => $request->tarif_pajak,
                    'nharga' => round($pajak_terhutang),
                    'norder' => $i
                    ]
                );
            }else{
                DB::table('spt_airtanah_volume')->insert(
                    ['nid_spt' => $spt->spt_id, 
                    'cvolume' => 0,
                    'nm' => 0,
                    'ntarif' => 0,
                    'njumlah' => 0,
                    'nharga' => 0,
                    'norder' => $i
                    ]
                );
            }
        }

        $getnetapajrek = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();

        $netapajrek = penetapan_pajak_retribusi::find($getnetapajrek[0]->netapajrek_id);
        $netapajrek->netapajrek_id_spt = $spt->spt_id;
        $netapajrek->netapajrek_tgl = $tgl_daftar;
        $netapajrek->netapajrek_wkt_proses = $datenow;
        $netapajrek->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
        $netapajrek->netapajrek_kohir = $noreg;
        $netapajrek->netapajrek_jenis_ketetapan = '1'; //SKPD
        $netapajrek->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>8, 'status'=>2]);
    }

    public function store_data_sarang(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $total_pajak = 0;
        for ($i=0; $i < count($request->pajak); $i++) { 
            $paj = round($request->pajak[$i]);
            $total_pajak = $total_pajak + $paj;
        }

        $kr = $request->korek[0];
        $pecah = explode(";", $kr);
        $koderek = $pecah[0];

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $koderek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //MASIH BELUM TAU DARI MANA????????
        $spt->spt_pajak = $total_pajak;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "9"; //Pajak sarang walet !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        for ($j=0; $j < count($request->pajak); $j++) { 
            $spt_detail = new spt_detail;
            $pecah_korek = explode(";", $request->korek[$j]);
            $korek_id = $pecah_korek[0];
            $spt_detail->spt_dt_id_spt = $spt->spt_id;
            $spt_detail->spt_dt_korek = $korek_id;
            $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan[$j];
            $spt_detail->spt_dt_tarif_dasar = $request->tarif_dasar[$j];
            $spt_detail->spt_dt_persen_tarif = $request->persen[$j];
            $spt_detail->spt_dt_pajak = round($request->pajak[$j]);
            $spt_detail->spt_dt_lokasi = $request->lokasi[$j];
            $spt_detail->spt_dt_diskon = 100;
            $spt_detail->spt_dt_jam = 1;
            $spt_detail->spt_dt_volume = $request->jumlah[$j];
            $spt_detail->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>9, 'status'=>1]);
    }

    public function edit_data_sarang(Request $request, $id_spt){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $total_pajak = 0;
        for ($i=0; $i < count($request->pajak); $i++) { 
            $paj = round($request->pajak[$i]);
            $total_pajak = $total_pajak + $paj;
        }

        $kr = $request->korek[0];
        $pecah = explode(";", $kr);
        $koderek = $pecah[0];

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $koderek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  
        $spt->spt_pajak = $total_pajak;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "9"; //Pajak sarang walet !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();
        foreach ($getdt as $key) {
            $sptdt = spt_detail::find($key->spt_dt_id);
            $sptdt->delete();
        }

        for ($j=0; $j < count($request->pajak); $j++) { 
            $spt_detail = new spt_detail;
            $pecah_korek = explode(";", $request->korek[$j]);
            $korek_id = $pecah_korek[0];
            $spt_detail->spt_dt_id_spt = $spt->spt_id;
            $spt_detail->spt_dt_korek = $korek_id;
            $spt_detail->spt_dt_jumlah = $request->dasar_pengenaan[$j];
            $spt_detail->spt_dt_tarif_dasar = $request->tarif_dasar[$j];
            $spt_detail->spt_dt_persen_tarif = $request->persen[$j];
            $spt_detail->spt_dt_pajak = round($request->pajak[$j]);
            $spt_detail->spt_dt_lokasi = $request->lokasi[$j];
            $spt_detail->spt_dt_diskon = 100;
            $spt_detail->spt_dt_jam = 1;
            $spt_detail->spt_dt_volume = $request->jumlah[$j];
            $spt_detail->save();
        }

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>9, 'status'=>2]);
    }

    public function store_data_retribusi(Request $request){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $mili = explode(".",$date_array[0]);
        $datenow = date("Y-m-d H:i:s",$date_array[1]) . '.'. $mili[1];

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_daftar);
        $tgl_daftar  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jatuh_tempo = date('Y-m-d',strtotime('+10 day', strtotime($tgl_daftar)));

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = $request->ketetapan;  
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "10"; //Retribusi !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $spt_detail = new spt_detail;
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = 0;
        $spt_detail->spt_dt_persen_tarif = 0;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_lokasi = $request->keterangan; 
        $spt_detail->spt_dt_tarif_dasar = 0; 
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        $netapajrek = new penetapan_pajak_retribusi;
        $netapajrek->netapajrek_id_spt = $spt->spt_id;
        $netapajrek->netapajrek_tgl = $tgl_daftar;
        $netapajrek->netapajrek_wkt_proses = $datenow;
        $netapajrek->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
        $netapajrek->netapajrek_kohir = $noreg;
        $netapajrek->netapajrek_jenis_ketetapan = $request->ketetapan; //SKPD
        $netapajrek->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>10, 'status'=>1]);
    }

    public function edit_data_retribusi(Request $request, $id_spt){
        $this->validate($request, [

        ]);
        $noreg = $this->getnoreg();

        $micro_date = microtime();
        $date_array = explode(" ",$micro_date);
        $mili = explode(".",$date_array[0]);
        $datenow = date("Y-m-d H:i:s",$date_array[1]) . '.'. $mili[1];

        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_daftar);
        $tgl_daftar  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $jatuh_tempo = date('Y-m-d',strtotime('+10 day', strtotime($tgl_daftar)));

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);

        $spt = spt::find($id_spt);
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = $request->ketetapan;  
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "10"; //Retribusi !!
        $spt->spt_idwpwr = $request->id_wpwr;
        $spt->spt_jenis_pemungutan = $request->pemungutan;
        $spt->spt_tgl_proses = $pajak_awal;
        $spt->spt_tgl_entry = $tgl_entry;
        $spt->spt_no_register = $request->noreg;
        $spt->save();

        $getdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();

        $spt_detail = spt_detail::find($getdt[0]->spt_dt_id);
        $spt_detail->spt_dt_id_spt = $spt->spt_id;
        $spt_detail->spt_dt_korek = $request->id_korek;
        $spt_detail->spt_dt_jumlah = 0;
        $spt_detail->spt_dt_persen_tarif = 0;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->spt_dt_lokasi = $request->keterangan; 
        $spt_detail->spt_dt_tarif_dasar = 0; 
        $spt_detail->spt_dt_diskon = 0;
        $spt_detail->spt_dt_jam = 0;
        $spt_detail->save();

        $getnetapajrek = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();

        $netapajrek = penetapan_pajak_retribusi::find($getnetapajrek[0]->netapajrek_id);
        $netapajrek->netapajrek_id_spt = $spt->spt_id;
        $netapajrek->netapajrek_tgl = $tgl_daftar;
        $netapajrek->netapajrek_wkt_proses = $datenow;
        $netapajrek->netapajrek_tgl_jatuh_tempo = $jatuh_tempo;
        $netapajrek->netapajrek_kohir = $noreg;
        $netapajrek->netapajrek_jenis_ketetapan = $request->ketetapan; //SKPD
        $netapajrek->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>10, 'status'=>2]);
    }

    ## END PENYIMPANAN DAN PENGUBAHAN DATA SPT ###
    ##############################################



    #######################
    ## LIHAT DATA TABEL ###
    public function lihat_data_hotel($status=""){
        return view('lihat_data_hotel')->with('status',$status);
    }

    public function lihat_data_resto($status=""){
        return view('lihat_data_resto')->with('status',$status);
    }

    public function lihat_data_hibur($status=""){
        return view('lihat_data_hibur')->with('status',$status);
    }

    public function lihat_data_reklame($status=""){
        return view('lihat_data_reklame')->with('status',$status);
    }

    public function lihat_data_jalan($status=""){
        return view('lihat_data_jalan')->with('status',$status);
    }

    public function lihat_data_parkir($status=""){
        return view('lihat_data_parkir')->with('status',$status);
    }

    public function lihat_data_airtanah($status=""){
        return view('lihat_data_airtanah')->with('status',$status);
    }

    public function lihat_data_sarang($status=""){
        return view('lihat_data_sarang')->with('status',$status);
    }

    public function lihat_data_retribusi($status=""){
        return view('lihat_data_retribusi')->with('status',$status);
    }

    public function get_data_hotel(){
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

    public function get_data_resto(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_jenis_pajakretribusi',2) // 2 = restoran
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
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/2') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/2') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
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

    public function get_data_hibur(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_jenis_pajakretribusi',3) // 3 = hiburan
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
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/3') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/3') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
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

    public function get_data_reklame(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
                    ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                    ->where('spt.spt_jenis_pajakretribusi',4) // 4 = reklame
                    ->orderBy('spt_id','DESC')
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'v_wp_wr.wp_wr_nama',
                                    'v_wp_wr.wp_wr_almt',
                                    'v_wp_wr.npwprd',
                                    'kode_rekening.korek_nama',
                                    'spt.spt_pajak',
                                    'spt_detailreklame.cnaskah',
                                    'penetapan_pajak_retribusi.netapajrek_tgl',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d/m/Y", strtotime($spt_periode_jual1)) }} s.d. {{ date("d/m/Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('netapajrek_tgl','{{ date("d M Y", strtotime($netapajrek_tgl)) }}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->addColumn('aksi', function ($row) {
            $button = "<div class='btn-group-vertical'>";
            if ($row->setorpajret_tgl_bayar != "") {
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/4') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/4') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
                $button .=  Form::open(array('url' => 'pendataan/sptpd/delete/' .$row->spt_id . '', 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            }
            $button .= "</div>";
            return $button;
        })   
        ->make(true);
    }

    public function get_data_jalan(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_jenis_pajakretribusi',5) // 5 = penerangan jalan
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
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/5') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/5') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
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

    public function get_data_parkir(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_jenis_pajakretribusi',7) // parkir
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
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/7') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/7') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
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

    public function get_data_airtanah(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                    ->where('spt.spt_jenis_pajakretribusi',8) // 8 = air tanah
                    ->orderBy('spt_id','DESC')
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'v_wp_wr.wp_wr_nama',
                                    'v_wp_wr.wp_wr_almt',
                                    'v_wp_wr.npwprd',
                                    'kode_rekening.korek_nama',
                                    'spt.spt_pajak',
                                    'penetapan_pajak_retribusi.netapajrek_tgl',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("M Y", strtotime($spt_periode_jual1)) }}')
        ->editColumn('netapajrek_tgl','{{ date("d M Y", strtotime($netapajrek_tgl)) }}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->addColumn('aksi', function ($row) {
            $button = "<div class='btn-group-vertical'>";
            if ($row->setorpajret_tgl_bayar != "") {
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/8') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/8') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
                $button .=  Form::open(array('url' => 'pendataan/sptpd/delete/' .$row->spt_id . '', 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            }
            $button .= "</div>";
            return $button;
        })   
        ->make(true);
    }

    public function get_data_sarang(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_jenis_pajakretribusi',9) //91 = walet
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
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/9') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/9') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
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

    public function get_data_retribusi(){
        $query = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                    ->where('spt.spt_jenis_pajakretribusi',10) // 10 = retribusi
                    ->orderBy('spt_id','DESC')
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'v_wp_wr.wp_wr_nama',
                                    'v_wp_wr.npwprd',
                                    'kode_rekening.korek_nama',
                                    'spt.spt_pajak',
                                    'penetapan_pajak_retribusi.netapajrek_tgl',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("M Y", strtotime($spt_periode_jual1)) }}')
        ->editColumn('netapajrek_tgl','{{ date("d M Y", strtotime($netapajrek_tgl)) }}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->addColumn('aksi', function ($row) {
            $button = "<div class='btn-group-vertical'>";
            if ($row->setorpajret_tgl_bayar != "") {
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/10') ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
            }else{
                $button .= "<a type='button' class='btn btn-warning btn-xs' href='". URL::to('pendataan/sptpd/edit/'.$row->spt_id.'/10') ."'><i class='fa fa-pencil'></i>&nbsp; EDIT</a>";
                $button .=  Form::open(array('url' => 'pendataan/sptpd/delete/' .$row->spt_id . '', 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            }
            $button .= "</div>";
            return $button;
        })   
        ->make(true);
    }
    ## END LIHAT DATA TABEL ###
    ###########################


    ##################
    ## HISTORY SPT ###
    //hotel
    public function gethistory_hotel($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',1)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah', 
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_dt_jumlah','{{ number_format($spt_dt_jumlah,2,",",".")}}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
    }

    //restoran
    public function gethistory_resto($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',2)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah', 
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_dt_jumlah','{{ number_format($spt_dt_jumlah,2,",",".")}}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
        // return Datatables::queryBuilder(DB::table('spt'))->make(true);
    }

    //hiburan
    public function gethistory_hibur($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',3)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah', 
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_dt_jumlah','{{ number_format($spt_dt_jumlah,2,",",".")}}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
        // return Datatables::queryBuilder(DB::table('spt'))->make(true);
    }

    public function gethistory_rek($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
                    ->join('ref_reklame_jenis','ref_reklame_jenis.nid','=','spt_detailreklame.nid_reklame')
                    ->join('ref_reklame_wilayah','ref_reklame_wilayah.nid','=','spt_detailreklame.nid_wilayah')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',4)

                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah',
                                    'ref_reklame_jenis.cname as jenis', 
                                    'ref_reklame_wilayah.cname as wilayah', 
                                    'setoran_pajak_retribusi.setorpajret_jlh_bayar',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar',
                                    'spt_detailreklame.cnaskah',
                                    'spt_detailreklame.npanjang',
                                    'spt_detailreklame.nlebar',
                                    'spt_detailreklame.nmuka',
                                    'spt_detailreklame.njumlah',
                                    'spt_detailreklame.clokasi'
                                    ));

        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_dt_jumlah','{{ number_format($spt_dt_jumlah,2,",",".")}}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_jlh_bayar','{{ ($setorpajret_jlh_bayar) ? date("d M Y", strtotime($setorpajret_jlh_bayar)) : "-"}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->addColumn('keterangan','{{ $cnaskah }} ({{ $npanjang }}m x {{ $nlebar }}m x {{ $nmuka }}muka x {{ $njumlah }} unit), {{ $clokasi }}')
        ->removeColumn('spt_periode_jual2')
        ->removeColumn('cnaskah')
        ->removeColumn('npanjang')
        ->removeColumn('nlebar')
        ->removeColumn('nmuka')
        ->removeColumn('njumlah')
        ->removeColumn('clokasi')
        ->make(true);
    }

    public function gethistory_jalan($wp_wr_id){
        $query = spt::join('spt_listrik','spt.spt_id','=','spt_listrik.nid_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->leftjoin('ref_listrik_keperluan','ref_listrik_keperluan.nid','=','spt_listrik.nid_listrik_keperluan')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',5)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_kode_rek', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'kode_rekening.korek_persen_tarif',
                                    'ref_listrik_keperluan.npercent',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->addColumn('dasar','@if($spt_kode_rek == 23)
                                <?php $total = ($spt_pajak * 100) / $korek_persen_tarif ?>
                            @else
                                <?php $total = ($spt_pajak * 100) / $npercent ?>
                            @endif
                            
                            {{ number_format($total,2,",",".")}}
                            ')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
    }

    public function gethistory_parkir($wp_wr_id){
        $query = spt::join('kode_rekening','spt.spt_kode_rek','=','kode_rekening.korek_id')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',7)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'kode_rekening.korek_persen_tarif', 
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_dt_jumlah','<?php $total = ($spt_pajak*100)/$korek_persen_tarif ?>
                                    {{ number_format($total,2,",",".")}}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
    }

    public function gethistory_airtanah($wp_wr_id){
        $query = spt::join('spt_airtanah','spt.spt_id','=','spt_airtanah.nid_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',8)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_airtanah.nvolume',
                                    'spt_airtanah.nsumur',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("M Y", strtotime($spt_periode_jual1)) }}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
    }

    public function gethistory_sarang($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',9)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah', 
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_dt_jumlah','{{ number_format($spt_dt_jumlah,2,",",".")}}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
    }

    public function gethistory_retribusi($wp_wr_id){
        $query = spt::join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','spt.spt_id')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->where('spt.spt_jenis_pajakretribusi',10)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'setoran_pajak_retribusi.setorpajret_tgl_bayar'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('spt_periode_jual1','{{ date("d M Y", strtotime($spt_periode_jual1)) }} s/d {{ date("d M Y", strtotime($spt_periode_jual2)) }}')
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->removeColumn('spt_periode_jual2')
        ->make(true);
    }
    ## END HISTORY SPT ###
    ######################



    ################
    ## DELETE SPT ##
    public function delete_spt($id_spt){
        $spt = spt::find($id_spt);
        $jenis = $spt->spt_jenis_pajakretribusi;
        $spt->delete();

        $getsptdt = spt_detail::where('spt_dt_id_spt',$id_spt)->get();

        foreach ($getsptdt as $key) {
            $spt_detail = spt_detail::find($key->spt_dt_id);  
            $spt_detail->delete();  
        }

        if ($jenis == 1) {
            return redirect()->route('lihat_data_hotel',['status'=>3]);
        }
        elseif ($jenis == 2) {
            return redirect()->route('lihat_data_resto',['status'=>3]);
        }
        elseif ($jenis == 3) {
            return redirect()->route('lihat_data_hibur',['status'=>3]);
        }
        elseif ($jenis == 4) {
            $getsptdtrek = spt_detailreklame::where('nid_spt',$id_spt)->get();
            foreach ($getsptdtrek as $key) {
                $spt_detail = spt_detailreklame::find($key->nid);  
                $spt_detail->delete();  
            }

            $getnetapajrek = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt)->get();
            foreach ($getnetapajrek as $key) {
                $netapajrek = penetapan_pajak_retribusi::find($key->netapajrek_id);  
                $netapajrek->delete();  
            }

            $tambah_spt = spt::where('spt_periode',$spt->spt_periode)
                                ->where('spt_nomor',$spt->spt_nomor)
                                ->where('spt_kode_rek',48)
                                ->get();
            $id_spt2 = $tambah_spt[0]->spt_id;

            $spt = spt::find($id_spt2);
            $spt->delete();

            $getsptdt = spt_detail::where('spt_dt_id_spt',$id_spt2)->get();
            foreach ($getsptdt as $key) {
                $spt_detail = spt_detail::find($key->spt_dt_id);  
                $spt_detail->delete();  
            }

            $getnetapajrek = penetapan_pajak_retribusi::where('netapajrek_id_spt',$id_spt2)->get();
            foreach ($getnetapajrek as $key) {
                $netapajrek = penetapan_pajak_retribusi::find($key->netapajrek_id);  
                $netapajrek->delete();  
            }

            return redirect()->route('lihat_data_reklame',['status'=>3]);
        }
        elseif ($jenis == 5) {
            $getlistrik = spt_listrik::where('nid_spt',$id_spt)->get();

            foreach ($getlistrik as $key) {
                $spt_listrik = spt_listrik::find($key->nid);  
                $spt_listrik->delete();  
            }
            return redirect()->route('lihat_data_jalan',['status'=>3]);
        }
        elseif ($jenis == 7) {
            return redirect()->route('lihat_data_parkir',['status'=>3]);
        }
        elseif ($jenis == 8) {
            DB::table('penetapan_pajak_retribusi')->where('netapajrek_id_spt',$id_spt)->delete();
            DB::table('spt_airtanah')->where('nid_spt',$id_spt)->delete();
            DB::table('spt_airtanah_volume')->where('nid_spt',$id_spt)->delete();
            return redirect()->route('lihat_data_airtanah',['status'=>3]);
        }
        elseif ($jenis == 9) {
            return redirect()->route('lihat_data_sarang',['status'=>3]);
        }
        elseif ($jenis == 10) {
            DB::table('penetapan_pajak_retribusi')->where('netapajrek_id_spt',$id_spt)->delete();
            
            return redirect()->route('lihat_data_retribusi',['status'=>3]);
        }
    }    
    ## DELETE SPT ##
    ################

    ### REPORT ###

    function cetak_daftar_list(){
        return view('cetak_daftar_list');
    }

    public function cetak_daftar(){
        $korek = kode_rekening::where('korek_rincian','00')->where('korek_objek','!=','')->orderBy('korek_id')->get();
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        $getjabatan = DB::table('ref_jabatan')->get();
        foreach ($getjabatan as $key) {
            $jabatan[$key->ref_jab_id] = $key->ref_jab_nama;
        }
        return view('cetak_daftar_pendataan')->with(compact('korek','pejda','jabatan'));
    }

    public function cetak_daftar_reklame(){
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        $getjabatan = DB::table('ref_jabatan')->get();
        foreach ($getjabatan as $key) {
            $jabatan[$key->ref_jab_id] = $key->ref_jab_nama;
        }
        return view('cetak_daftar_reklame')->with(compact('korek','pejda','jabatan'));
    }

    //DOKUMENTASI dan PENGELOLAAN DATA

    public function cetak_induk_wpwr(){
        $jenis = DB::table('ref_kode_usaha')->orderBy('ref_kodus_id')->get();
        $kecamatan = DB::table('kecamatan')->get();
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }

        return view('cetak_induk_wpwr')->with(compact('jenis','kecamatan','pejda'));
    }

    public function cetak_kembang_wpwr(){
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }

        return view('cetak_kembang_wpwr')->with(compact('pejda'));
    }
    
    public function cetak_list_kembang_wpwr(){
        $jenis = DB::table('ref_kode_usaha')->orderBy('ref_kodus_id')->get();
        $kecamatan = DB::table('kecamatan')->get();
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }

        return view('cetak_list_kembang_wpwr')->with(compact('jenis','kecamatan','pejda'));
    }
    ### END REPORT ###


    ###################
    ## GET CANGKUNEK ##
    //get no spt
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

    //get npwpd
    public function getnpwpd($npwp = null){
        if (is_null($npwp)) {
            $get = v_wp_wr::get();
            return Datatables::of($get)
            ->make(true);
        }else{
            $get = v_wp_wr::where('npwprd',$npwp)->get()->toArray();
            echo json_encode($get);
        }
    }   

    //get npwpd yang non aktif
    public function getnpwpd_tutup($npwp = null){
        if (is_null($npwp)) {
            $get = wp_wr::where('wp_wr_tgl_tutup','!=',null)->orderBy('wp_wr_id','DESC')->get();
            return Datatables::of($get)
            ->make(true);
        }else{
            $get = v_wp_wr::where('wp_wr_status_aktif',false)->where('npwprd',$npwp)->get()->toArray();
            echo json_encode($get);
        }
    }    

    //get rekening yang input manual
    public function getRekening(){
        $jenis = $_GET['jenis'];
        $wilayah = $_GET['wilayah'];
        $getjenisreklame = ref_reklame_jenis::where('nid',$jenis)->get();
        $satuan = $getjenisreklame[0]->cmeasure;

        $id_korek = $getjenisreklame[0]->nid_rekening;
        $getkorek = kode_rekening::find($id_korek);
        $korek_rincian = $getkorek->korek_rincian;
        $korek_sub1 = $getkorek->korek_sub1;
        $korek_nama = $getkorek->korek_nama;
        $korek_persen_tarif = $getkorek->korek_persen_tarif;

        $getbiaya = ref_reklame_biaya::where('nid_wilayah',$wilayah)->where('nid_jenis',$jenis)->get();
        $biaya_dasar = $getbiaya[0]->nbiaya;

        $kirim = array(compact("id_korek","satuan","korek_rincian","korek_sub1","korek_nama","korek_persen_tarif","biaya_dasar"));
        echo json_encode($kirim);
    }

    //get rekening untuk di modal
    public function getrek(){
        $kd_rek = $_GET['kd_rek'];
        $pecah = str_split($kd_rek);
        $korek_tipe = $pecah[0];
        $korek_kelompok = $pecah[1];
        $korek_jenis = $pecah[2];
        $korek_objek = $pecah[3].$pecah[4];

        $query = kode_rekening::where('korek_tipe',$korek_tipe)
                                ->where('korek_kelompok',$korek_kelompok)
                                ->where('korek_jenis',$korek_jenis)
                                ->where('korek_objek',$korek_objek)
                                ->where('korek_rincian','!=','00')
                                ->whereOr('korek_sub1','!=','00')
                                ->orderBy('korek_id')
                                ->select(array('korek_id', 
                                    'korek_tipe',
                                    'korek_kelompok',
                                    'korek_jenis',
                                    'korek_objek',
                                    'korek_rincian',
                                    'korek_sub1',
                                    'korek_nama',
                                    'korek_persen_tarif',
                                    'korek_tarif_dsr',
                                    ));
        
        return Datatables::of($query)
        ->addColumn('kodereken','{{ $korek_tipe.$korek_kelompok.$korek_jenis.$korek_objek}}.{{$korek_rincian}}.{{$korek_sub1}}')
        ->editColumn('korek_tarif_dsr','{{ number_format($korek_tarif_dsr,2,",",".")}}')
        ->make(true);
    }

    // perhitungan reklame
    public function hitungReklame(){
        $nid_wilayah = $_GET['nid_wilayah'];
        $nid_reklame = $_GET['nid_reklame'];
        $getjenis = DB::table('ref_reklame_jenis')->where('nid',$nid_reklame)->get();
        $getkorek = kode_rekening::find($getjenis[0]->nid_rekening);
        $persen_daridb = $getkorek->korek_persen_tarif;

        $panjang = $_GET['panjang'];
        $lebar = $_GET['lebar'];
        $muka = $_GET['muka'];
        $jumlah = $_GET['jumlah'];
        $jangka_waktu = $_GET['jangka_waktu'];
        $korek_persen_tarif = $_GET['korek_persen_tarif'];
        $biaya_dasar = $_GET['biaya_dasar'];

        if ($nid_reklame == 4 || $nid_reklame == 5) {
            $luas = $panjang * $lebar;
            $getrethutang = DB::table('ref_reklame_biaya_ts')->where('nid_reklame',$nid_reklame)
                                ->where('nid_wilayah',$nid_wilayah)
                                ->where('nmin','<',$luas)
                                ->where('nmax','>=',$luas)
                                ->get();
            $ntarif = $getrethutang[0]->ntarif;
            $ntarif = $ntarif * $jumlah * $jangka_waktu;
        }else{
            $ntarif = 0;
        }

        $pajak_terhutang = ($panjang * $lebar * $muka * $jumlah * $jangka_waktu) * $biaya_dasar;
        if ($korek_persen_tarif == '0') {
            $nsr = ($pajak_terhutang * 100)/$persen_daridb;
            $pajak_terhutang = $nsr;
        }else {
            $nsr = ($pajak_terhutang * 100)/$korek_persen_tarif;
        }

        $pajak_terhutang = number_format($pajak_terhutang, 2, ",", ".");
        $nsr = number_format($nsr, 2, ",", ".");
        $ntarif = number_format($ntarif, 2, ",", ".");

        $kirim = array(compact("pajak_terhutang","nsr","ntarif"));
        echo json_encode($kirim);
    }

    // get kode rekening
    public function gantiRek(){
        $korek_rincian = $_GET['korek_rincian'];
        $korek_sub1 = $_GET['korek_sub1'];
        $kd_rek = $_GET['kd_rek'];
        $pecah = str_split($kd_rek);
        $korek_tipe = $pecah[0];
        $korek_kelompok = $pecah[1];
        $korek_jenis = $pecah[2];
        $korek_objek = $pecah[3].$pecah[4];

        $getrek = kode_rekening::where('korek_tipe',$korek_tipe)
                                ->where('korek_kelompok',$korek_kelompok)
                                ->where('korek_jenis',$korek_jenis)
                                ->where('korek_objek',$korek_objek)
                                ->where('korek_rincian',$korek_rincian)
                                ->where('korek_sub1',$korek_sub1)
                                ->get();
        if (empty($getrek)) {
            $getrek = null;
        }
        return json_encode($getrek);
    }

    //hitung air tanah
    public function hitungAirTanah(){
        $volume_m3 = $_GET['volume_m3'];
        $persen = $_GET['persen'];
        $sumur = $_GET['sumur'];
        $kelompok = $_GET['kelompok'];
        $wilayah = $_GET['wilayah'];

        $gettarif = DB::table('ref_air_tanah_tarif')
                        ->where('nid_wilayah',$wilayah)
                        ->where('nid_kelompok',$kelompok)
                        ->get();

        $harga_dasar = $gettarif[0]->ntarif1;

        $jumlah = ($volume_m3 * $harga_dasar * $persen) / 100;

        $jumlah = number_format($jumlah, 2, ",", ".");

        $kirim = array(compact('harga_dasar',"jumlah"));
        echo json_encode($kirim);
    }

    public function getlurah(){
        $camat_id = $_GET['camat_id'];
        $lurah = DB::table('kelurahan')->where('lurah_kecamatan',$camat_id)->get();
        echo json_encode($lurah);
    }
    ## END GET CANGKUNEK ##
    #######################
}
