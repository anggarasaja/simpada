<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Universal;

use Illuminate\Http\Request;
use Setting;
use Datatables;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\spt;
require(base_path('vendor/mpdf/mpdf/')."mpdf.php");
use Auth;
use Excel;

class Penetapan extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

	public function daftarSPT(){
		return view('daftarSPT');
	}

    public function cetak_daftarSPT(Request $request){
        $jenis = DB::table('ref_kode_usaha')->orderBy('ref_kodus_id')->get();
        $ketetapan = DB::table('keterangan_spt')->where("ketspt_id","!=","8")->get();
        $kecamatan = DB::table('kecamatan')->get();
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }


        // return view('cetak_list_kembang_wpwr')3
        // dd($request->session()->all());
        // $session_user = $request->session()->get('user');
        $nama_opr = Auth::user()->opr_nama;
        
        $jabatan_opr = DB::table('ref_jabatan')->where("ref_jab_id",Auth::user()->opr_jabatan)->first();;
        // $jabatan_opr = ;
        // echo $jabatan_opr->ref_jab_nama;
        // exit;


        return view('cetak_daftar_spt')->with(compact('jenis','kecamatan','pejda','ketetapan','session_user', 'nama_opr','jabatan_opr'));
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

    public function ketetapan(){
        return view('ketetapan');
    }

    public function skpd(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id','!=',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skpd')->with(compact('jenis','pejda'));
    }

    public function skrd(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skrd')->with(compact('jenis','pejda'));
    }

    public function skpdkb(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skpdkb')->with(compact('jenis','pejda'));
    }

    public function skrdkb(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skrdkb')->with(compact('jenis','pejda'));
    }

    public function skpdt(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skpdt')->with(compact('jenis','pejda'));
    }

    public function skpdlb(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skpdlb')->with(compact('jenis','pejda'));
    }

    public function skrdt(){
        $getjenis = DB::table('ref_jenis_pajak_retribusi')->where('ref_jenparet_id',10)->orderBy('ref_jenparet_id')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->ref_jenparet_id] = $key->ref_jenparet_ket;
        }
        $getpejda = DB::select('select * from v_pejabat_daerah');
        foreach ($getpejda as $key) {
            $pejda[$key->pejda_id] = $key->ref_japeda_nama.' - '.$key->pejda_nama;
        }
        return view('skrdt')->with(compact('jenis','pejda'));
    }

    public function getkohir(){
        $tahun = $_GET['period_spt'];
        $objek_pajak = $_GET['objek_pajak'];
        $get = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
                    ->join('keterangan_spt','keterangan_spt.ketspt_id','=','spt.spt_status')
                    ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                    // ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                    ->where('spt.spt_jenis_pajakretribusi',$objek_pajak) 
                    ->where('spt.spt_periode',$tahun) 
                    // ->whereRaw('penetapan_pajak_retribusi.netapajrek_id NOT IN ( SELECT setoran_pajak_retribusi.setorpajret_id_penetapan
                    //                FROM setoran_pajak_retribusi
                    //               WHERE setoran_pajak_retribusi.setorpajret_id_penetapan IS NOT NULL AND setoran_pajak_retribusi.setorpajret_jenis_ketetapan <> 8::smallint)') 
                    ->orderBy('spt_id','DESC')
                    ->get();

        return Datatables::of($get)
        ->edit_column('spt_pajak','@if($spt_pajak == "") 0
                                            @else {{ $spt_pajak }}
                                            @endif
                                            ')
        ->add_column('periode','<center>{{ date("Y",strtotime($netapajrek_tgl)) }}</center>')
        ->add_column('masa_pajak','{{ $spt_periode_jual1 }} s/d {{ $spt_periode_jual2 }}')
        ->make(true);
    }

    public function cetak_daftar_spt_pdf(Request $request){
        // dd($request);
        $this->validate($request,[
                'jenis_ketetapan' => 'required',
                'objek_pajak' => 'required',
                'tgl_awal' => 'required',
                'tgl_akhir' => 'required',
                'tgl_cetak' => 'required',
                'periode_spt' => 'required',
                'mengetahui' => 'required',
                'diperiksa' => 'required',
                'button_val' => 'required',
                'operator' => 'required',
                'jabatan' => 'required',
            ]);
        $jenis_ketetapan = $request->jenis_ketetapan;
        $objek_pajak = $request->objek_pajak;
        $tgl_awal = $request->tgl_awal;
        $tgl_awal_arr = explode("/",$tgl_awal);
        $tgl_awal_conv = $tgl_awal_arr[2]."-".$tgl_awal_arr[1]."-".$tgl_awal_arr[0];

        $tgl_akhir = $request->tgl_akhir;
        $tgl_akhir_arr = explode("/",$tgl_akhir);
        $tgl_akhir_conv = $tgl_akhir_arr[2]."-".$tgl_akhir_arr[1]."-".$tgl_akhir_arr[0];

        $tgl_cetak = $request->tgl_cetak;
        $tgl_cetak_arr = explode("/",$tgl_cetak);
        $tgl_cetak_conv = $tgl_cetak_arr[2]."-".$tgl_cetak_arr[1]."-".$tgl_cetak_arr[0];

        $periode_spt = $request->periode_spt;
        $mengetahui = $request->mengetahui;
        $diperiksa = $request->diperiksa;
        $button_val = $request->button_val;
        $operator = $request->operator;
        $jabatan = $request->jabatan;
        // dd($button_val);
        // echo $tgl_akhir_conv;
        // exit;
        $mengetahui = DB::select(DB::raw("SELECT * FROM v_pejabat_daerah WHERE pejda_id='$mengetahui'"));
        $pemeriksa = DB::select(DB::raw("SELECT * FROM v_pejabat_daerah WHERE pejda_id='$diperiksa'"));
        $ar_objek_pajak = DB::select(DB::raw("SELECT * FROM ref_jenis_pajak_retribusi WHERE ref_jenparet_id='".$objek_pajak."'")); 
        $arr_jenis_ketetapan = DB::select(DB::raw("SELECT * FROM keterangan_spt WHERE ketspt_id='".$jenis_ketetapan."'"));
        // dd($ar_objek_pajak);
        // print_r($ar_objek_pajak);
        // exit
        $sql = "SELECT aaa.netapajrek_tgl,aaa.netapajrek_kohir,aaa.netapajrek_besaran as denda, aaa.netapajrek_jenis_ketetapan,
                       ccc.wp_wr_nama,ccc.wp_wr_almt,ccc.npwprd,
                       bbb.spt_pajak,bbb.spt_periode_jual1, bbb.spt_periode_jual2, bbb.spt_jenis_pajakretribusi, bbb.spt_id,
                       kr.korek_nama, dt.*,wil.cname as reklame_wilayah, rj.cname as reklame_jenis
                FROM penetapan_pajak_retribusi aaa 
                LEFT JOIN spt bbb ON aaa.netapajrek_id_spt=bbb.spt_id
                LEFT JOIN v_wp_wr ccc ON bbb.spt_idwpwr=ccc.wp_wr_id
                LEFT JOIN kode_rekening as kr on kr.korek_id=bbb.spt_kode_rek
                LEFT JOIN spt_detailreklame as dt ON bbb.spt_id = dt.nid_spt
                LEFT JOIN ref_reklame_wilayah wil ON dt.nid_wilayah = wil.nid
                LEFT JOIN ref_reklame_jenis rj ON dt.nid_reklame = rj.nid
                WHERE aaa.netapajrek_jenis_ketetapan='".$jenis_ketetapan."' AND 
                      bbb.spt_jenis_pajakretribusi='".$objek_pajak."' AND 
                      aaa.netapajrek_tgl BETWEEN '".$tgl_awal_conv."' AND '".$tgl_akhir_conv."'";

        if($periode_spt != '') $sql.=" and bbb.spt_periode=".$periode_spt;
        $sql.=" ORDER BY bbb.spt_periode,aaa.netapajrek_kohir";          
        $rs = DB::select(DB::raw($sql));
        // dd($rs);     
        $universal = new Universal();
        $pemda = $universal->getPEMDA();
        if($button_val == "excel"){
            
            // print_r($pemda[0]->dapemda_id);
            // dd($pemda);
            // exit;
            
            Excel::create('New file', function($excel) use($rs,$pemda,$mengetahui,$pemeriksa,$ar_objek_pajak,$arr_jenis_ketetapan,$tgl_awal_conv,$tgl_akhir_conv,$tgl_cetak_conv, $operator, $jabatan,$button_val) {

                $excel->sheet('New sheet', function($sheet) use($rs,$pemda,$mengetahui,$pemeriksa,$ar_objek_pajak,$arr_jenis_ketetapan,$tgl_awal_conv,$tgl_akhir_conv,$tgl_cetak_conv, $operator, $jabatan,$button_val) {
                    // dd($rs);
                    $sheet->loadView('daftar_spt_excel')->with(compact('rs','pemda','mengetahui','pemeriksa','ar_objek_pajak','arr_jenis_ketetapan','tgl_awal_conv','tgl_akhir_conv','tgl_cetak_conv','operator', 'jabatan','button_val'));

                });

            })->download('xls');

            // return view('daftar_spt_excel')->with(compact('rs'));
        } else if($button_val == "pdf"){
            echo "pdf nanti";

            $html = view('daftar_spt_excel')->with(compact('rs','pemda','mengetahui','pemeriksa','ar_objek_pajak','arr_jenis_ketetapan','tgl_awal_conv','tgl_akhir_conv','tgl_cetak_conv','operator', 'jabatan','button_val'));

            $mpdf=new \Mpdf('utf-8', 'Legal-L');
            $mpdf->setFooter('{PAGENO} / {nb}');
            $mpdf->WriteHTML(utf8_encode($html));

            $mpdf->Output("cetak_daftar_spt.pdf" ,'I');
        } else {
            abort(404);
        }
    }

    public function cetak_skpd(Request $request){
        // dd($request);

        $pecah = explode("/", $request->tgl_tetap);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];

        $pejabat = DB::table('v_pejabat_daerah')->where('pejda_id',$request->pejabat)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();

        if ($request->objek_pajak == 4) {
            $getjenis = DB::table('ref_reklame_jenis')->get();
            foreach ($getjenis as $key) {
                $jenis[$key->nid] = $key->cname;
            }

            $getdata = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                        ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                        ->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
                        ->join('spt_detailreklame','spt_detailreklame.nid_spt','=','spt.spt_id')
                        ->join('ref_reklame_jenis','ref_reklame_jenis.nid','=','spt_detailreklame.nid_reklame')
                        ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                        ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                        ->where('spt.spt_jenis_pajakretribusi',$request->objek_pajak) 
                        ->where('spt.spt_periode',$request->tahun)
                        ->get();
        }else{
            $getdata = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                        ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                        ->join('spt_airtanah','spt_airtanah.nid_spt','=','spt.spt_id')
                        ->join('spt_airtanah_volume','spt_airtanah_volume.nid_spt','=','spt.spt_id')
                        ->join('ref_air_tanah_kelompok','ref_air_tanah_kelompok.nid','=','spt_airtanah.nid_kelompok')
                        ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                        ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                        ->where('spt.spt_jenis_pajakretribusi',$request->objek_pajak) 
                        ->where('spt.spt_periode',$request->tahun)
                        ->get();
        }
        // dd($getdata);

        ob_start();
        for ($i=0; $i < count($getdata) ; $i++) { 
            echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-top-style: none">PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'<br>
                    DINAS PENDAPATAN, PENGELOLAAN KEUANGAN <br>
                    DAN ASET DAERAH <br>
                    '.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'<br>
                    '.$data_pemerintah[0]->dapemda_no_telp.'</td>';
            echo '<td style="border-top-style: none"><b style="font-size:20px">SKPD</b><br>
                    (SURAT KETETAPAN PAJAK DAERAH) <br>
                    MASA : '.date('F',strtotime($getdata[$i]->spt_periode_jual1)).' <br>
                    TAHUN : '.$getdata[$i]->spt_periode.'
                    </td>';
            echo '<td style="border-top-style: none">No Urut<br>
                    '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).' </td>';
            echo '</tr>';
            echo '</table>';

            echo "<br>";
            echo '<table style="font-size:13px;text-align: left;" border="0">';
            echo '<tr>';
            echo '<td>NAMA</td>';
            echo '<td>:</td>';
            echo '<td>'.$getdata[$i]->wp_wr_nama.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>ALAMAT</td>';
            echo '<td>:</td>';
            echo '<td>'.$getdata[$i]->wp_wr_almt.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>NPWPD</td>';
            echo '<td>:</td>';
            echo '<td>'.$getdata[$i]->npwprd.'</td>';
            echo '</tr>';
            echo '</table>';

            echo "<br>";
            echo '<table style="font-size:12px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="0">';
            echo '<tr>';
            $jth_tempo = explode("-", $getdata[$i]->netapajrek_tgl_jatuh_tempo);
            echo '<td>Tanggal Jatuh Tempo : '.$this->format_tanggal($jth_tempo[2],$jth_tempo[1],$jth_tempo[0]).'</td>';
            echo '<td style="text-align: right;">No Urut: '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).'</td>';
            echo '</tr>';
            echo '</table>';

            if ($request->objek_pajak == 4) {
                echo '<table style="vertical-align:top;font-size:14px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
                echo '<tr>';
                echo '<td valign="top" style="width:5%">N O</td>';
                echo '<td valign="top" style="width:75%" colspan="3">U R A I A N</td>';
                echo '<td valign="top" style="width:20%">J U M L A H (Rp)</td>';
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
                echo '</table>';
            }else{
                echo '<table style="vertical-align:top;font-size:14px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
                echo '<tr>';
                echo '<td valign="top" style="width:5%">N O</td>';
                echo '<td valign="top" style="width:15%">AYAT</td>';
                echo '<td valign="top" style="width:65%" colspan="5">U R A I A N</td>';
                echo '<td valign="top" style="width:20%">J U M L A H (Rp)</td>';
                echo '</tr>';

                echo '<tr>';
                echo '<td rowspan="6">1</td>';
                $per1 = explode("-", $getdata[$i]->spt_periode_jual1);
                $per2 = explode("-", $getdata[$i]->spt_periode_jual2);
                echo '<td rowspan="6">'.$getdata[$i]->korek_tipe.'.'.$getdata[$i]->korek_kelompok.'.'.$getdata[$i]->korek_jenis.'.'.$getdata[$i]->korek_objek.' - '.$getdata[$i]->korek_rincian.' - '.$getdata[$i]->korek_sub1.'</td>';
                echo '<td colspan="5" style="border-style:none">'.$getdata[$i]->korek_nama.'</td>';
                echo '<td rowspan="6" valign="top" style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
                echo '</tr>';
                echo '  <tr>
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
                echo '<td colspan="7">Jumlah Ketetapan Pokok Pajak</td>';
                echo '<td style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
                echo '</tr>';
                echo '</table>';
            }
            echo '<p align="left" style="margin:0px; margin-top:5px; margin-bottom:5px; padding:0px; font-size:13px;">Dengan huruf</p>';
            echo '<p align="left" style="margin:0px; margin-bottom:10px; padding:0px; font-size:13px;"><b>'.$this->terbilang($getdata[$i]->spt_pajak).'</b></p>';
            
            echo '<table style="vertical-align:top;font-size:13px;text-align: justify; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td colspan="2" style="border-left-style: none;border-right-style: none;border-bottom-style: none">P E R H A T I A N</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-style: none">1.</td>';
            echo '<td style="border-left-style: none;border-style: none">Harap penyetoran dilakukan pada Kas Daerah atau Tempat Lain yang ditunjuk (BKP), DPPKAD Kota Pekalongan dengan mengunakan Surat Setoran Pajak Daerah (SSPD)</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-left-style: none;border-right-style: none;border-top-style: none">2.</td>';
            echo '<td style="border-left-style: none;border-left-style: none;border-right-style: none;border-top-style: none">Apabila ini tidak atau kurang bayar lewat tanggal jatuh tempo akan dikenakan sanksi administrasi berupa bunga sebesar 2% per bulan.</td>';
            echo '</tr>';
            echo '</table>';
            $tgl_tetap = explode("-", $getdata[$i]->netapajrek_tgl);
            echo '<table style="text-align: center;margin-left: auto; margin-right: auto; margin-top: 5px; width: 100%; font-size:12px" align="center">
                  <tr>
                    <td style="width:60%;"></td>
                    <td style="width:40%;text-align: center;">'.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).', '.$this->format_tanggal($tgl_tetap[2],$tgl_tetap[1],$tgl_tetap[0]).'</td>
                  </tr>
                  <tr>
                    <td></td>
                  <td style="text-align: center;">A.n. Kepala DPPKAD Kota Pekalongan</td>
                  </tr>            
                  <tr>
                    <td></td>
                    <td>'.$pejabat[0]->ref_japeda_nama.'</td>
                  </tr>  
                  <tr>
                    <td><br></br><br></br><br></br><br></br></td>
                    <td><br></br><br></br><br></br><br></br></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="text-align: center"><u><b>'.$pejabat[0]->pejda_nama.'</b></u></td>
                  </tr>              
                  <tr>
                    <td></td>
                    <td style="text-align: center;">'.$pejabat[0]->ref_pangpej_ket.'</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="text-align: center;">NIP . '.$pejabat[0]->pejda_nip.'</td>
                  </tr>
                  </table>';

            echo '<p align="left" style="margin:0px; margin-top:5px; margin-bottom:5px; padding:0px; font-size:8px;">User : '.Auth::user()->opr_nama.'</p>';

            echo "<pagebreak />";
        }
        
        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-L');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_skpd.pdf" ,'I');
    }

    public function cetak_skrd(Request $request){
        // dd($request);

        $pecah = explode("/", $request->tgl_tetap);
        $tgl= $pecah[2].'-'.$pecah[1].'-'.$pecah[0];

        $pejabat = DB::table('v_pejabat_daerah')->where('pejda_id',$request->pejabat)->get();

        $data_pemerintah = DB::table('data_pemerintah_daerah')->get();
        $getjenis = DB::table('ref_reklame_jenis')->get();
        foreach ($getjenis as $key) {
            $jenis[$key->nid] = $key->cname;
        }
        $getdata = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->join('spt_detail','spt_detail.spt_dt_id_spt','=','spt.spt_id')
                    ->join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id_spt','=','spt.spt_id')
                    ->leftjoin('setoran_pajak_retribusi','setoran_pajak_retribusi.setorpajret_id_penetapan','=','penetapan_pajak_retribusi.netapajrek_id')
                    ->where('spt.spt_jenis_pajakretribusi',$request->objek_pajak) 
                    ->where('spt.spt_periode',$request->tahun)
                    ->orderBy('spt.spt_nomor')
                    ->get();

        ob_start();
        for ($i=0; $i < count($getdata) ; $i++) { 
            echo '<table style="font-size:12px;text-align: center; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-top-style: none">PEMERINTAH KOTA '.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).'<br>
                    DINAS PENDAPATAN, PENGELOLAAN KEUANGAN <br>
                    DAN ASET DAERAH <br>
                    '.$data_pemerintah[0]->dapemda_lokasi.' - '.$data_pemerintah[0]->dapemda_ibu_kota.'<br>
                    '.$data_pemerintah[0]->dapemda_no_telp.'</td>';
            echo '<td style="border-top-style: none"><b style="font-size:20px">SKRD</b><br>
                    (SURAT KETETAPAN RETRIBUSI DAERAH) <br>
                    MASA : '.date('F',strtotime($getdata[$i]->spt_periode_jual1)).' <br>
                    TAHUN : '.$getdata[$i]->spt_periode.'
                    </td>';
            echo '<td style="border-top-style: none">No Urut<br>
                    '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).' </td>';
            echo '</tr>';
            echo '</table>';

            echo "<br>";
            echo '<table style="font-size:13px;text-align: left;" border="0">';
            echo '<tr>';
            echo '<td>NAMA</td>';
            echo '<td>:</td>';
            echo '<td>'.$getdata[$i]->wp_wr_nama.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>ALAMAT</td>';
            echo '<td>:</td>';
            echo '<td>'.$getdata[$i]->wp_wr_almt.'</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td>NPWPD</td>';
            echo '<td>:</td>';
            echo '<td>'.$getdata[$i]->npwprd.'</td>';
            echo '</tr>';
            echo '</table>';

            echo "<br>";
            echo '<table style="font-size:12px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="0">';
            echo '<tr>';
            $jth_tempo = explode("-", $getdata[$i]->netapajrek_tgl_jatuh_tempo);
            echo '<td>Tanggal Jatuh Tempo : '.$this->format_tanggal($jth_tempo[2],$jth_tempo[1],$jth_tempo[0]).'</td>';
            echo '<td style="text-align: right;">No Urut: '.str_pad($getdata[$i]->spt_nomor, 4, '0', STR_PAD_LEFT).'</td>';
            echo '</tr>';
            echo '</table>';

            echo '<table style="vertical-align:top;font-size:14px;text-align: left; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td valign="top" style="width:5%">N O</td>';
            echo '<td valign="top" style="width:75%" colspan="3">U R A I A N</td>';
            echo '<td valign="top" style="width:20%">J U M L A H (Rp)</td>';
            echo '</tr>';

            echo '<tr>';
            echo '<td rowspan="4">1</td>';
            $per1 = explode("-", $getdata[$i]->spt_periode_jual1);
            $per2 = explode("-", $getdata[$i]->spt_periode_jual2);
            echo '<td style="border-style:none">No. Rek</td>
                    <td style="border-style:none">:</td>
                    <td style="border-style:none">'.$getdata[$i]->korek_tipe.$getdata[$i]->korek_kelompok.$getdata[$i]->korek_jenis.$getdata[$i]->korek_objek.'.'.$getdata[$i]->korek_rincian.'.'.$getdata[$i]->korek_sub1.' - '.$getdata[$i]->korek_nama.'</td>';
            echo '<td rowspan="4" valign="top" style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
            echo '</tr>';
            echo '  <tr>
                        <td style="border-style:none">Jenis</td>
                        <td style="border-style:none">:</td>
                        <td style="border-style:none">'.$getdata[$i]->korek_nama.'</td>
                    </tr>
                        <tr>
                            <td style="border-style:none" colspan="3">Masa Pajak '.$this->format_tanggal($per1[2],$per1[1],$per1[0]).' s.d '.$this->format_tanggal($per2[2],$per2[1],$per2[0]).'</td>
                        </tr>
                        <tr>
                            <td style="border-style:none" colspan="3">'.$getdata[$i]->spt_dt_lokasi.'</td>
                        </tr>';
 
            echo '<tr>';
            echo '<td colspan="4">Jumlah Ketetapan Pokok Pajak</td>';
            echo '<td style="text-align:right">'.number_format($getdata[$i]->spt_pajak,2,',','.').'</td>';
            echo '</tr>';
            echo '</table>';

            echo '<p align="left" style="margin:0px; margin-top:5px; margin-bottom:5px; padding:0px; font-size:13px;">Dengan huruf</p>';
            echo '<p align="left" style="margin:0px; margin-bottom:10px; padding:0px; font-size:13px;"><b>'.$this->terbilang($getdata[$i]->spt_pajak).'</b></p>';
            
            echo '<table style="vertical-align:top;font-size:13px;text-align: justify; border-collapse: collapse; margin-left: auto; margin-right: auto; width: 100%;" border="1">';
            echo '<tr>';
            echo '<td colspan="2" style="border-left-style: none;border-right-style: none;border-bottom-style: none">P E R H A T I A N</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-style: none">1.</td>';
            echo '<td style="border-left-style: none;border-style: none">Harap penyetoran dilakukan pada Kas Daerah atau Tempat Lain yang ditunjuk (BKP), DPPKAD Kota Pekalongan dengan mengunakan Surat Setoran Pajak Daerah (SSPD)</td>';
            echo '</tr>';
            echo '<tr>';
            echo '<td style="border-left-style: none;border-left-style: none;border-right-style: none;border-top-style: none">2.</td>';
            echo '<td style="border-left-style: none;border-left-style: none;border-right-style: none;border-top-style: none">Apabila ini tidak atau kurang bayar lewat tanggal jatuh tempo akan dikenakan sanksi administrasi berupa bunga sebesar 2% per bulan.</td>';
            echo '</tr>';
            echo '</table>';
            $tgl_tetap = explode("-", $getdata[$i]->netapajrek_tgl);
            echo '<table style="text-align: center;margin-left: auto; margin-right: auto; margin-top: 5px; width: 100%; font-size:12px" align="center">
                  <tr>
                    <td style="width:60%;"></td>
                    <td style="width:40%;text-align: center;">'.strtoupper($data_pemerintah[0]->dapemda_ibu_kota).', '.$this->format_tanggal($tgl_tetap[2],$tgl_tetap[1],$tgl_tetap[0]).'</td>
                  </tr>
                  <tr>
                    <td></td>
                  <td style="text-align: center;">A.n. Kepala DPPKAD Kota Pekalongan</td>
                  </tr>            
                  <tr>
                    <td></td>
                    <td>'.$pejabat[0]->ref_japeda_nama.'</td>
                  </tr>  
                  <tr>
                    <td><br></br><br></br><br></br><br></br></td>
                    <td><br></br><br></br><br></br><br></br></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="text-align: center"><u><b>'.$pejabat[0]->pejda_nama.'</b></u></td>
                  </tr>              
                  <tr>
                    <td></td>
                    <td style="text-align: center;">'.$pejabat[0]->ref_pangpej_ket.'</td>
                  </tr>
                  <tr>
                    <td></td>
                    <td style="text-align: center;">NIP . '.$pejabat[0]->pejda_nip.'</td>
                  </tr>
                  </table>';

            echo '<p align="left" style="margin:0px; margin-top:5px; margin-bottom:5px; padding:0px; font-size:8px;">User : '.Auth::user()->opr_nama.'</p>';

            echo "<pagebreak />";
        }
        
        $html = ob_get_contents(); 
        ob_end_clean();
        $mpdf=new \Mpdf('utf-8', 'A4-P');
        $mpdf->WriteHTML(utf8_encode($html));
        $mpdf->Output("cetak_skpd.pdf" ,'I');
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
}
