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
use DB;
use Datatables;
use Auth;

class Pendataan extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

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
            return view('sptpd_hiburan')->with(compact('status'));
        }
        elseif ($id_pajak == 4) {
            $wilayah = ref_reklame_wilayah::get();
            $jenis_reklame = ref_reklame_jenis::orderBy('nid','asc')->get();
    		return view('sptpd_reklame')->with(compact("wilayah","jenis_reklame",'status'));
    	}
        elseif ($id_pajak == 5) {
            return view('sptpd_penerangan')->with(compact('status'));
        }
        elseif ($id_pajak == 7) {
            return view('sptpd_parkir')->with(compact('status'));
        }
        elseif ($id_pajak == 8) {
            return view('sptpd_airtanah')->with(compact('status'));
        }
        elseif ($id_pajak == 9) {
            return view('sptpd_sarang')->with(compact('status'));
        }
        elseif ($id_pajak == 10) {
            return view('sptpd_retribusi')->with(compact('status'));
        }
    }

    public function editSptpd($id_spt,$id_pajak,$status=''){
        if ($id_pajak == 1) {
            return view('sptpd_hotel')->with(compact('status'));
        }
        elseif ($id_pajak == 2) {
            return view('sptpd_restoran')->with(compact('status'));
        }
        elseif ($id_pajak == 4) {
            $wilayah = ref_reklame_wilayah::get();
            $jenis_reklame = ref_reklame_jenis::orderBy('nid','asc')->get();
            return view('sptpd_reklame')->with(compact("id_spt","wilayah","jenis_reklame",'status'));
        }
    }

    public function store_data_reklame(Request $request){
        $this->validate($request, [

        ]);
        echo "tes<pre>";
        // print_r($request->id_korek);die;
        $tgl = explode("/", $request->pajak_awal);
        $pajak_awal  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->pajak_akhir);
        $pajak_akhir  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];
        $tgl = explode("/", $request->tgl_entry);
        $tgl_entry  = $tgl[2].'-'.$tgl[1].'-'.$tgl[0];

        $pajak_terhutang = str_replace(".", "", $request->pajak_terhutang);
        $pajak_terhutang = str_replace(",00", "", $pajak_terhutang);
        $nsr = str_replace(".", "", $request->nsr);
        $nsr = str_replace(",00", "", $nsr);

        $spt = new spt;
        $spt->spt_periode = date("Y");
        $spt->spt_nomor = $request->noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "1";  //MASIH BELUM TAU DARI MANA????????
        $spt->spt_pajak = $pajak_terhutang;
        $spt->spt_operator = Auth::user()->opr_id;
        $spt->spt_jenis_pajakretribusi = "4"; //Pajak Reklame !!
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
        // $spt_detail->spt_dt_tarif_dasar = "0"; //i did not know!!
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->save();

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

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>4, 'status'=>1]);
    }

    public function store_data_hotel(Request $request){
        $this->validate($request, [

        ]);
        echo "tes<pre>";
        // print_r($request->id_korek);die;
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
        $spt->spt_nomor = $request->noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //MASIH BELUM TAU DARI MANA????????
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
        // $spt_detail->spt_dt_tarif_dasar = "0"; //i did not know!!
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>1, 'status'=>1]);
    }

    public function store_data_resto(Request $request){
        $this->validate($request, [

        ]);
        echo "tes<pre>";
        // print_r($request->id_korek);die;
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
        $spt->spt_nomor = $request->noreg;
        $spt->spt_kode_rek = $request->id_korek;
        $spt->spt_periode_jual1 = $pajak_awal;
        $spt->spt_periode_jual2 = $pajak_akhir;
        $spt->spt_status = "8";  //MASIH BELUM TAU DARI MANA????????
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
        // $spt_detail->spt_dt_tarif_dasar = "0"; //i did not know!!
        $spt_detail->spt_dt_persen_tarif = $request->korek_persen_tarif;
        $spt_detail->spt_dt_pajak = $pajak_terhutang;
        $spt_detail->save();

        return redirect()->route('editSptpd',['id_spt'=>$spt->spt_id, 'id_pajak'=>2, 'status'=>1]);
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

    //upper(c.wp_wr_jenis)||'.'||c.wp_wr_gol||'.'||c.wp_wr_no_urut||'.'||d.camat_kode||'.'||e.lurah_kode as npwprd,f.ref_bulan_nama||" "||EXTRACT(YEAR FROM spt.spt_periode_jual1) as masa_pajak,

    public function gethistory_hotel($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
                    ->join('ref_reklame_jenis','ref_reklame_jenis.nid','=','spt_detailreklame.nid_reklame')
                    ->join('ref_reklame_wilayah','ref_reklame_wilayah.nid','=','spt_detailreklame.nid_wilayah')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah', 
                                    'ref_reklame_jenis.cname as jenis', 
                                    'ref_reklame_wilayah.cname as wilayah', 
                                    'spt.spt_tgl_proses',
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
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('spt_tgl_proses','{{ date("d M Y", strtotime($spt_tgl_proses))}}')
        ->addColumn('keterangan','{{ $cnaskah }} ({{ $npanjang }}m x {{ $nlebar }}m x {{ $nmuka }}muka x {{ $njumlah }} unit), {{ $clokasi }}')
        ->removeColumn('spt_periode_jual2')
        ->removeColumn('cnaskah')
        ->removeColumn('npanjang')
        ->removeColumn('nlebar')
        ->removeColumn('nmuka')
        ->removeColumn('njumlah')
        ->removeColumn('clokasi')
        ->make(true);
        // return Datatables::queryBuilder(DB::table('spt'))->make(true);

    }

    public function gethistory_reklame($wp_wr_id){
        $query = spt::join('spt_detail','spt.spt_id','=','spt_detail.spt_dt_id_spt')
                    ->join('wp_wr','wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
                    ->join('ref_reklame_jenis','ref_reklame_jenis.nid','=','spt_detailreklame.nid_reklame')
                    ->join('ref_reklame_wilayah','ref_reklame_wilayah.nid','=','spt_detailreklame.nid_wilayah')
                    ->where('spt.spt_idwpwr',$wp_wr_id)
                    ->select(array('spt.spt_id', 
                                    'spt.spt_nomor', 
                                    'spt.spt_periode_jual1', 
                                    'spt.spt_periode_jual2', 
                                    'spt.spt_pajak',
                                    'spt_detail.spt_dt_jumlah', 
                                    'ref_reklame_jenis.cname as jenis', 
                                    'ref_reklame_wilayah.cname as wilayah', 
                                    'spt.spt_tgl_proses',
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
        ->editColumn('spt_pajak','{{ number_format($spt_pajak,2,",",".")}}')
        ->editColumn('spt_tgl_proses','{{ date("d M Y", strtotime($spt_tgl_proses))}}')
        ->addColumn('keterangan','{{ $cnaskah }} ({{ $npanjang }}m x {{ $nlebar }}m x {{ $nmuka }}muka x {{ $njumlah }} unit), {{ $clokasi }}')
        ->removeColumn('spt_periode_jual2')
        ->removeColumn('cnaskah')
        ->removeColumn('npanjang')
        ->removeColumn('nlebar')
        ->removeColumn('nmuka')
        ->removeColumn('njumlah')
        ->removeColumn('clokasi')
        ->make(true);
        // return Datatables::queryBuilder(DB::table('spt'))->make(true);

    }

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

    public function hitungReklame(){
        $panjang = $_GET['panjang'];
        $lebar = $_GET['lebar'];
        $muka = $_GET['muka'];
        $jumlah = $_GET['jumlah'];
        $jangka_waktu = $_GET['jangka_waktu'];
        $korek_persen_tarif = $_GET['korek_persen_tarif'];
        $biaya_dasar = $_GET['biaya_dasar'];

        $pajak_terhutang = ($panjang * $lebar * $muka * $jumlah * $jangka_waktu) * $biaya_dasar;
        $nsr = ($pajak_terhutang * 100)/$korek_persen_tarif;

        $pajak_terhutang = number_format($pajak_terhutang, 2, ",", ".");
        $nsr = number_format($nsr, 2, ",", ".");

        $kirim = array(compact("pajak_terhutang","nsr"));
        echo json_encode($kirim);
    }

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
}
