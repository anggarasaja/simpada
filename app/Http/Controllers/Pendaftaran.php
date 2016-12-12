<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Universal;

use Illuminate\Http\Request;
use Datatables; 	
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\bank;

class Pendaftaran extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function wpwrbadan(){
        return view('pendaftaranwpwrbadan');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function wpwrpribadi($status='')
    {
        //
        // View::make('pendaftaranwpwrpribadi');
        $kodus = $this->getBidangUsaha();
        $kecamatan = $this->getKecamatan();
        $no_urut = $this->getNomorUrut();
        return view('pendaftaranwpwrpribadi',['kodus'=>$kodus, 'kecamatan'=>$kecamatan, 'no_urut' =>$no_urut,'jenis' => 'Baru','status'=>$status]);
    }


    public function savePribadi(Request $request){
        if($request->input('jenis')=='Buat' && $request->input('wp_wr_id')==''){
            list($wp_wr_kd_camat,$wp_wr_camat) =  explode("|",$request->input('wp_wr_kd_camat'));

            $record = array();
            $universal = new Universal();
            $record["wp_wr_id"] = $universal->nextVal('wp_wr_wp_wr_id_seq');
            $record["wp_wr_no_form"] = '1'.$request->input('wp_wr_no_urut');
            $record["wp_wr_no_urut"] = $request->input('wp_wr_no_urut');
            $record["wp_wr_gol"] = $request->input('wp_wr_gol');
            $record["wp_wr_jenis"] = $request->input('wp_wr_jenis');
            $record["wp_wr_nama"] = strtoupper($request->input('wp_wr_nama'));
            $record["wp_wr_almt"] = htmlspecialchars(strip_tags(strtoupper($request->input('wp_wr_almt'))), ENT_QUOTES);
            $record["wp_wr_lurah"] = $request->input('wp_wr_lurah');
            $record["wp_wr_camat"] = $wp_wr_camat;
            $record["wp_wr_kd_lurah"] = $request->input('wp_wr_kd_lurah');
            $record["wp_wr_kd_camat"] = $wp_wr_kd_camat;
            $record["wp_wr_kabupaten"] = strtoupper($request->input('wp_wr_kabupaten')) ;
            $record["wp_wr_telp"] = $request->input('wp_wr_telp');
            $record["wp_wr_kodepos"] = $request->input('wp_wr_kodepos');
            
            $record["wp_wr_wn"] = $request->input('wp_wr_wn');
            $record["wp_wr_jns_tb"] = $request->input('wp_wr_jns_tb');
            $record["wp_wr_no_tb"] = $request->input('wp_wr_no_tb');
            $record["wp_wr_tgl_tb"] = $universal->format_tgl($request->input('wp_wr_tgl_tb'));
            $record["wp_wr_no_kk"] = $request->input('wp_wr_no_kk');
            $record["wp_wr_tgl_kk"] = $universal->format_tgl($request->input('wp_wr_tgl_kk'));
            $record["wp_wr_pekerjaan"] = $request->input('wp_wr_pekerjaan');
            $record["wp_wr_nm_instansi"] = $request->input('wp_wr_nm_instansi');
            $record["wp_wr_alm_instansi"] = $request->input('wp_wr_alm_instansi');
            
            $record["wp_wr_tgl_kartu"] = $universal->format_tgl($request->input('wp_wr_tgl_kartu'));
            $record["wp_wr_tgl_terima_form"] = $universal->format_tgl($request->input('wp_wr_tgl_terima_form'));
            $record["wp_wr_tgl_bts_kirim"] = $universal->format_tgl($request->input('wp_wr_tgl_bts_kirim'));
            $record["wp_wr_tgl_form_kembali"] = $universal->format_tgl($request->input('wp_wr_tgl_form_kembali'));
            $record["wp_wr_tgl_tutup"] = $universal->format_tgl($request->input('wp_wr_tgl_tutup'));

                // $record["wp_wr_bidang_usaha"] = saveBidus($attributes['bidus']);
                $record["wp_wr_bidang_usaha"] = $this->saveBidus($request->input('bidus'));

            $record["wp_wr_jns_pemungutan"] = 1;
            $record["wp_wr_pejabat"] = $request->input('wp_wr_pejabat');

            echo "<pre>";
            print_r($record);
            echo "</pre>";
            exit;
            try {
                $id = DB::table('wp_wr')->insertGetId($record,"wp_wr_id");
                return redirect()->route('editPribadi',['edit'=>$id, 'status'=>2]);
            } catch (Exception $e) {
                return redirect()->route('editPribadi',['edit'=>$id, 'status'=>-2]);
            }
            
            // $insertSQL = &$db->AutoExecute('wp_wr', $record, 'INSERT');
            // historyLog("$task $log_label ", $log_table, "$log_id=$record[wp_wr_id]", $log_fields);


            //         $loc = $myself.$XFA[$dsp_form]."&idedit=$record[wp_wr_id]&form=$form";
            //         header ("location:".$loc);
        } elseif ($request->input('jenis')=='Edit'  && $request->input('wp_wr_id')!='') {

            list($wp_wr_kd_camat,$wp_wr_camat) =  explode("|",$request->input('wp_wr_kd_camat'));

            $record = array();
            $universal = new Universal();
            $record["wp_wr_id"] = $request->input('wp_wr_id');
            $record["wp_wr_no_form"] = '1'.$request->input('wp_wr_no_urut');
            $record["wp_wr_no_urut"] = $request->input('wp_wr_no_urut');
            $record["wp_wr_gol"] = $request->input('wp_wr_gol');
            $record["wp_wr_jenis"] = $request->input('wp_wr_jenis');
            $record["wp_wr_nama"] = strtoupper($request->input('wp_wr_nama'));
            $record["wp_wr_almt"] = htmlspecialchars(strip_tags(strtoupper($request->input('wp_wr_almt'))), ENT_QUOTES);
            $record["wp_wr_lurah"] = $request->input('wp_wr_lurah');
            $record["wp_wr_camat"] = $wp_wr_camat;
            $record["wp_wr_kd_lurah"] = $request->input('wp_wr_kd_lurah');
            $record["wp_wr_kd_camat"] = $wp_wr_kd_camat;
            $record["wp_wr_kabupaten"] = strtoupper($request->input('wp_wr_kabupaten')) ;
            $record["wp_wr_telp"] = $request->input('wp_wr_telp');
            $record["wp_wr_kodepos"] = $request->input('wp_wr_kodepos');
            
            $record["wp_wr_wn"] = $request->input('wp_wr_wn');
            $record["wp_wr_jns_tb"] = $request->input('wp_wr_jns_tb');
            $record["wp_wr_no_tb"] = $request->input('wp_wr_no_tb');
            $record["wp_wr_tgl_tb"] = $universal->format_tgl($request->input('wp_wr_tgl_tb'));
            $record["wp_wr_no_kk"] = $request->input('wp_wr_no_kk');
            $record["wp_wr_tgl_kk"] = $universal->format_tgl($request->input('wp_wr_tgl_kk'));
            $record["wp_wr_pekerjaan"] = $request->input('wp_wr_pekerjaan');
            $record["wp_wr_nm_instansi"] = $request->input('wp_wr_nm_instansi');
            $record["wp_wr_alm_instansi"] = $request->input('wp_wr_alm_instansi');
            
            $record["wp_wr_tgl_kartu"] = $universal->format_tgl($request->input('wp_wr_tgl_kartu'));
            $record["wp_wr_tgl_terima_form"] = $universal->format_tgl($request->input('wp_wr_tgl_terima_form'));
            $record["wp_wr_tgl_bts_kirim"] = $universal->format_tgl($request->input('wp_wr_tgl_bts_kirim'));
            $record["wp_wr_tgl_form_kembali"] = $universal->format_tgl($request->input('wp_wr_tgl_form_kembali'));
            $record["wp_wr_tgl_tutup"] = $universal->format_tgl($request->input('wp_wr_tgl_tutup'));

                // $record["wp_wr_bidang_usaha"] = saveBidus($attributes['bidus']);
                $record["wp_wr_bidang_usaha"] = $this->saveBidus($request->input('bidus'));

            $record["wp_wr_jns_pemungutan"] = 1;
            $record["wp_wr_pejabat"] = $request->input('wp_wr_pejabat');

            try {
                //return true/1 if succeed
                $rs = DB::table('wp_wr')
                        ->where('wp_wr_id','=',$request->input('wp_wr_id'))
                        ->update($record);
                return redirect()->route('editPribadi',['edit'=>$request->input('wp_wr_id'), 'status'=>$rs]);
            } catch (Exception $e) {
                return redirect()->route('editPribadi',['edit'=>$request->input('wp_wr_id'), 'status'=>-1]);
            }

            
        } 
        
    }

    function editPribadi($id,$status=''){
            // $sql_cari = "SELECT a.*,b.camat_kode FROM wp_wr a, kecamatan b WHERE a.wp_wr_kd_camat=b.camat_id::text AND a.wp_wr_id=$idedit";
            // //$sql_cari = "SELECT a.*,b.camat_kode,(((upper((a.wp_wr_jenis)::text) || '.'::text || (a.wp_wr_no_form)::text) || '.'::text || (b.camat_kode)::text) || '.'::text || (c.lurah_kode)::text) AS npwprd FROM wp_wr a, kecamatan b, kelurahan c WHERE a.wp_wr_kd_camat=b.camat_id::text AND a.wp_wr_kd_lurah = c.lurah_id::text AND a.wp_wr_id=$idedit";
            // $ar_edit_data = &$db->GetRow($sql_cari );
            // $idcmt = $ar_edit_data[wp_wr_kd_camat];
            // $idlrh = $ar_edit_data[wp_wr_kd_lurah];
            // $qrycmt = "SELECT * FROM kecamatan WHERE camat_id='$idcmt'";
            // $ar_cmt = &$db->GetRow($qrycmt);
            // $qrylrh = "SELECT * FROM kelurahan WHERE lurah_id='$idlrh'";
            // $ar_lrh = &$db->GetRow($qrylrh);

        $kodus = $this->getBidangUsaha();
        $kecamatan = $this->getKecamatan();
        $no_urut = $this->getNomorUrut();

        try {
            $rs = DB::select(DB::raw('select a.*,b.camat_kode FROM wp_wr a, kecamatan b WHERE a.wp_wr_kd_camat=b.camat_id::text AND a.wp_wr_id='.$id));
        } catch (Exception $e) {
            
        }
        

        // $rs= DB::table('wp_wr as a')
        //         ->join('kecamatan as b','a.wp_wr_kd_camat','=','b.camat_id::text')
        //         ->select('a.*','b.camat_kode')
        //         ->where('a.wp_wr_id',$id)
        //         ->get();
        // $qrycmt = "SELECT * FROM kecamatan WHERE camat_id='$idcmt'";
            // $ar_cmt = &$db->GetRow($qrycmt);
            // $qrylrh = "SELECT * FROM kelurahan WHERE lurah_id='$idlrh'";
            // $ar_lrh = &$db->GetRow($qrylrh);
        
        if(count($rs)>0){
        $ar = (array)$rs[0];
            $cmt = DB::table('kecamatan')
                        ->where('camat_id','=',$ar['wp_wr_kd_camat'])
                        ->get();
            $lrh = DB::table('kelurahan')
                        ->where('lurah_id','=',$ar['wp_wr_kd_lurah'])
                        ->get();
            $ar_lrh = (array)$lrh[0];
            $ar_cmt = (array)$cmt[0];
            $arRs = array_merge($ar, ['kodus'=>$kodus, 'kecamatan'=>$kecamatan, 'no_urut' =>$no_urut, 'jenis' => 'Edit','status'=>$status],$ar_lrh,$ar_cmt);
                // echo'<pre>';
                // print_r($arRs);
                // echo'</pre>';
                // exit;
            return view('pendaftaranwpwrpribadi',$arRs);
        } else {
            return redirect()->route('createPribadi',['status'=>-3]);
        }
    }

    function saveBidus ($data) 
    {

    if(count($data)>0) 
        {
            foreach ($data as $k => $v) 
            {
                if(!empty($arrIdDetail)) $arrIdDetail = $arrIdDetail."::".$v;else $arrIdDetail = $v;
            }
    }
    return $arrIdDetail;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getBidangUsaha(){
        return $rs = DB::table('ref_kode_usaha')->orderBy('ref_kodus_kode')->get();

    }
    public function getKecamatan(){
        return DB::table('kecamatan')->orderBy('camat_kode')->get();
    }

    public function getKelurahan(Request $request){
        $idKecamatan = $request->input('idKecamatan');
        echo json_encode(DB::table('kelurahan')->where('lurah_kecamatan','=',$idKecamatan)->orderBy('lurah_kode')->get());
    }
    public function getKelurahan2(Request $request){
        $idKecamatan = 1;
        echo json_encode(DB::table('kelurahan')->where('lurah_kecamatan','=',$idKecamatan)->orderBy('lurah_kode')->get());
    }
    public function getNomorUrut(){
            // $next_nomor_urut = &$db->GetOne("SELECT COALESCE(MAX(wp_wr_no_urut::INT),0) + 1 FROM wp_wr");// WHERE wp_wr_jenis = '$jenis'");
        $next_nomor_urut = DB::table('wp_wr')->max('wp_wr_no_urut');
        // $next_nomor_urut = DB::table('wp_wr')->max('wp_wr_no_urut');
        $next_nomor_urut++;
        // $next_nomor_urut = DB::table('wp_wr')->select(DB::raw('COALESCE(MAX(wp_wr_no_urut::INT),0) + 1'))->get();

        // print_r($next_nomor_urut);
        if (!empty($next_nomor_urut) && $next_nomor_urut <= 9999999) {
            if (strlen($next_nomor_urut) < 7) {
                $selisih = 7 - strlen($next_nomor_urut);
                for ($i = 1; $i <= $selisih; $i++) {
                    $next_nomor_urut = "0" . $next_nomor_urut;
                }
            }
            return $next_nomor_urut;
        } elseif ($next_nomor_urut > 9999999) {
            return "salah";
        }
    }

    public function tableWpPribadi(){
        return view('daftarWpPribadi');
    }
    public function tableWpBu(){
        return view('daftarWpBu');
    }

    public function wpPribadiDt(){
    	$records = DB::table('v_wp_wr')->where('wp_wr_gol',1)->orderBy('wp_wr_id','desc');
    	return Datatables::of($records)
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>
                                <a type='button' class='btn btn-primary' href='/daftar-pribadi/edit/".$row->wp_wr_id."'>Edit</a>
                                </div>";
            return $button;
        })   
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
        ->make(true);


    }public function wpBuDt(){
    	$records = DB::table('v_wp_wr')->where('wp_wr_gol',2)->orderBy('wp_wr_id','desc');
    	return Datatables::of($records)
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>
                                <a type='button' class='btn btn-primary' href='/daftar-pribadi/edit/".$row->wp_wr_id."'>Edit</a>
                                </div>";
            return $button;
        })   
        ->make(true);


    }
}
