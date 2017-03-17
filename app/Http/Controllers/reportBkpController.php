<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\setoran_pajak_retribusi;
use App\setoran_pajak_retribusi_self_detail;
use App\kode_rekening;
use DB;
use Auth;
require(base_path('vendor/mpdf/mpdf/')."mpdf.php");

class reportBkpController extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function cetak_sspd(Request $request){
    	// dd($request);

        if ($request->objek_pajak == 4) {
        	$getjenis = DB::table('ref_reklame_jenis')->get();
        	foreach ($getjenis as $key) {
        		$jenis[$key->nid] = $key->cname;
        	}
    		$getdata = setoran_pajak_retribusi::join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id','=','setorpajret_id_penetapan')
                                        ->join('spt','spt.spt_id','=','penetapan_pajak_retribusi.netapajrek_id_spt')
    									->join('kode_rekening','spt.spt_kode_rek','=','kode_rekening.korek_id')
    									->join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
    									->join('keterangan_spt','keterangan_spt.ketspt_id','=','spt_status')
    									->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
				                        ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
				                        ->join('ref_reklame_jenis','ref_reklame_jenis.nid','=','spt_detailreklame.nid_reklame')
				                        ->where('setorpajret_id',$request->setorpajret_id)
    									->get();
    	}else{
    		$getdata = setoran_pajak_retribusi::join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id','=','setorpajret_id_penetapan')
    									->join('spt','spt.spt_id','=','penetapan_pajak_retribusi.netapajrek_id_spt')
                                        ->join('kode_rekening','spt.spt_kode_rek','=','kode_rekening.korek_id')
    									->join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
    									->join('keterangan_spt','keterangan_spt.ketspt_id','=','spt_status')
    									->join('spt_airtanah','spt_airtanah.nid_spt','=','spt.spt_id')
				                        ->join('spt_airtanah_volume','spt_airtanah_volume.nid_spt','=','spt.spt_id')
				                        ->join('ref_air_tanah_kelompok','ref_air_tanah_kelompok.nid','=','spt_airtanah.nid_kelompok')
                                        ->where('setorpajret_id',$request->setorpajret_id)
				                       	->where('norder','1')
    									->get();
    	}
    				// dd($getdata);

        $pecah = explode("/", $request->tgl_setor);
        $tgl_setor = $pecah[2].'-'.$pecah[1].'-'.$pecah[0];

        $pejabat = DB::table('v_pejabat_daerah')->where('pejda_id',$request->bendahara)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();


        ob_start();
        for ($i=0; $i < count($getdata) ; $i++) { 
            echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-top-style: none">PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'<br>
                    DINAS PENDAPATAN, PENGELOLAAN KEUANGAN <br>
                    DAN ASET DAERAH <br>
                    '.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'<br>
                    '.$data_pemerintah[0]->dapemda_no_telp.'</td>';
            echo '<td style="border-top-style: none"><b style="font-size:20px">SSPD</b><br>
                    (SURAT SETORAN PAJAK DAERAH) <br>
                    TAHUN : '.$getdata[$i]->spt_periode.'
                    </td>';
            echo '<td style="border-top-style: none">No Urut<br>
                    '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).' </td>';
            echo '</tr>';
            echo '</table>';

            echo '<div style="border:thin solid #000;border-top-style:none;border-bottom-style:none">';
            echo '<table style="font-size:13px;text-align: left;border-collapse: collapse;width: 100%;">';
            echo '<tr><td style="border-right-style:none;border-style:solid;"><br></td><td style="border-style:none"></td><td style="border-style:none"></td><td style="border-style:none"></td></tr>';
            echo '<tr>';
            echo '<td style="width:5%;border-top-style:none;border-right-style:none;border-bottom-style:none"></td>';
            echo '<td style="width:20%;border-style:none">NAMA</td>';
            echo '<td style="width:5%;text-align:right;border-style:none">:</td>';
            echo '<td style="width:70%;" colspan="6">'.$getdata[$i]->wp_wr_nama.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="width:5%;"></td>';
            echo '<td>ALAMAT</td>';
            echo '<td style="width:5%;text-align:right">:</td>';
            echo '<td  colspan="6">'.$getdata[$i]->wp_wr_almt.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="width:5%;"></td>';
            echo '<td>NPWPD</td>';
            echo '<td style="width:5%;text-align:right">:</td>';
            echo '<td colspan="6">'.$getdata[$i]->npwprd.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="9" height="8"></td>';
            echo '</tr>';
            echo '</table>';

            echo '<table style="font-size:13px;text-align: left;border-collapse: collapse;width: 100%;" border="1">';
            echo '<tr>';
            // echo '<td style="width:5%;border-style:none;"></td>';
            echo '<td colspan="2" style="border-style:none;text-align:center">Menyetor berdasarkan &#42;)</td>';
            echo '<td style="width:5%;text-align:right;border-style:none;">:</td>';
            if ($request->kd_tetap == "SKPD") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="width:20%;border-style:none">SKPD</td>';
            if ($request->kd_tetap == "STPD") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="width:20%;border-style:none">STPD</td>';
            if ($request->kd_tetap == "SKRDT") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="width:21%;border-style:none">SKRDT</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-style:none" colspan="6" height="8"></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="3" style="border-style:none"></td>';
            if ($request->kd_tetap == "SKPDT") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">SKPDT</td>';
            if ($request->kd_tetap == "SPTPD") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">SPTPD</td>';
            if ($request->kd_tetap != "SKPD" && $request->kd_tetap != "STPD" && $request->kd_tetap != "SKRDT" && $request->kd_tetap != "SKPDT" && $request->kd_tetap != "SPTPD" && $request->kd_tetap != "SKRDKB" && $request->kd_tetap != "SKPDKBT" && $request->kd_tetap != "SKRD" && $request->kd_tetap != "SKPDKB") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">Lain-lain</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-style:none" colspan="6" height="8"></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="3" style="border-style:none"></td>';
            if ($request->kd_tetap == "SKPDKB") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">SKPDKB</td>';
            if ($request->kd_tetap == "SKRD") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">SKRD</td>';
            echo '<td style="border-style:none"></td>';
            echo '<td style="border-style:none"></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-style:none" colspan="6" height="8"></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="3" style="border-style:none"></td>';
            if ($request->kd_tetap == "SKPDKBT") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">SKPDKBT</td>';
            if ($request->kd_tetap == "SKRDKB") {
                echo '<td style="width:3%">X</td>';
            }else{
                echo '<td style="width:3%"></td>';
            }
            echo '<td style="border-style:none">SKRDKB</td>';
            echo '<td style="border-style:none"></td>';
            echo '<td style="border-style:none"></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-style:none" colspan="6" height="8"></td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="3" style="border-style:none"></td>';
            echo '<td style="border-style:none" colspan="2">Masa Pajak : '.$this->format_bulan(date("m",strtotime($getdata[$i]->spt_periode_jual1))).'</td>';
            echo '<td style="border-style:none;text-align:center" colspan="2">Tahun : '.$getdata[$i]->spt_periode.'</td>';
            echo '<td style="border-style:none;text-align:center" colspan="2">No. Urut : '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).'</td>';
            echo '</tr>';
            echo '</table>';
            echo "</div>";

            if ($request->objek_pajak == 4) {
                echo '<table style="vertical-align:top;font-size:14px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
                echo '<tr>';
                echo '<td rowspan="11" style="width:5%;border-top-style:none;border-bottom-style:none"></td>';
                echo '<td valign="top" style="width:5%">N O</td>';
                echo '<td valign="top" style="width:75%" colspan="3">U R A I A N</td>';
                echo '<td valign="top" style="width:20%">J U M L A H (Rp)</td>';
                echo '<td rowspan="11" style="width:5%;border-top-style:none;border-bottom-style:none"></td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td rowspan="8">1</td>';
                $per1 = explode("-", $getdata[$i]->spt_periode_jual1);
                $per2 = explode("-", $getdata[$i]->spt_periode_jual2);
                echo '<td style="border-style:none">No. Rek</td>
                        <td style="border-style:none">:</td>
                        <td style="border-style:none">'.$getdata[$i]->korek_tipe.$getdata[$i]->korek_kelompok.$getdata[$i]->korek_jenis.$getdata[$i]->korek_objek.'.'.$getdata[$i]->korek_rincian.'.'.$getdata[$i]->korek_sub1.' - '.$getdata[$i]->korek_nama.'</td>';
                echo '<td rowspan="8" valign="top" style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
                echo '</tr>';
                echo '  <tr>
                            <td style="border-style:none">Reklame</td>
                            <td style="border-style:none">:</td>
                            <td style="border-style:none">'.$jenis[$getdata[$i]->nid_reklame].'</td>
                        </tr>
                            <tr>
                                <td style="border-style:none">Judul</td>
                                <td style="border-style:none">:</td>
                                <td style="border-style:none">'.$getdata[$i]->cnaskah.'</td>
                            </tr>
                            <tr>
                                <td style="border-style:none">Lokasi</td>
                                <td style="border-style:none">:</td>
                                <td style="border-style:none">'.$getdata[$i]->clokasi.'</td>
                            </tr>
                            <tr>
                                <td style="border-style:none">Nilai Sewa</td>
                                <td style="border-style:none">:</td>
                                <td style="border-style:none">'.$getdata[$i]->spt_dt_jumlah.'</td>
                            </tr>
                            <tr>
                                <td style="border-style:none">Ukuran</td>
                                <td style="border-style:none">:</td>
                                <td style="border-style:none"> Panjang : '.$getdata[$i]->npanjang.'m, Lebar '.$getdata[$i]->nlebar.'m, Sisi : '.$getdata[$i]->muka.'muka, <br>
                                    Luas : '.($getdata[$i]->npanjang * $getdata[$i]->nlebar).'m2, Jumlah : '.$getdata[$i]->njumlah.' buah
                                </td>
                            </tr>
                            <tr>
                                <td style="border-style:none">Masa</td>
                                <td style="border-style:none">:</td>
                                <td style="border-style:none">'.$this->format_tanggal($per1[2],$per1[1],$per1[0]).' s.d '.$this->format_tanggal($per2[2],$per2[1],$per2[0]).'</td>
                            </tr>
                            <tr>
                                <td style="border-style:none">Keterangan</td>
                                <td style="border-style:none">:</td>
                                <td style="border-style:none">'.$getdata[$i]->keterangan_pajak.'</td>
                        ';
                echo '</tr>';
     
                echo '<tr>';
                echo '<td colspan="4">Jumlah Ketetapan Pokok Pajak</td>';
                echo '<td style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td colspan="5">Dengan Huruf #'.$this->terbilang($getdata[$i]->spt_pajak).'</td>';
                echo '</tr>';
                echo '</table>';
            }else{
                echo '<table style="vertical-align:top;font-size:14px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
                echo '<tr>';
                echo '<td rowspan="11" style="width:5%;border-top-style:none;border-bottom-style:none"></td>';
                echo '<td valign="top" style="width:5%">N O</td>';
                echo '<td valign="top" style="width:75%" colspan="5">U R A I A N</td>';
                echo '<td valign="top" style="width:20%">J U M L A H (Rp)</td>';
                echo '<td rowspan="11" style="width:5%;border-top-style:none;border-bottom-style:none"></td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td rowspan="7">1</td>';
                $per1 = explode("-", $getdata[$i]->spt_periode_jual1);
                $per2 = explode("-", $getdata[$i]->spt_periode_jual2);
                echo '<td colspan="5" style="border-style:none">'.$getdata[$i]->korek_nama.'</td>';
                echo '<td rowspan="7" valign="top" style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
                echo '</tr>';
                echo '  <tr>
                            <td style="border-style:none">No. Rek</td>
                            <td style="border-style:none">:</td>
                        <td colspan="3" style="border-style:none">'.$getdata[$i]->korek_tipe.$getdata[$i]->korek_kelompok.$getdata[$i]->korek_jenis.$getdata[$i]->korek_objek.'.'.$getdata[$i]->korek_rincian.'.'.$getdata[$i]->korek_sub1.' - '.$getdata[$i]->korek_nama.'</td>
                        </tr>
                        <tr>
                            <td style="border-style:none">SUMUR KE</td>
                            <td style="border-style:none">:</td>
                            <td colspan="3" style="border-style:none">'.$getdata[$i]->nsumur.'</td>
                        </tr>
                        <tr>
                            <td style="border-style:none">Jenis</td>
                            <td style="border-style:none">:</td>
                            <td colspan="3" style="border-style:none">'.$getdata[$i]->cdescription.'</td>
                        </tr>
                            <tr>
                                <td style="border-style:none">Volume</td>
                                <td style="border-style:none">:</td>
                                <td colspan="3" style="border-style:none">'.$getdata[$i]->nvolume.' m3</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border-style:none">Volume m3</td>
                                <td style="border-style:none">Harga</td>
                                <td style="border-style:none">Pajak</td>
                                <td style="border-style:none">Jumlah</td>
                            </tr>
                            <tr>
                                <td colspan="2" style="border-style:none">'.$getdata[$i]->nvolume.'</td>
                                <td style="border-style:none">'.$getdata[$i]->ntarif.'</td>
                                <td style="border-style:none">'.$getdata[$i]->njumlah.'</td>
                                <td style="border-style:none">'.$getdata[$i]->nharga.'</td>
                        ';
                echo '</tr>';
     
                echo '<tr>';
                echo '<td colspan="6">Jumlah Ketetapan Pokok Pajak</td>';
                echo '<td style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
                echo '</tr>';
                echo '</table>';
            }

            echo '<table style="vertical-align:top;font-size:13px;text-align: justify; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-top-style: none;" height="40"></td>';
            echo '</tr>';
            echo '</table>';

            $tgl_tetap = explode("-", $getdata[$i]->netapajrek_tgl);
            
            echo '<table style="text-align: center;margin-left: auto; margin-right: auto;border-collapse: collapse; width: 100%; font-size:12px" align="center" border="1">
                  <tr>
                    <td style="width:50%;border-top-style:none;border-bottom-style:none;">Diterima oleh,</td>
                    <td style="width:50%;text-align: center;border-top-style:none;border-bottom-style:none;">'.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).', '.$this->format_tanggal($tgl_tetap[2],$tgl_tetap[1],$tgl_tetap[0]).'</td>
                  </tr>
                  <tr>
                    <td style="text-align: center;border-top-style:none;border-bottom-style:none;">'.$pejabat[0]->ref_japeda_nama.'</td>
                    <td style="border-top-style:none;border-bottom-style:none;"></td>
                  </tr>            
                  <tr>
                    <td style="border-top-style:none;border-bottom-style:none;">Tanggal : '.$this->format_tanggal($tgl_tetap[2],$tgl_tetap[1],$tgl_tetap[0]).'</td>
                    <td style="border-top-style:none;border-bottom-style:none;">Penyetor,</td>
                  </tr>  
                  <tr>
                    <td style="border-top-style:none;border-bottom-style:none;"><br></br><br></br><br></br><br></br></td>
                    <td style="border-top-style:none;border-bottom-style:none;"><br></br><br></br><br></br><br></br></td>
                  </tr>
                  <tr>
                    <td style="border-top-style:none;border-bottom-style:none;text-align: center"><u><b>'.$pejabat[0]->pejda_nama.'</b></u></td>
                    <td style="border-top-style:none;border-bottom-style:none;text-align: center">('.$getdata[$i]->wp_wr_nama.')</td>
                  </tr>
                  <tr>
                    <td style="border-top-style:none;text-align: center;">NIP . '.$pejabat[0]->pejda_nip.'</td>
                    <td style="border-top-style:none"></td>
                  </tr>
                  </table>';

            echo '<table style="font-size:8px;width:100%" >';
            echo '<tr>';
            echo '<td>Lembar ke 1</td>';
            echo '<td>:</td>';
            echo '<td>WP</td>';
            echo '<td valign="top" rowspan="3" style="font-size:12px;width:80%;text-align:right">User : '.Auth::user()->opr_nama.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Lembar ke 2</td>';
            echo '<td>:</td>';
            echo '<td>BPK</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Lembar ke 3</td>';
            echo '<td>:</td>';
            echo '<td>Pajak & Retribusi</td>';
            echo '</tr>';
            echo '</table>';

            echo '<barcode code="0201655684" type="I25" style="margin-left:0px" />';
            echo '<p style="font-size:9px;margin-top:0px;margin-left:50px">'.$getdata[$i]->spt_periode.$getdata[$i]->spt_nomor.'</p>';
            
        }
        
        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-P');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_skpd.pdf" ,'I');
    }

    public function cetak_sspd_self(Request $request){
        $this->validate($request, [
            'bendahara' => 'required',
        ]);
        // dd($request);

        $getdata = setoran_pajak_retribusi::join('spt','spt.spt_id','=','setorpajret_id_penetapan')
                                    ->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
                                    ->join('kode_rekening','spt.spt_kode_rek','=','kode_rekening.korek_id')
                                    ->join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                                    ->join('keterangan_spt','keterangan_spt.ketspt_id','=','spt_status')
                                    ->where('setorpajret_id',$request->setorpajret_id)
                                    ->get();
        // dd($getdata);

        $pecah = explode("/", $request->tgl_setor);
        $tgl_setor = $pecah[2].'-'.$pecah[1].'-'.$pecah[0];

        $pejabat = DB::table('v_pejabat_daerah')->where('pejda_id',$request->bendahara)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();


        ob_start();
        for ($i=0; $i < count($getdata) ; $i++) { 
            echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-top-style: none"><b>PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'<br>
                    DINAS PENDAPATAN, PENGELOLAAN KEUANGAN DAN ASET <br>
                    DAERAH </b><br>
                    '.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'<br>
                    '.$data_pemerintah[0]->dapemda_no_telp.'</td>';
            echo '<td style="border-top-style: none;border-right-style: none;"><b style="font-size:20px">SSPD</b><br>
                    <b>(SURAT SETORAN PAJAK DAERAH)</b> <br>
                    TAHUN : '.$getdata[$i]->spt_periode.'
                    </td>';
            echo '</table>';

            echo '<div style="border:thin solid #000;border-top-style:none;border-bottom-style:none">';
            echo '<table style="font-size:14px;text-align: left;border-collapse: collapse;width: 100%;">';
            echo '<tr><td style="border-right-style:none;border-style:solid;"><br></td><td style="border-style:none"></td><td style="border-style:none"></td><td style="border-style:none"></td></tr>';
            echo '<tr>';
            echo '<td style="width:5%;border-top-style:none;border-right-style:none;border-bottom-style:none"></td>';
            echo '<td style="width:10%;border-style:none">NAMA</td>';
            echo '<td style="width:5%;text-align:right;border-style:none">:</td>';
            echo '<td style="width:80%;" colspan="6">'.$getdata[$i]->wp_wr_nama.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="width:5%;"></td>';
            echo '<td>ALAMAT</td>';
            echo '<td style="width:5%;text-align:right">:</td>';
            echo '<td  colspan="6">'.$getdata[$i]->wp_wr_almt.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="width:5%;"></td>';
            echo '<td>NPWPD</td>';
            echo '<td style="width:5%;text-align:right">:</td>';
            echo '<td colspan="6">'.$getdata[$i]->npwprd.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td colspan="9" height="8"></td>';
            echo '</tr>';
            echo '</table>';

            echo '<table style="font-size:13px;text-align: left;border-collapse: collapse;width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-style:none;text-align:right;width:50%">Masa Pajak : '.$this->format_bulan(date("m",strtotime($getdata[$i]->spt_periode_jual1))).'</td>';
            echo '<td style="border-style:none;text-align:center">Tahun : '.$getdata[$i]->spt_periode.'</td>';
            echo '<td style="border-style:none;text-align:center">No. Urut : '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).'</td>';
            echo '</tr>';
            echo '</table>';
            echo "</div>";

            echo '<table style="vertical-align:top;font-size:14px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td rowspan="10" style="width:5%;border-top-style:none;border-bottom-style:none"></td>';
            echo '<td valign="top" style="width:5%">N O</td>';
            echo '<td valign="top" style="width:15%">AYAT</td>';
            echo '<td valign="top" style="width:40%">JENIS PAJAK</td>';
            echo '<td valign="top" style="width:15%">OMSET (Rp.)</td>';
            echo '<td valign="top" style="width:15%">J U M L A H (Rp)</td>';
            echo '<td rowspan="10" style="width:5%;border-top-style:none;border-bottom-style:none"></td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td rowspan="4">1</td>';
            $per1 = explode("-", $getdata[$i]->spt_periode_jual1);
            $per2 = explode("-", $getdata[$i]->spt_periode_jual2);
            $korek = DB::table('kode_rekening')
                        ->where('korek_tipe',$getdata[$i]->korek_tipe)
                        ->where('korek_kelompok',$getdata[$i]->korek_kelompok)
                        ->where('korek_jenis',$getdata[$i]->korek_jenis)
                        ->where('korek_objek',$getdata[$i]->korek_objek)
                        ->where('korek_rincian','00')
                        ->get();
            echo '<td rowspan="4">'.$getdata[$i]->korek_tipe.$getdata[$i]->korek_kelompok.$getdata[$i]->korek_jenis.$getdata[$i]->korek_objek.'.'.$getdata[$i]->korek_rincian.'.'.$getdata[$i]->korek_sub1.'</td>';
            echo '<td style="border-style:none">'.$korek[0]->korek_nama.'</td>';
            echo '<td rowspan="4" valign="top" style="text-align:right">'.number_format($getdata[$i]->spt_dt_jumlah,2,',','.').'</td>';
            echo '<td rowspan="4" valign="top" style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
            echo '</tr>';
            echo '  <tr>
                        <td style="border-style:none">Tarif '.$getdata[$i]->spt_dt_persen_tarif.' %</td>
                    </tr>
                    <tr>
                        <td style="border-style:none">Jenis '.$getdata[$i]->korek_nama.'</td>
                    </tr>';
            $per1 = explode("-", $getdata[$i]->spt_periode_jual1);
            $tgl1 = $this->format_tanggal($per1[2],$per1[1],$per1[0]);
            $per2 = explode("-", $getdata[$i]->spt_periode_jual2);
            $tgl2 = $this->format_tanggal($per2[2],$per2[1],$per2[0]);
            echo '  <tr>
                        <td style="border-style:none">Masa Pajak : '.$tgl1.' s/d '.$tgl2.'</td>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                        <br>
                    </tr>';
 
            echo '<tr>';
            echo '<td colspan="4">Jumlah Ketetapan Pokok Pajak</td>';
            echo '<td style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
            echo '</tr>';
            echo '</table>';

            echo '<table style="vertical-align:top;font-size:13px;text-align: justify; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-top-style: none;" height="40"></td>';
            echo '</tr>';
            echo '</table>';

            $tgl_tetap = explode("-", $getdata[$i]->netapajrek_tgl);
            
            echo '<table style="text-align: center;margin-left: auto; margin-right: auto;border-collapse: collapse; width: 100%; font-size:12px" align="center" border="1">
                  <tr>
                    <td style="width:50%;border-top-style:none;border-bottom-style:none;">Diterima oleh,</td>
                    <td style="width:50%;text-align: center;border-top-style:none;border-bottom-style:none;">'.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).', '.$this->format_tanggal($tgl_tetap[2],$tgl_tetap[1],$tgl_tetap[0]).'</td>
                  </tr>
                  <tr>
                    <td style="text-align: center;border-top-style:none;border-bottom-style:none;">'.$pejabat[0]->ref_japeda_nama.'</td>
                    <td style="border-top-style:none;border-bottom-style:none;"></td>
                  </tr>            
                  <tr>
                    <td style="border-top-style:none;border-bottom-style:none;">Tanggal : '.$this->format_tanggal($tgl_tetap[2],$tgl_tetap[1],$tgl_tetap[0]).'</td>
                    <td style="border-top-style:none;border-bottom-style:none;">Penyetor,</td>
                  </tr>  
                  <tr>
                    <td style="border-top-style:none;border-bottom-style:none;"><br></br><br></br><br></br><br></br></td>
                    <td style="border-top-style:none;border-bottom-style:none;"><br></br><br></br><br></br><br></br></td>
                  </tr>
                  <tr>
                    <td style="border-top-style:none;border-bottom-style:none;text-align: center"><u><b>'.$pejabat[0]->pejda_nama.'</b></u></td>
                    <td style="border-top-style:none;border-bottom-style:none;text-align: center">('.$getdata[$i]->wp_wr_nama.')</td>
                  </tr>
                  <tr>
                    <td style="border-top-style:none;text-align: center;">NIP . '.$pejabat[0]->pejda_nip.'</td>
                    <td style="border-top-style:none"></td>
                  </tr>
                  </table>';

            echo '<table style="font-size:8px;width:100%" >';
            echo '<tr>';
            echo '<td>Lembar ke 1</td>';
            echo '<td>:</td>';
            echo '<td>WP</td>';
            echo '<td valign="top" rowspan="3" style="font-size:12px;width:80%;text-align:right">User : '.Auth::user()->opr_nama.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Lembar ke 2</td>';
            echo '<td>:</td>';
            echo '<td>BPK</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>Lembar ke 3</td>';
            echo '<td>:</td>';
            echo '<td>Pajak & Retribusi</td>';
            echo '</tr>';
            echo '</table>';

            echo '<barcode code="0201455684" type="I25" style="margin-left:0px" />';
            echo '<p style="font-size:9px;margin-top:0px;margin-left:50px">'.$getdata[$i]->spt_periode.$getdata[$i]->spt_nomor.'</p>';
            
        }
        
        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-P','','asdads');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_skpd.pdf" ,'I');
    }

    public function bpps(){
        $korek = kode_rekening::where('korek_rincian','00')->where('korek_objek','!=','')->orderBy('korek_id')->get();
        return view('bpps')->with(compact('korek'));
    }

    public function cetak_bpps_rek(Request $request){
        // dd($request);
        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();

        ob_start();

        echo '<table>';
        echo '<tr>';
        echo '<td width="5%">';
        echo '<img src="'.public_path('logo_baru_pekalongan.jpg').'" style="width:70px; heigth:70px;">';
        echo '</td>';
        echo '<td width="95%">';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:16px;">PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:16px;">'.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:16px;">Telp. '.$data_pemerintah[0]->dapemda_no_telp.'</p>';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:16px;">BUKU PEMBANTU PENERIMAAN SEJENIS VIA BENDAHARA PENERIMAAN</p>';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:16px;">TAHUN ANGGARAN '.'</p>';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:14px;">Periode tanggal '.' s/d '.'</p>';
        echo "<br>";

        echo '<table style="font-size:13px;text-align: center;border-collapse: collapse;width: 100%;" border="1">';
        echo '<tr>';
        echo '<td>NO</td>';
        echo '<td>TGL</td>';
        echo '<td>REKENING</td>';
        echo '<td>NO. SPTPD</td>';
        echo '<td>DITERIMA DARI</td>';
        echo '<td>N.P.W.P.D</td>';
        echo '<td>MASA PAJAK</td>';
        echo '<td>JUMLAH</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="8" style="text-align:left">NAMA REKENING : </td>';
        echo '</tr>';


        echo '<tr>';
        echo '<td style="text-align:right" colspan="7">JUMLAH '.'</td>';
        echo '<td>Rp</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="text-align:center" colspan="7"><b>JUMLAH</b></td>';
        echo '<td>Rp</td>';
        echo '</tr>';
        echo '</table>';

        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A3-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_daftar_reklame.pdf" ,'I');
    }

    function terbilang($x, $style=1) {
          if($x<0) {
          $hasil = "minus ". trim($this->kekata($x));
          } else {
          $hasil = trim($this->kekata($x));
          }
          switch ($style) {
          case 1:
          $hasil = strtoupper($hasil);
          break;
          case 2:
          $hasil = strtolower($hasil);
          break;
          case 3:
          $hasil = ucwords($hasil);
          break;
          default:
          $hasil = ucfirst($hasil);
          break;
          }
          $hasil .= " RUPIAH";
          return $hasil;
    }

    function kekata($x) {
          $x = abs($x);
          $angka = array("", "satu", "dua", "tiga", "empat", "lima",
          "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
          $temp = "";
          if ($x <12) {
          $temp = " ". $angka[$x];
          } else if ($x <20) {
          $temp = $this->kekata($x - 10). " belas";
          } else if ($x <100) {
          $temp = $this->kekata($x/10)." puluh". $this->kekata($x % 10);
          } else if ($x <200) {
          $temp = " seratus" . $this->kekata($x - 100);
          } else if ($x <1000) {
          $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
          } else if ($x <2000) {
          $temp = " seribu" . $this->kekata($x - 1000);
          } else if ($x <1000000) {
          $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
          } else if ($x <1000000000) {
          $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
          } else if ($x <1000000000000) {
          $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
          } else if ($x <1000000000000000) {
          $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
          }
          return $temp;

    }

    public function format_tanggal($day,$month,$year){
        $bulan = array( 
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                        );
        $tanggal = $day.' '.$bulan[$month].' '.$year;
        return $tanggal;
    }

    public function format_bulan($month){
        $bulan = array( 
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '01' => 'Januari',
                        '02' => 'Februari',
                        '03' => 'Maret',
                        '04' => 'April',
                        '05' => 'Mei',
                        '06' => 'Juni',
                        '07' => 'Juli',
                        '08' => 'Agustus',
                        '09' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                        );
        $bulan = $bulan[$month];
        return $bulan;
    }
}
