<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use DB;
use Auth;
require(base_path('vendor/mpdf/mpdf/')."mpdf.php");

class reportDaftarController extends Controller
{

    public function __construct(){
    	$this->middleware('auth');
    }

    function generate_pdf() {
        $mpdf = new \Mpdf();
        $mpdf->WriteHTML('<h1>Hello world!</h1>');
        $mpdf->Output();
	   }

    #### PENDATAAN  ######

    function cetak_daftar_pendataan(Request $request){
        $this->validate($request, [
            'korek' => 'required',
            'tgl_data' => 'required',
            'period' => 'required',
            'tgl_cetak' => 'required',
            'mengetahui' => 'required',
            'diperiksa' => 'required',
        ]);
        $getkorek = DB::table('kode_rekening')->where('korek_id',$request->korek)->get();

        $pecah = explode("/", $request->tgl_data);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
        $getspt = DB::table('spt')
                    ->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
                    ->join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->where('spt.spt_tgl_proses',$tgl)
                    ->where('kode_rekening.korek_tipe',$getkorek[0]->korek_tipe)
                    ->where('kode_rekening.korek_kelompok',$getkorek[0]->korek_kelompok)
                    ->where('kode_rekening.korek_jenis',$getkorek[0]->korek_jenis)
                    ->where('kode_rekening.korek_objek',$getkorek[0]->korek_objek)
                    ->get();

        $mengetahui = DB::table('v_pejabat_daerah')->where('pejda_id',$request->mengetahui)->get();
        $diperiksa = DB::table('v_pejabat_daerah')->where('pejda_id',$request->diperiksa)->get();

        $getjabatan = DB::table('ref_jabatan')->get();
        foreach ($getjabatan as $key) {
            $jabatan[$key->ref_jab_id] = $key->ref_jab_nama;
        }

        ob_start();

        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">CETAK KARTU DATA '.$getkorek[0]->korek_nama.'</p>';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN : '.$request->period.'</p>';
        echo "<br>";
        echo '<p style="margin:0px; padding:0px;">Nama Rekening : '.$getkorek[0]->korek_nama.' ('.$getkorek[0]->korek_tipe.'.'.$getkorek[0]->korek_kelompok.'.'.$getkorek[0]->korek_jenis.'.'.$getkorek[0]->korek_objek.')</p>';
        
        echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1" align="center">
                          <tr>
                              <th rowspan="2">NO</th>
                              <th colspan="2">S P T P D</th>
                              <th rowspan="2" width="20%">Wajib Pajak / Pemilik</th>
                              <th rowspan="2" width="20%">Alamat</th>
                              <th rowspan="2">N P W P D</th>
                              <th rowspan="2">Masa Pajak</th>
                              <th rowspan="2">Tarif (%)</th>
                              <th rowspan="2">Omzet (Rp)</th>
                          </tr>
                          <tr>
                            <th>Tanggal</th>
                            <th>No. Urut</th>
                          </tr>';
        echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        $no = 1;
        foreach ($getspt as $key) {
            echo  "<tr>
                    <td>
                        ".$no++."
                    </td>
                    <td>
                        ".date("d-m-Y", strtotime($tgl))."
                    </td>
                    <td>
                        ".$key->spt_nomor."
                    </td>
                    <td>
                        ".$key->wp_wr_nama."
                    </td>
                    <td>
                        ".$key->wp_wr_almt."
                    </td>
                    <td>
                        ".$key->npwprd."
                    </td>
                    <td>
                        ".date("d-m-Y", strtotime($key->spt_periode_jual1))." s/d ".date("d-m-Y", strtotime($key->spt_periode_jual2))."
                    </td>
                    <td>
                        ".$key->spt_dt_persen_tarif."
                    </td>
                    <td>
                        ".number_format($key->spt_dt_jumlah,2,',','.')."
                    </td>
                  </tr>";
        }
        echo '<tr>
                <td colspan="5" style="text-align:left; font-size:13px;border-right-style:none">
                TANGGAL PENDATAAN : '.date("d-m-Y", strtotime($tgl)).'
                </td>
                <td colspan="4" style="text-align:left; font-size:13px;border-left-style:none">
                 TANGGAL TERIMA OLEH PENETAPAN : '.'
                </td>
              </tr>';
        echo "<tr><td colspan='9'></td></tr>";
        echo "</table>";

        echo '<br></br>
              <table style="margin-left: auto; margin-right: auto; width: 100%; font-size:12px" align="center">
              <tr>
                <td style="text-align: center;">Mengetahui</td>
                <td style="text-align: center;">Diperiksa Oleh</td>
                <td rowspan="3">
                    <table>
                        <tr>
                        <td>Tanggal Cetak</td>
                        <td>:</td>
                        <td>'.$request->tgl_cetak.'</td>
                        </tr>
                        <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>'.Auth::user()->opr_nama.'</td>
                        </tr>
                        <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>'.$jabatan[Auth::user()->opr_jabatan].'</td>
                        </tr>
                    </table>
                </td>
              </tr>
              <tr>
              <td style="text-align: center;">a.n. Kepala Dinas Pendapatan Daerah Pengelolaan Keuangan</td>
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_japeda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_japeda_nama.'</td>
                <td></td>
              </tr>  
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><br></br><br></br><br></br><br></br></td>
                <td><br></br><br></br><br></br><br></br></td>
              </tr>
              <tr>
                <td style="text-align: center"><u>'.$mengetahui[0]->pejda_nama.'</u></td>
                <td style="text-align: center"><u>'.$diperiksa[0]->pejda_nama.'</u></td>
                <td style="text-align: left">Tanda Tangan : .................................</td>
              </tr>              
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pangpej_ket.'</td>
                <td style="text-align: center;">'.$diperiksa[0]->ref_pangpej_ket.'</td>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <td style="text-align: center;">NIP . '.$mengetahui[0]->pejda_nip.'</td>
                <td style="text-align: center;">NIP . '.$diperiksa[0]->pejda_nip.'</td>
                <td style="text-align: left;"></td>
              </tr>
              </table>';
              // echo "<pagebreak />";

        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_daftar_pendataan.pdf" ,'I');
    }

    function cetak_daftar_reklame(Request $request){
        $this->validate($request, [
            'tgl_data' => 'required',
            'period' => 'required',
            'tgl_cetak' => 'required',
            'mengetahui' => 'required',
            'diperiksa' => 'required',
        ]);
        $getkorek = DB::table('kode_rekening')->where('korek_id',18)->get();

        $pecah = explode("/", $request->tgl_data);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
        $getspt = DB::table('spt')
                    ->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
                    ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
                    ->join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->where('spt.spt_tgl_proses',$tgl)
                    ->where('kode_rekening.korek_tipe',$getkorek[0]->korek_tipe)
                    ->where('kode_rekening.korek_kelompok',$getkorek[0]->korek_kelompok)
                    ->where('kode_rekening.korek_jenis',$getkorek[0]->korek_jenis)
                    ->where('kode_rekening.korek_objek',$getkorek[0]->korek_objek)
                    ->get();

        $mengetahui = DB::table('v_pejabat_daerah')->where('pejda_id',$request->mengetahui)->get();
        $diperiksa = DB::table('v_pejabat_daerah')->where('pejda_id',$request->diperiksa)->get();

        $getjabatan = DB::table('ref_jabatan')->get();
        foreach ($getjabatan as $key) {
            $jabatan[$key->ref_jab_id] = $key->ref_jab_nama;
        }

        ob_start();

        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">CETAK KARTU DATA '.$getkorek[0]->korek_nama.'</p>';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold;">TAHUN : '.$request->period.'</p>';
        echo "<br>";
        echo '<p style="margin:0px; padding:0px;">Nama Rekening : '.$getkorek[0]->korek_nama.' ('.$getkorek[0]->korek_tipe.'.'.$getkorek[0]->korek_kelompok.'.'.$getkorek[0]->korek_jenis.'.'.$getkorek[0]->korek_objek.')</p>';
        
        echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1" align="center">
                          <tr style="line-height:50px">
                              <th rowspan="2">NO</th>
                              <th rowspan="2" width="15%">NPWPD /<br> No. Urut SPT</th>
                              <th rowspan="2" width="25%">Nama WP /<br> A l a m a t</th>
                              <th rowspan="2" width="20%">Judul Reklame /<br> Lokasi Pemasangan</th>
                              <th colspan="5">Rincian</th>
                              <th rowspan="2">Tarif (%)</th>
                              <th rowspan="2">Masa Berlaku<br> Reklame</th>
                          </tr>
                          <tr>
                            <th>Panjang</th>
                            <th>Lebar</th>
                            <th>Muka / Luas</th>
                            <th>Jumlah</th>
                            <th>Nilai Sewa Reklame</th>
                          </tr>';
        echo "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
        $no = 1;
        foreach ($getspt as $key) {
            echo  "<tr>
                    <td>
                        ".$no++."
                    </td>
                    <td>
                        ".$key->npwprd.' / '.$key->spt_nomor."
                    </td>
                    <td>
                        ".$key->wp_wr_nama.' / '.$key->wp_wr_almt."
                    </td>
                    <td>
                        ".$key->cnaskah.' / '.$key->clokasi."
                    </td>
                    <td>
                        ".$key->npanjang."
                    </td>
                    <td>
                        ".$key->nlebar."
                    </td>
                    <td>
                        ".$key->nmuka."
                    </td>
                    <td>
                        ".$key->njumlah."
                    </td>
                    <td>
                        ".number_format($key->spt_dt_jumlah,2,',','.')."
                    </td>
                    <td>
                        ".$key->spt_dt_persen_tarif."
                    </td>
                    <td>
                        ".date("d-m-Y", strtotime($key->spt_periode_jual1))." s/d ".date("d-m-Y", strtotime($key->spt_periode_jual2))."
                    </td>
                  </tr>";
        }
        echo '<tr>
                <td colspan="4" style="text-align:left; font-size:13px;border-right-style:none">
                TANGGAL PENDATAAN : '.date("d-m-Y", strtotime($tgl)).'
                </td>
                <td colspan="7" style="text-align:left; font-size:13px;border-left-style:none">
                 TANGGAL TERIMA OLEH PENETAPAN : '.'
                </td>
              </tr>';
        echo "<tr><td colspan='11'></td></tr>";
        echo "</table>";

        echo '<br></br>
              <table style="margin-left: auto; margin-right: auto; width: 100%; font-size:12px" align="center">
              <tr>
                <td style="text-align: center;">Mengetahui</td>
                <td style="text-align: center;">Diperiksa Oleh</td>
                <td rowspan="3">
                    <table>
                        <tr>
                        <td>Tanggal Cetak</td>
                        <td>:</td>
                        <td>'.$request->tgl_cetak.'</td>
                        </tr>
                        <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>'.Auth::user()->opr_nama.'</td>
                        </tr>
                        <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>'.$jabatan[Auth::user()->opr_jabatan].'</td>
                        </tr>
                    </table>
                </td>
              </tr>
              <tr>
              <td style="text-align: center;">a.n. Kepala Dinas Pendapatan Daerah Pengelolaan Keuangan</td>
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_japeda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_japeda_nama.'</td>
                <td></td>
              </tr>  
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><br></br><br></br><br></br><br></br></td>
                <td><br></br><br></br><br></br><br></br></td>
              </tr>
              <tr>
                <td style="text-align: center"><u>'.$mengetahui[0]->pejda_nama.'</u></td>
                <td style="text-align: center"><u>'.$diperiksa[0]->pejda_nama.'</u></td>
                <td style="text-align: left">Tanda Tangan : .................................</td>
              </tr>              
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pangpej_ket.'</td>
                <td style="text-align: center;">'.$diperiksa[0]->ref_pangpej_ket.'</td>
                <td style="text-align: left;"></td>
              </tr>
              <tr>
                <td style="text-align: center;">NIP . '.$mengetahui[0]->pejda_nip.'</td>
                <td style="text-align: center;">NIP . '.$diperiksa[0]->pejda_nip.'</td>
                <td style="text-align: left;"></td>
              </tr>
              </table>';

        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_daftar_reklame.pdf" ,'I');
    }

    ### END PENDATAAN ###

    ### DOKUMENTASI ###
    public function cetak_induk_wpwr(Request $request){
        $this->validate($request, [
            'tgl_data' => 'required',
            'tgl_cetak' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            'usaha' => 'required',
            'golongan' => 'required',
            // 'jenis' => 'required',
            'mengetahui' => 'required',
            'diperiksa' => 'required',
        ]);

        $pecah = explode("/", $request->tgl_data);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
        $pecah3 = explode("/", $request->tgl_cetak);
        $tgl_cetak= $pecah3[2].'-'.$pecah3[1].'-'.$pecah3[0];

        $getusaha = DB::table('ref_kode_usaha')->where('ref_kodus_id',$request->usaha)->get();
        $gol['p'] = 'PAJAK';
        $gol['r'] = 'RETRIBUSI';

        $kecamatan = DB::table('kecamatan')->where('camat_id',$request->kecamatan)->get();
        $kelurahan = DB::table('kelurahan')->where('lurah_id',$request->kelurahan)->get();

        $mengetahui = DB::table('v_pejabat_daerah')->where('pejda_id',$request->mengetahui)->get();
        $diperiksa = DB::table('v_pejabat_daerah')->where('pejda_id',$request->diperiksa)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();
        if ($request->jenis == "") {
            $whereRaw = 'wp_wr_jenis = '."'".$request->golongan."'";
        }else{
            $whereRaw = 'wp_wr_jenis = '."'".$request->golongan."'".' AND wp_wr_gol = '.$request->jenis;
        }

        $getdata = DB::table('v_wp_wr')
                        ->where('wp_wr_tgl_kartu','<=',$tgl)
                        ->where('wp_wr_camat',$kecamatan[0]->camat_nama)
                        ->where('wp_wr_lurah',$kelurahan[0]->lurah_nama)
                        ->whereRaw($whereRaw)
                        ->where('wp_wr_bidang_usaha','LIKE','%'.$request->usaha.'%')
                        ->get();

        ob_start();

        echo '<table>';
        echo '<tr>';
        echo '<td width="5%">';
        echo '<img src="'.public_path('logo_baru_pekalongan.jpg').'" style="width:70px; heigth:70px;">';
        echo '</td>';
        echo '<td width="25%">';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:10px;">PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:10px;">'.strtoupper($data_pemerintah[0]->nama_dinas).'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:10px;">'.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:10px;">Telp. '.$data_pemerintah[0]->dapemda_no_telp.'</p>';
        echo '</td>';
        echo '<td  width="40%" align="center">';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:16px;">DAFTAR INDUK WAJIB '.$gol[$request->golongan].' '.strtoupper($getusaha[0]->ref_kodus_nama).'</p>';
        echo "<br>";
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:12px">Keadaan s/d tanggal '.$this->format_tanggal($pecah[0],$pecah[1],$pecah[2]).'</p>';
        echo '</td>';
        echo '<td  width="30%"></td>';
        echo '</tr>';
        echo '</table>';

        echo "<br>";
        echo '<p style="margin:0px; padding:0px; font-size:11px">Kecamatan : '.$kecamatan[0]->camat_nama.' &nbsp;&nbsp;&nbsp;&nbsp; Kelurahan : '.$kelurahan[0]->lurah_nama.'</p>';
        
        echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1" align="center">
                          <tr style="line-height:50px">
                              <th rowspan="2">NO</th>
                              <th colspan="2" width="25%">Pengukuhan</th>
                              <th rowspan="2" width="25%">Nama</th>
                              <th rowspan="2" width="30%">Alamat Lengkap</th>
                              <th rowspan="2">NPWPD</th>
                              <th rowspan="2">Keterangan</th>
                          </tr>
                          <tr>
                            <th>Tanggal</th>
                            <th>Nomor</th>
                          </tr>';
        echo "<tr><td colspan='7' align='left' style='font-weight:bold;'>Kelurahan ".$kelurahan[0]->lurah_nama."</td></tr>";
        $mandum_usaha = DB::table('ref_kode_usaha')->get();
        foreach ($mandum_usaha as $key) {
            $bdg_usaha[$key->ref_kodus_id] = $key->ref_kodus_nama;
        }
        
        $no = 1;
        foreach ($getdata as $key) {
            $usaha = explode("::", $key->wp_wr_bidang_usaha);
            $hasil = '';
            $count = count($usaha);
            $x=0;
            foreach ($usaha as $bu => $value) {
                $hasil .= $bdg_usaha[$value].'';
                $x++;
                if ($count != $x) {
                    $hasil .= ', ';
                }
            }
            echo  "<tr>
                    <td>
                        ".$no++."
                    </td>
                    <td>
                        ".date('d-m-Y', strtotime($key->wp_wr_tgl_kartu))."
                    </td>
                    <td>
                        ".$key->wp_wr_no_kartu."
                    </td>
                    <td>
                        ".$key->wp_wr_nama."
                    </td>
                    <td>
                        ".$key->wp_wr_almt."
                    </td>
                    <td>
                        ".$key->npwprd."
                    </td>
                    <td>
                        ".$hasil."
                    </td>
                  </tr>";
        }
        echo "</table>";

        echo '<br></br>
              <table style="margin-left: auto; margin-right: auto; width: 100%; font-size:12px" align="center">
              <tr>
                <td style="text-align: center;">Mengetahui</td>
                <td style="text-align: center;">'.$data_pemerintah[0]->dapemda_ibu_kota.', '.$this->format_tanggal($pecah3[0],$pecah3[1],$pecah3[2]).'</td>
              </tr>
              <tr>
              <td style="text-align: center;">a.n. Kepala Dinas Pendapatan Daerah Pengelolaan Keuangan</td>
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_japeda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_japeda_nama.'</td>
                <td></td>
              </tr>  
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><br></br><br></br><br></br><br></br></td>
                <td><br></br><br></br><br></br><br></br></td>
              </tr>
              <tr>
                <td style="text-align: center"><u>'.$mengetahui[0]->pejda_nama.'</u></td>
                <td style="text-align: center"><u>'.$diperiksa[0]->pejda_nama.'</u></td>
              </tr>              
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pangpej_ket.'</td>
                <td style="text-align: center;">'.$diperiksa[0]->ref_pangpej_ket.'</td>
              </tr>
              <tr>
                <td style="text-align: center;">NIP . '.$mengetahui[0]->pejda_nip.'</td>
                <td style="text-align: center;">NIP . '.$diperiksa[0]->pejda_nip.'</td>
              </tr>
              </table>';

        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A3-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_daftar_reklame.pdf" ,'I');
    }

    public function cetak_kembang_wpwr(Request $request){
        $this->validate($request, [
            'tgl_data1' => 'required',
            'tgl_data2' => 'required',
            'tgl_cetak' => 'required',
            'mengetahui' => 'required',
            'diperiksa' => 'required',
        ]);

        $pecah = explode("/", $request->tgl_data1);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
        $pecah2 = explode("/", $request->tgl_data2);
        $tgl2= $pecah2[2].'-'.$pecah2[1].'-'.$pecah2[0];
        $pecah3 = explode("/", $request->tgl_cetak);
        $tgl_cetak= $pecah3[2].'-'.$pecah3[1].'-'.$pecah3[0];

        $kecamatan = DB::table('kecamatan')->get();

        $mengetahui = DB::table('v_pejabat_daerah')->where('pejda_id',$request->mengetahui)->get();
        $diperiksa = DB::table('v_pejabat_daerah')->where('pejda_id',$request->diperiksa)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();
        
        ob_start();
        
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:16px;">DAFTAR PERKEMBANGAN WAJIB PAJAK DAERAH SE-KOTA PEKALONGAN</p>';
        echo "<br>";
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:12px">(Keadaan '.$this->format_tanggal($pecah[0],$pecah[1],$pecah[2]).' s.d '.$this->format_tanggal($pecah2[0],$pecah2[1],$pecah2[2]).')</p>';
        echo "<br>";
        
        echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1" align="center">
                          <tr style="line-height:50px">
                              <th rowspan="2">NO</th>
                              <th rowspan="2" width="15%">Badan / Kecamatan</th>
                              <th colspan="2">Hotel</th>
                              <th colspan="2">Restoran</th>
                              <th colspan="2">Hiburan</th>
                              <th colspan="2">PPJ</th>
                              <th colspan="2">Parkir</th>
                              <th colspan="2">Air Tanah</th>
                              <th colspan="2">Minerba</th>
                              <th colspan="2">Reklame</th>
                              <th colspan="2">Walet</th>
                              <th colspan="2">Kekayaan Daerah</th>
                              <th rowspan="2" width="10%">Jumlah</th>
                          </tr>
                          <tr>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                            <th>Lama</th>
                            <th>Baru</th>
                          </tr>';
        echo "<tr>";
        for ($i=1; $i <= 23; $i++) { 
            echo "<td>".$i."</td>";
        }
        echo "</tr>";
        
        $no = 1;
        foreach ($kecamatan as $key) {
            $hotel = 1;
            $gethotel_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$hotel.'%');
            $gethotel_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$hotel.'%');
            if ($gethotel_lama->count() == 0) {
                $hotel_lama = "-";
            }else{
                $hotel_lama = $gethotel_lama->count().' WP';
            }
            if ($gethotel_baru->count() == 0) {
                $hotel_baru = "-";
            }else{
                $hotel_baru = $gethotel_baru->count().' WP';
            }
            $resto = 2;
            $getresto_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$resto.'%');
            $getresto_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$resto.'%');
            if ($getresto_lama->count() == 0) {
                $resto_lama = "-";
            }else{
                $resto_lama = $getresto_lama->count().' WP';
            }
            if ($getresto_baru->count() == 0) {
                $resto_baru = "-";
            }else{
                $resto_baru = $getresto_baru->count().' WP';
            }

            $rek = 4;
            $getrek_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$rek.'%');
            $getrek_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$rek.'%');
            if ($getrek_lama->count() == 0) {
                $rek_lama = "-";
            }else{
                $rek_lama = $getrek_lama->count().' WP';
            }
            if ($getrek_baru->count() == 0) {
                $rek_baru = "-";
            }else{
                $rek_baru = $getrek_baru->count().' WP';
            }
            $ppj = 5;
            $getppj_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$ppj.'%');
            $getppj_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$ppj.'%');
            if ($getppj_lama->count() == 0) {
                $ppj_lama = "-";
            }else{
                $ppj_lama = $getppj_lama->count().' WP';
            }
            if ($getppj_baru->count() == 0) {
                $ppj_baru = "-";
            }else{
                $ppj_baru = $getppj_baru->count().' WP';
            }
            $minerba = 6;
            $getminerba_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$minerba.'%');
            $getminerba_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$minerba.'%');
            if ($getminerba_lama->count() == 0) {
                $minerba_lama = "-";
            }else{
                $minerba_lama = $getminerba_lama->count().' WP';
            }
            if ($getminerba_baru->count() == 0) {
                $minerba_baru = "-";
            }else{
                $minerba_baru = $getminerba_baru->count().' WP';
            }
            $parkir = 7;
            $getparkir_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$parkir.'%');
            $getparkir_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$parkir.'%');
            if ($getparkir_lama->count() == 0) {
                $parkir_lama = "-";
            }else{
                $parkir_lama = $getparkir_lama->count().' WP';
            }
            if ($getparkir_baru->count() == 0) {
                $parkir_baru = "-";
            }else{
                $parkir_baru = $getparkir_baru->count().' WP';
            }
            $airtanah = 8;
            $getairtanah_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$airtanah.'%');
            $getairtanah_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$airtanah.'%');
            if ($getairtanah_lama->count() == 0) {
                $airtanah_lama = "-";
            }else{
                $airtanah_lama = $getairtanah_lama->count().' WP';
            }
            if ($getairtanah_baru->count() == 0) {
                $airtanah_baru = "-";
            }else{
                $airtanah_baru = $getairtanah_baru->count().' WP';
            }
            $walet = 9;
            $getwalet_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$walet.'%');
            $getwalet_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$walet.'%');
            if ($getwalet_lama->count() == 0) {
                $walet_lama = "-";
            }else{
                $walet_lama = $getwalet_lama->count().' WP';
            }
            if ($getwalet_baru->count() == 0) {
                $walet_baru = "-";
            }else{
                $walet_baru = $getwalet_baru->count().' WP';
            }
            $ret = 30;
            $getret_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$ret.'%');
            $getret_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$ret.'%');
            if ($getret_lama->count() == 0) {
                $ret_lama = "-";
            }else{
                $ret_lama = $getret_lama->count();
            }
            if ($getret_baru->count() == 0) {
                $ret_baru = "-";
            }else{
                $ret_baru = $getret_baru->count();
            }
            $hibur = 3;
            $gethibur_lama = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','<',$tgl)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$hibur.'%')
                            ->where('wp_wr_bidang_usaha','NOT LIKE','%'.$ret.'%');
            $gethibur_baru = DB::table('v_wp_wr')
                            ->where('wp_wr_tgl_kartu','>=',$tgl)
                            ->where('wp_wr_tgl_kartu','<=',$tgl2)
                            ->where('wp_wr_camat',$key->camat_nama)
                            ->where('wp_wr_bidang_usaha','LIKE','%'.$hibur.'%')
                            ->where('wp_wr_bidang_usaha','NOT LIKE','%'.$ret.'%');
            if ($gethibur_lama->count() == 0) {
                $hibur_lama = "-";
            }else{
                $hibur_lama = $gethibur_lama->count().' WP';
            }

            if ($gethibur_baru->count() == 0) {
                $hibur_baru = "-";
            }else{
                $hibur_baru = $gethibur_baru->count().' WP';
            }

            $jumlah_samping = $gethotel_lama->count() + $gethotel_baru->count() + $getresto_lama->count() + $getresto_baru->count() + $gethibur_lama->count() + $gethibur_baru->count() + $getrek_lama->count() + $getrek_baru->count() + $getppj_lama->count() + $getppj_baru->count() + $getminerba_lama->count() + $getminerba_baru->count() + $getparkir_lama->count() + $getparkir_baru->count() + $getairtanah_lama->count() + $getairtanah_baru->count() + $getwalet_lama->count() + $getwalet_baru->count() + $getret_lama->count() + $getret_baru->count() + 
            
            $jumlah_hotel_lama += $gethotel_lama->count();
            $jumlah_hotel_baru += $gethotel_baru->count();
            $jumlah_resto_lama += $getresto_lama->count();
            $jumlah_resto_baru += $getresto_baru->count();
            $jumlah_hibur_lama += $gethibur_lama->count();
            $jumlah_hibur_baru += $gethibur_baru->count();
            $jumlah_rek_lama += $getrek_lama->count();
            $jumlah_rek_baru += $getrek_baru->count();
            $jumlah_ppj_lama += $getppj_lama->count();
            $jumlah_ppj_baru += $getppj_baru->count();
            $jumlah_minerba_lama += $getminerba_lama->count();
            $jumlah_minerba_baru += $getminerba_baru->count();
            $jumlah_parkir_lama += $getparkir_lama->count();
            $jumlah_parkir_baru += $getparkir_baru->count();
            $jumlah_airtanah_lama += $getairtanah_lama->count();
            $jumlah_airtanah_baru += $getairtanah_baru->count();
            $jumlah_walet_lama += $getwalet_lama->count();
            $jumlah_walet_baru += $getwalet_baru->count();
            $jumlah_ret_lama += $getret_lama->count();
            $jumlah_ret_baru += $getret_baru->count();
            echo  "<tr>
                    <td>
                        ".$no++."
                    </td>
                    <td>
                        ".$key->camat_nama."
                    </td>
                    <td>
                        ".$hotel_lama."
                    </td>
                    <td>
                        ".$hotel_baru." 
                    </td>
                    <td>
                        ".$resto_lama."
                    </td>
                    <td>
                        ".$resto_baru."
                    </td>
                    <td>
                        ".$hibur_lama."
                    </td>
                    <td>
                        ".$hibur_baru."
                    </td>
                    <td>
                        ".$ppj_lama."
                    </td>
                    <td>
                        ".$ppj_baru."
                    </td>
                    <td>
                        ".$parkir_lama."
                    </td>
                    <td>
                        ".$parkir_baru."
                    </td>
                    <td>
                        ".$airtanah_lama."
                    </td>
                    <td>
                        ".$airtanah_baru."
                    </td>
                    <td>
                        ".$minerba_lama."
                    </td>
                    <td>
                        ".$minerba_baru."
                    </td>
                    <td>
                        ".$rek_lama."
                    </td>
                    <td>
                        ".$rek_baru."
                    </td>
                    <td>
                        ".$walet_lama."
                    </td>
                    <td>
                        ".$walet_baru."
                    </td>
                    <td>
                        ".$ret_lama."
                    </td>
                    <td>
                        ".$ret_baru."
                    </td>
                    <td>
                        ".$jumlah_samping." WP/WR
                    </td>
                  </tr>";
        }
        echo "<tr>
                <td colspan='2'>JUMLAH</td>
                <td>".$jumlah_hotel_lama." WP</td>
                <td>".$jumlah_hotel_baru." WP</td>
                <td>".$jumlah_resto_lama." WP</td>
                <td>".$jumlah_resto_baru." WP</td>
                <td>".$jumlah_hibur_lama." WP</td>
                <td>".$jumlah_hibur_baru." WP</td>
                <td>".$jumlah_rek_lama." WP</td>
                <td>".$jumlah_rek_baru." WP</td>
                <td>".$jumlah_ppj_lama." WP</td>
                <td>".$jumlah_ppj_baru." WP</td>
                <td>".$jumlah_minerba_lama." WP</td>
                <td>".$jumlah_minerba_baru." WP</td>
                <td>".$jumlah_parkir_lama." WP</td>
                <td>".$jumlah_parkir_baru." WP</td>
                <td>".$jumlah_airtanah_lama." WP</td>
                <td>".$jumlah_airtanah_baru." WP</td>
                <td>".$jumlah_walet_lama." WP</td>
                <td>".$jumlah_walet_baru." WP</td>
                <td>".$jumlah_ret_lama."</td>
                <td>".$jumlah_ret_baru."</td>
                <td></td>
            </tr>";

        $jumlah_total = ($jumlah_hotel_lama+$jumlah_hotel_baru) + ($jumlah_resto_lama+$jumlah_resto_baru) + ($jumlah_hibur_lama+$jumlah_hibur_baru) + ($jumlah_rek_lama+$jumlah_rek_baru) + ($jumlah_ppj_lama+$jumlah_ppj_baru) + ($jumlah_minerba_lama+$jumlah_minerba_baru) + ($jumlah_parkir_lama+$jumlah_parkir_baru) + ($jumlah_airtanah_lama+$jumlah_airtanah_baru) + ($jumlah_walet_lama+$jumlah_walet_baru) + ($jumlah_ret_lama+$jumlah_ret_baru);

        echo "<tr>
                <td colspan='2'>JUMLAH TOTAL</td>
                <td colspan='2'>".($jumlah_hotel_lama+$jumlah_hotel_baru)." WP</td>
                <td colspan='2'>".($jumlah_resto_lama+$jumlah_resto_baru)." WP</td>
                <td colspan='2'>".($jumlah_hibur_lama+$jumlah_hibur_baru)." WP</td>
                <td colspan='2'>".($jumlah_rek_lama+$jumlah_rek_baru)." WP</td>
                <td colspan='2'>".($jumlah_ppj_lama+$jumlah_ppj_baru)." WP</td>
                <td colspan='2'>".($jumlah_minerba_lama+$jumlah_minerba_baru)." WP</td>
                <td colspan='2'>".($jumlah_parkir_lama+$jumlah_parkir_baru)." WP</td>
                <td colspan='2'>".($jumlah_airtanah_lama+$jumlah_airtanah_baru)." WP</td>
                <td colspan='2'>".($jumlah_walet_lama+$jumlah_walet_baru)." WP</td>
                <td colspan='2'>".($jumlah_ret_lama+$jumlah_ret_baru)." WP/WR</td>
                <td style='font-weight:bold'><i>".$jumlah_total." WP</i></td>
            </tr>";
        echo "</table>";

        echo '<br></br>
              <table style="margin-left: auto; margin-right: auto; width: 100%; font-size:12px" align="center">
              <tr>
                <td style="text-align: center;">Mengetahui</td>
                <td style="text-align: center;">'.$data_pemerintah[0]->dapemda_ibu_kota.', '.$this->format_tanggal($pecah3[0],$pecah3[1],$pecah3[2]).'</td>
              </tr>
              <tr>
              <td style="text-align: center;">a.n. Kepala Dinas Pendapatan Daerah Pengelolaan Keuangan</td>
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_japeda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_japeda_nama.'</td>
                <td></td>
              </tr>  
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><br></br><br></br><br></br><br></br></td>
                <td><br></br><br></br><br></br><br></br></td>
              </tr>
              <tr>
                <td style="text-align: center"><u>'.$mengetahui[0]->pejda_nama.'</u></td>
                <td style="text-align: center"><u>'.$diperiksa[0]->pejda_nama.'</u></td>
              </tr>              
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pangpej_ket.'</td>
                <td style="text-align: center;">'.$diperiksa[0]->ref_pangpej_ket.'</td>
              </tr>
              <tr>
                <td style="text-align: center;">NIP . '.$mengetahui[0]->pejda_nip.'</td>
                <td style="text-align: center;">NIP . '.$diperiksa[0]->pejda_nip.'</td>
              </tr>
              </table>';

        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_daftar_reklame.pdf" ,'I');
    }

    public function cetak_list_kembang_wpwr(Request $request){
        $this->validate($request, [
            'tgl_data' => 'required',
            'tgl_data2' => 'required',
            'tgl_cetak' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
            // 'usaha' => 'required',
            // 'golongan' => 'required',
            // 'jenis' => 'required',
            'mengetahui' => 'required',
            'diperiksa' => 'required',
        ]);

        $pecah = explode("/", $request->tgl_data);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];
        $pecah2 = explode("/", $request->tgl_data2);
        $tgl2= $pecah2[2].'-'.$pecah2[1].'-'.$pecah2[0];
        $pecah3 = explode("/", $request->tgl_cetak);
        $tgl_cetak= $pecah3[2].'-'.$pecah3[1].'-'.$pecah3[0];

        $gol['p'] = 'PAJAK';
        $gol['r'] = 'RETRIBUSI';

        $kecamatan = DB::table('kecamatan')->where('camat_id',$request->kecamatan)->get();
        $kelurahan = DB::table('kelurahan')->where('lurah_id',$request->kelurahan)->get();

        $mengetahui = DB::table('v_pejabat_daerah')->where('pejda_id',$request->mengetahui)->get();
        $diperiksa = DB::table('v_pejabat_daerah')->where('pejda_id',$request->diperiksa)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();
        $whereRaw = "wp_wr_lurah = '".$kelurahan[0]->lurah_nama."'";

        if ($request->jenis != "") {
            $whereRaw = ' AND wp_wr_gol = '.$request->jenis;
        }

        if ($request->golongan != "") {
            $whereRaw .= ' AND wp_wr_jenis LIKE %'.$request->golongan.'%';
        }

        if ($request->usaha != "") {
            $whereRaw .= ' AND wp_wr_bidang_usaha LIKE %'.$request->usaha.'%';
        }

        $getdata = DB::table('v_wp_wr')
                        ->where('wp_wr_tgl_kartu','>=',$tgl)
                        ->where('wp_wr_tgl_kartu','<=',$tgl2)
                        ->where('wp_wr_camat',$kecamatan[0]->camat_nama)
                        ->where('wp_wr_lurah',$kelurahan[0]->lurah_nama)
                        ->whereRaw($whereRaw)
                        ->get();

        ob_start();

        echo '<img src="'.public_path('logo_baru_pekalongan.jpg').'" style="width:70px; heigth:70px;">';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:8px;">PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:8px;">'.strtoupper($data_pemerintah[0]->nama_dinas).'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:8px;">'.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'</p>';
        echo '<p align="left" style="margin:0px; margin-bottom:5px; padding:0px; font-size:8px;">Telp. '.$data_pemerintah[0]->dapemda_no_telp.'</p>';
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:16px;">DAFTAR INDUK WAJIB</p>';
        echo "<br>";
        echo '<p align="center" style="margin:0px; padding:0px; font-weight:bold; font-size:12px">Keadaan '.$this->format_tanggal($pecah[0],$pecah[1],$pecah[2]).' s/d tanggal '.$this->format_tanggal($pecah2[0],$pecah2[1],$pecah2[2]).'</p>';
        echo "<br>";
        echo '<p style="margin:0px; padding:0px; font-size:11px">Kecamatan : '.$kecamatan[0]->camat_nama.'</p>';
        
        echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1" align="center">
                          <tr style="line-height:50px">
                              <th rowspan="2">NO</th>
                              <th colspan="2" width="25%">Pengukuhan</th>
                              <th rowspan="2" width="25%">Nama</th>
                              <th rowspan="2" width="30%">Alamat Lengkap</th>
                              <th rowspan="2">NPWPD</th>
                              <th rowspan="2">Keterangan</th>
                          </tr>
                          <tr>
                            <th>Tanggal</th>
                            <th>Nomor</th>
                          </tr>';
        echo "<tr><td colspan='7' align='left' style='font-weight:bold;'>Kelurahan ".$kelurahan[0]->lurah_nama."</td></tr>";
        $mandum_usaha = DB::table('ref_kode_usaha')->get();
        foreach ($mandum_usaha as $key) {
            $bdg_usaha[$key->ref_kodus_id] = $key->ref_kodus_nama;
        }
        
        $no = 1;
        foreach ($getdata as $key) {
            $usaha = explode("::", $key->wp_wr_bidang_usaha);
            $hasil = '';
            $count = count($usaha);
            $x=0;
            foreach ($usaha as $bu => $value) {
                $hasil .= $bdg_usaha[$value].'';
                $x++;
                if ($count != $x) {
                    $hasil .= ', ';
                }
            }
            echo  "<tr>
                    <td>
                        ".$no++."
                    </td>
                    <td>
                        ".date('d-m-Y', strtotime($key->wp_wr_tgl_kartu))."
                    </td>
                    <td>
                        ".$key->wp_wr_no_kartu."
                    </td>
                    <td>
                        ".$key->wp_wr_nama."
                    </td>
                    <td>
                        ".$key->wp_wr_almt."
                    </td>
                    <td>
                        ".$key->npwprd."
                    </td>
                    <td>
                        ".$hasil."
                    </td>
                  </tr>";
        }
        echo "</table>";

        echo '<br></br>
              <table style="margin-left: auto; margin-right: auto; width: 100%; font-size:12px" align="center">
              <tr>
                <td style="text-align: center;">Mengetahui</td>
                <td style="text-align: center;">'.$data_pemerintah[0]->dapemda_ibu_kota.', '.$this->format_tanggal($pecah3[0],$pecah3[1],$pecah3[2]).'</td>
              </tr>
              <tr>
              <td style="text-align: center;">a.n. Kepala Dinas Pendapatan Daerah Pengelolaan Keuangan</td>
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_japeda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_japeda_nama.'</td>
                <td></td>
              </tr>  
              <tr>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <td><br></br><br></br><br></br><br></br></td>
                <td><br></br><br></br><br></br><br></br></td>
              </tr>
              <tr>
                <td style="text-align: center"><u>'.$mengetahui[0]->pejda_nama.'</u></td>
                <td style="text-align: center"><u>'.$diperiksa[0]->pejda_nama.'</u></td>
              </tr>              
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pangpej_ket.'</td>
                <td style="text-align: center;">'.$diperiksa[0]->ref_pangpej_ket.'</td>
              </tr>
              <tr>
                <td style="text-align: center;">NIP . '.$mengetahui[0]->pejda_nip.'</td>
                <td style="text-align: center;">NIP . '.$diperiksa[0]->pejda_nip.'</td>
              </tr>
              </table>';

        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_daftar_reklame.pdf" ,'I');
    }
    ### END DOKUMENTASI ###

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

}
