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
            $wilayah = ref_reklame_wilayah::get();
            $jenis_reklame = ref_reklame_jenis::orderBy('nid','asc')->get();
    		return view('sptpd_reklame')->with(compact("wilayah","jenis_reklame"));
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

    public function gethistory($wp_wr_id){
        ### Masih Bingung Tabel apa yang dipake ##
        $query = DB::table("SELECT dt.nid
                    FROM spt spt
                    LEFT JOIN spt_detail b ON spt.spt_id=b.spt_dt_id_spt 
                    LEFT JOIN wp_wr c ON spt.spt_idwpwr=c.wp_wr_id 
                    LEFT JOIN kecamatan d ON c.wp_wr_kd_camat::text = d.camat_id::text 
                    LEFT JOIN kelurahan e ON c.wp_wr_kd_lurah::text = e.lurah_id::text 
                    LEFT JOIN ref_bulan f ON EXTRACT(MONTH FROM spt.spt_periode_jual1)=f.ref_bulan_id
                    LEFT JOIN penetapan_pajak_retribusi h ON spt.spt_id=h.netapajrek_id_spt 
                    LEFT JOIN setoran_pajak_retribusi g ON h.netapajrek_id=g.setorpajret_id_penetapan and g.setorpajret_jenis_ketetapan=1
                    LEFT JOIN kode_rekening kr on kr.korek_id=spt.spt_kode_rek 
                    LEFT JOIN spt_detailreklame dt ON spt.spt_id = dt.nid_spt
                    LEFT JOIN ref_reklame_wilayah wil ON dt.nid_wilayah = wil.nid
                    LEFT JOIN ref_reklame_jenis rj ON dt.nid_reklame = rj.nid
                    where  h.netapajrek_id IS NOT NULL and 
                    spt.spt_idwpwr =".$wp_wr_id);
        return Datatables::queryBuilder($query)
            ->make(true);
        // return Datatables::queryBuilder(DB::table('spt'))->make(true);

    }

    public function getRekening(){
        $jenis = $_GET['jenis'];
        $wilayah = $_GET['wilayah'];
        $getjenisreklame = ref_reklame_jenis::where('nid',$jenis)->get();
        $satuan = $getjenisreklame[0]->cmeasure;

        $getkorek = kode_rekening::find($getjenisreklame[0]->nid_rekening);
        $korek_rincian = $getkorek->korek_rincian;
        $korek_sub1 = $getkorek->korek_sub1;
        $korek_nama = $getkorek->korek_nama;
        $korek_persen_tarif = $getkorek->korek_persen_tarif;

        $getbiaya = ref_reklame_biaya::where('nid_wilayah',$wilayah)->where('nid_jenis',$jenis)->get();
        $biaya_dasar = $getbiaya[0]->nbiaya;

        $kirim = array(compact("satuan","korek_rincian","korek_sub1","korek_nama","korek_persen_tarif","biaya_dasar"));
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
}
