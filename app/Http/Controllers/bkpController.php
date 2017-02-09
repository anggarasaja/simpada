<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ref_jenis_pajak_retribusi;
use App\v_penyetoran_sspd;
use App\penetapan_pajak_retribusi;
use App\setoran_pajak_retribusi;
use App\kohir;
use App\spt;
use App\spt_detail;
use App\v_wp_wr;
use Datatables;
use DB;
use URL;
use Form;

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
        $link = array('bkp/menu1',
                      'bkp/menu2',
                      'bkp/menu3',
                      'bkp/menu4',
                      'bkp/menu5',
                      'bkp/menu6',
                      'bkp/menu7',
                      );
        $data_pajak = ref_jenis_pajak_retribusi::whereNotIn('ref_jenparet_id',[9,10])->orderBy('ref_jenparet_id')->get();
    	return view('penyetoran')->with(compact('array','link','data_pajak'));
    }

    //rekam setoran pajak retribusi
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
        $this->validate($request, [
            'period_spt' => 'required|max:4',
            'objek_pajak' => 'required',
            'no_kohir' => 'required',
            'tgl_setor' => 'required',
            // 'bendahara' => 'required',
            'via_bayar' => 'required',
            'kd_tetap' => 'required',
        ]);
        $getnobukti = kohir::where('kohir_thn','=',date('Y'))->get();
        $nobukti = $getnobukti[0]->kohir_no_bukti;
        $nobukti++;
        DB::table('kohir')->where('kohir_thn',date("Y"))->update(['kohir_no_bukti'=>$nobukti]);
        $tgl_setor = explode("/", $request->input('tgl_setor'));

        $get_kdtetap = DB::select('select ketspt_id from keterangan_spt where ketspt_singkat = ?',[$request->input('kd_tetap')]);

        $insert = new setoran_pajak_retribusi;
        $insert->setorpajret_id_penetapan = $request->input('setorpajret_id_penetapan');
        $insert->setorpajret_no_bukti = $nobukti;
        $insert->setorpajret_tgl_bayar = $tgl_setor[2].'-'.$tgl_setor[1].'-'.$tgl_setor[0];
        $insert->setorpajret_jlh_bayar = $request->input('pajak');
        $insert->setorpajret_via_bayar = $request->input('via_bayar');
        $insert->setorpajret_jenis_ketetapan = $get_kdtetap[0]->ketspt_id;
        $insert->save();

        flash('Data Berhasil Ditambahkan !', 'success');
        return redirect('bkp/editmenu1/'.$insert->setorpajret_id);
    }

    public function editmenu1($id){
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
        $post = setoran_pajak_retribusi::find($id);
        $getnetapajrek = penetapan_pajak_retribusi::where('netapajrek_id',$post->setorpajret_id_penetapan)->get();
        $ketspt = DB::select('select ketspt_singkat from keterangan_spt where ketspt_id = ?',[$post->setorpajret_jenis_ketetapan]);
        $ketsingkat = $ketspt[0]->ketspt_singkat;

        $spt = spt::find($getnetapajrek[0]->netapajrek_id_spt);
        $v_wp_wr = v_wp_wr::find($spt->spt_idwpwr);

        return view('menu1')->with(compact('post','v_wp_wr','spt','ket','pejda','viabayar','getnetapajrek','ketsingkat'));
    }

    public function menu2(){
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
        return view('menu2')->with(compact('ket','pejda','viabayar'));
    }

    public function store_menu2(Request $request){
        $this->validate($request, [
            'period_spt' => 'required|max:4',
            'objek_pajak' => 'required',
            'no_spt' => 'required',
            'tgl_setor' => 'required',
            'via_bayar' => 'required',
            'kode_sptpd' => 'required',
        ]);

        $getnobukti = kohir::where('kohir_thn','=',date('Y'))->get();
        $nobukti = $getnobukti[0]->kohir_no_bukti;
        $nobukti++;
        DB::table('kohir')->where('kohir_thn',date("Y"))->update(['kohir_no_bukti'=>$nobukti]);

        $tgl_setor = explode("/", $request->input('tgl_setor'));

        $get_kdtetap = DB::select('select ketspt_id from keterangan_spt where ketspt_singkat = ?',[$request->input('kd_tetap')]);

        $insert = new setoran_pajak_retribusi;
        $insert->setorpajret_id_penetapan = $request->input('spt_id');
        $insert->setorpajret_no_bukti = $nobukti;
        $insert->setorpajret_tgl_bayar = $tgl_setor[2].'-'.$tgl_setor[1].'-'.$tgl_setor[0];
        $insert->setorpajret_jlh_bayar = $request->input('pajak');
        $insert->setorpajret_via_bayar = $request->input('via_bayar');
        $insert->setorpajret_jenis_ketetapan = $request->kode_sptpd;
        $insert->save();

        flash('Data Berhasil Ditambahkan !', 'success');
        return redirect('bkp/editmenu2/'.$insert->setorpajret_id);
    }

    public function editmenu2($id){
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
        $post = setoran_pajak_retribusi::find($id);
        $spt = spt::where('spt_id',$post->setorpajret_id_penetapan)->get();

        $v_wp_wr = v_wp_wr::find($spt[0]->spt_idwpwr);

        return view('menu2')->with(compact('post','v_wp_wr','spt','ket','pejda','viabayar'));
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

    ###############
    #### tabel ####
    public function table_setorpajret_official($status=""){
        return view('table_setorpajret_official')->with(compact('status',$status));
    }

    public function getdata_setorpajret(){
        $query = setoran_pajak_retribusi::join('penetapan_pajak_retribusi','penetapan_pajak_retribusi.netapajrek_id','=','setoran_pajak_retribusi.setorpajret_id_penetapan')
                                        ->join('spt','spt.spt_id','=','penetapan_pajak_retribusi.netapajrek_id_spt')
                                        ->join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                                        ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                                        ->join('keterangan_spt','keterangan_spt.ketspt_id','=','setoran_pajak_retribusi.setorpajret_jenis_ketetapan')
                                        ->join('ref_via_bayar_pajak_retribusi','ref_via_bayar_pajak_retribusi.ref_viabaypajret_id','=','setoran_pajak_retribusi.setorpajret_via_bayar')
                                        // ->whereRaw('spt.spt_jenis_pajakretribusi IN (4::smallint,8::smallint,10::smallint)')
                                        ->orderBy('setorpajret_id','DESC')
                                        ->select(array('setorpajret_id', 
                                                        'spt.spt_nomor', 
                                                        'spt.spt_periode', 
                                                        'keterangan_spt.ketspt_singkat', 
                                                        'setoran_pajak_retribusi.setorpajret_tgl_bayar',
                                                        'kode_rekening.korek_nama',
                                                        'v_wp_wr.npwprd',
                                                        'v_wp_wr.wp_wr_nama',
                                                        'ref_via_bayar_pajak_retribusi.ref_viabaypajret_ket'
                                    ));
        
        return Datatables::of($query)
        ->editColumn('setorpajret_tgl_bayar','{{ ($setorpajret_tgl_bayar) ? date("d M Y", strtotime($setorpajret_tgl_bayar)) : "-"}}')
        ->addColumn('aksi', function ($row) {
            $button = "<div class='btn-group-vertical'>";
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('bkp/editmenu1/'.$row->setorpajret_id) ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
                $button .=  Form::open(array('url' => 'bkp/setorpajret/delete/' .$row->setorpajret_id , 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            $button .= "</div>";
            return $button;
        })   
        ->make(true);
    }
    #### tabel ####
    ###############

    ##############
    ### DELETE ###
    public function delete_setorpajret($id){
        $jenis = $_POST['jenis'];

        $setor = setoran_pajak_retribusi::find($id);
        $setor->delete();

        flash('Data Setor telah dihapus !','success');
        if ($jenis == 2) {
            return redirect('bkp/daftar-official');
        }elseif($jenis == 1){
            return redirect('bkp/daftar-self');
        }
    }
    ### END DELETE ###
    ##################

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
                    ->whereRaw('penetapan_pajak_retribusi.netapajrek_id NOT IN ( SELECT setoran_pajak_retribusi.setorpajret_id_penetapan
                                   FROM setoran_pajak_retribusi
                                  WHERE setoran_pajak_retribusi.setorpajret_id_penetapan IS NOT NULL AND setoran_pajak_retribusi.setorpajret_jenis_ketetapan <> 8::smallint)') 
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

    public function getkohir2(){
        $tahun = $_GET['period_spt'];
        $objek_pajak = $_GET['objek_pajak'];
        $get = spt::join('v_wp_wr','v_wp_wr.wp_wr_id','=','spt.spt_idwpwr')
                    ->join('kode_rekening','kode_rekening.korek_id','=','spt.spt_kode_rek')
                    ->where('spt.spt_jenis_pajakretribusi',$objek_pajak) 
                    ->where('spt.spt_periode',$tahun) 
                    ->whereRaw('spt.spt_id NOT IN ( SELECT setoran_pajak_retribusi.setorpajret_id_penetapan
                                   FROM setoran_pajak_retribusi
                                  WHERE setoran_pajak_retribusi.setorpajret_id_penetapan IS NOT NULL AND setoran_pajak_retribusi.setorpajret_jenis_ketetapan = 8::smallint)') 
                    ->orderBy('spt_id','DESC')
                    ->get();

        return Datatables::of($get)
        ->edit_column('spt_pajak','@if($spt_pajak == "") 0
                                            @else {{ $spt_pajak }}
                                            @endif
                                            ')
        ->addColumn('korek','{{ $korek_tipe . $korek_kelompok . $korek_jenis . $korek_objek }}')
        ->add_column('masa_pajak','{{ $spt_periode_jual1 }} s/d {{ $spt_periode_jual2 }}')
        ->make(true);
    }

    public function getpajak(){
        $spt_id = $_GET['spt_id'];
        $spt_dt = spt_detail::where('spt_dt_id_spt',$spt_id)->get();
        $jumlah = 0;
        foreach ($spt_dt as $key) {
            $jumlah = $jumlah + $key->spt_dt_jumlah;
        }
        echo $jumlah;
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
        ->editColumn('sprsd_periode_jual1',function($row){
            return date('M',strtotime($row->sprsd_periode_jual1))."-".$row->sprsd_thn;
        })
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>";
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('bkp/editmenu2/'.$row->setorpajret_id) ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
                $button .=  Form::open(array('url' => 'bkp/setorpajret/delete/' .$row->setorpajret_id , 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::hidden("jenis", "1") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            $button .= "</div>";
            return $button;
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
            $button = "<div class='btn-group-vertical'>";
                $button .= "<a type='button' class='btn btn-primary btn-xs' href='". URL::to('bkp/editmenu1/'.$row->setorpajret_id) ."'><i class='fa fa-list'></i>&nbsp; VIEW</a>";
                $button .=  Form::open(array('url' => 'bkp/setorpajret/delete/' .$row->setorpajret_id , 'class' => 'pull-right')).
                            ''. Form::hidden("_method", "DELETE") .
                            ''. Form::hidden("jenis", "2") .
                            ''. Form::submit("DELETE", array("class" => "btn btn-danger btn-delete btn-xs")) .
                            ''. Form::close();
            $button .= "</div>";
            return $button;
        })   
        ->make(true);
    }
}
