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
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_pejda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pejda_nama.'</td>
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
        $mpdf->Output("rekap_per_rekening2.pdf" ,'I');
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
              <td style="text-align: center;" rowspan="2">'.$diperiksa[0]->ref_pejda_nama.'</td>
              </tr>            
              <tr>
                <td style="text-align: center;">'.$mengetahui[0]->ref_pejda_nama.'</td>
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
        $mpdf->Output("rekap_per_rekening2.pdf" ,'I');
    }

    ### END PENDATAAN ###


}
