<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Universal;

use Illuminate\Http\Request;
use Datatables; 	
use Fpdf;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\bank;
use App\Libraries\tbs_class;
use App\Libraries\tbs_plugin_opentbs;
class Pendaftaran extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }
    ### PRIBADI ###

    public function show_wpwrpribadi(){
        return view('show_wpwrpribadi');
    }

    public function store_wpwrpribadi(){

    }

    ### BADAN USAHA  ####

    public function wpwrbadan($status=''){
        $kodus = $this->getBidangUsaha();
        $kecamatan = $this->getKecamatan();
        $no_urut = $this->getNomorUrut();
        return view('pendaftaranwpwrbu',['kodus'=>$kodus, 'kecamatan'=>$kecamatan, 'no_urut' =>$no_urut,'jenis' => 'Baru','status'=>$status]);
    }

    public function show_wpwrbadan(){
        return view('show_wpwrbadan');
    }

    public function store_wpwrbadan(){

    }

    ### CETAK KARTU ####

    public function cetak_kartu(){
        return view('cetakNpwpd');
    }

    public function cetak_npwpd(){
                // prevent from a PHP configuration problem when using mktime() and date()
        if (version_compare(PHP_VERSION,'5.1.0')>=0) {
            if (ini_get('date.timezone')=='') {
                date_default_timezone_set('UTC');
            }
        }

        // Initialize the TBS instance
        $TBS = new \App\Libraries\clsTinyButStrong; // new instance of TBS
        $TBS->SetOption("noerr",true);
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

        $data = array();
        $template = app_path() . '/Doc_Template/npwpd.docx';
        $TBS->LoadTemplate($template, OPENTBS_ALREADY_UTF8); // Also merge some [onload] automatic fields (depends of the type of document).

        // ----------------------
        // Debug mode of the demo
        // ----------------------
        if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
        if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.

        // --------------------------------------------
        // Merging and other operations on the template
        // --------------------------------------------

        // Merge data in the body of the document
        // $TBS->MergeBlock('a,b', $data);

        // Merge data in colmuns
        $data = array(
         array('date' => '2013-10-13', 'thin' => 156, 'heavy' => 128, 'total' => 284),
         array('date' => '2013-10-14', 'thin' => 233, 'heavy' =>  25, 'total' => 284),
         array('date' => '2013-10-15', 'thin' => 110, 'heavy' => 412, 'total' => 130),
         array('date' => '2013-10-16', 'thin' => 258, 'heavy' => 522, 'total' => 258),
        );
        $TBS->MergeBlock('c', $data);


    
        // Delete comments
        $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

        // -----------------
        // Output the result
        // -----------------

        // Define the name of the output file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
        if ($save_as==='') {
            // Output the result as a downloadable file (only streaming, no data saved in the server)
            $TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
            // Be sure that no more output is done, otherwise the download file is corrupted with extra data.
            exit();
        } else {
            // Output the result as a file on the server.
            $TBS->Show(OPENTBS_FILE, $output_file_name); // Also merges all [onshow] automatic fields.
            // The script can continue.
            exit("File [$output_file_name] has been created.");
        }
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
        if($request->input('jenis')=='Baru' && $request->input('wp_wr_id')==''){
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

            // echo "<pre>";
            // print_r($record);
            // echo "</pre>";
            // exit;
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
    public function saveBU(Request $request){
        if($request->input('jenis')=='Baru' && $request->input('wp_wr_id')==''){
            list($wp_wr_kd_camat,$wp_wr_camat) =  explode("|",$request->input('wp_wr_kd_camat'));

            $ijin_nama = $request->input('ijin_nama');
            $ijin_nomor = $request->input('ijin_nomor');
            $ijin_tanggal = $request->input('ijin_tanggal');

            $record = array();
            $universal = new Universal();
            $record["wp_wr_id"] = $universal->nextVal('wp_wr_wp_wr_id_seq');
            $record["wp_wr_no_form"] = '2'.$request->input('wp_wr_no_urut');
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
            
            $record["wp_wr_nama_milik"] = $request->input('wp_wr_nama_milik');
            $record["wp_wr_almt_milik"] = $request->input('wp_wr_almt_milik');
            $record["wp_wr_lurah_milik"] = $request->input('wp_wr_lurah_milik');
            $record["wp_wr_camat_milik"] = $request->input('wp_wr_camat_milik');
            $record["wp_wr_kabupaten_milik"] = $request->input('wp_wr_kabupaten_milik');
            $record["wp_wr_telp_milik"] = $request->input('wp_wr_telp_milik');
            $record["wp_wr_kodepos_milik"] = $request->input('wp_wr_kodepos_milik');
            
            $record["wp_wr_tgl_kartu"] = $universal->format_tgl($request->input('wp_wr_tgl_kartu'));
            $record["wp_wr_tgl_terima_form"] = $universal->format_tgl($request->input('wp_wr_tgl_terima_form'));
            $record["wp_wr_tgl_bts_kirim"] = $universal->format_tgl($request->input('wp_wr_tgl_bts_kirim'));
            $record["wp_wr_tgl_form_kembali"] = $universal->format_tgl($request->input('wp_wr_tgl_form_kembali'));
            $record["wp_wr_tgl_tutup"] = $universal->format_tgl($request->input('wp_wr_tgl_tutup'));

            // $record["wp_wr_bidang_usaha"] = saveBidus($attributes['bidus']);
            $record["wp_wr_bidang_usaha"] = $this->saveBidus($request->input('bidus'));

            $record["wp_wr_jns_pemungutan"] = 1;
            $record["wp_wr_pejabat"] = $request->input('wp_wr_pejabat');

            // print_r($record);
            try {
                $id = DB::table('wp_wr')->insertGetId($record,"wp_wr_id");

                if (!empty($ijin_nama) and $id !="") {

                    foreach ($ijin_nama as $k => $v) {
                        $wp_wr_id = $record['wp_wr_id'];
                        $wp_wr_ijin_id = 0;
                        $detail = $this->detail($wp_wr_id,$wp_wr_ijin_id,$k,$ijin_nama,$ijin_nomor,$ijin_tanggal);
                        // $insertSQL = &$db->AutoExecute('wp_wr_perijinan', $detail, 'INSERT');
                        print_r($detail);
                        try {
                            DB::table('wp_wr_perijinan')->insert($detail);
                        } catch (Exception $e) {
                            return redirect()->route('editBU',['edit'=>$id, 'status'=>-2]);
                        }
                    }
                }
                // echo "<pre>";
                // print_r($record);
                // echo "</pre>";
                return redirect()->route('editBU',['edit'=>$id, 'status'=>2]);
            } catch (Exception $e) {
                return redirect()->route('editBU',['edit'=>$id, 'status'=>-2]);
            }
            
            // $insertSQL = &$db->AutoExecute('wp_wr', $record, 'INSERT');
            // historyLog("$task $log_label ", $log_table, "$log_id=$record[wp_wr_id]", $log_fields);


            //         $loc = $myself.$XFA[$dsp_form]."&idedit=$record[wp_wr_id]&form=$form";
            //         header ("location:".$loc);
        } elseif ($request->input('jenis')=='Edit'  && $request->input('wp_wr_id')!='') {
            list($wp_wr_kd_camat,$wp_wr_camat) =  explode("|",$request->input('wp_wr_kd_camat'));

            $ijin_id = $request->input('ijin_id');
            $ijin_nama = $request->input('ijin_nama');
            $ijin_nomor = $request->input('ijin_nomor');
            $ijin_tanggal = $request->input('ijin_tanggal');

            $record = array();
            $universal = new Universal();
            $record["wp_wr_id"] = $request->input('wp_wr_id');
            $record["wp_wr_no_form"] = '2'.$request->input('wp_wr_no_urut');
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
            
            $record["wp_wr_nama_milik"] = $request->input('wp_wr_nama_milik');
            $record["wp_wr_almt_milik"] = $request->input('wp_wr_almt_milik');
            $record["wp_wr_lurah_milik"] = $request->input('wp_wr_lurah_milik');
            $record["wp_wr_camat_milik"] = $request->input('wp_wr_camat_milik');
            $record["wp_wr_kabupaten_milik"] = $request->input('wp_wr_kabupaten_milik');
            $record["wp_wr_telp_milik"] = $request->input('wp_wr_telp_milik');
            $record["wp_wr_kodepos_milik"] = $request->input('wp_wr_kodepos_milik');
            
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
                // and $rs == 1    
                if (!empty($ijin_nama) and $rs == 1) {

                    foreach ($ijin_nama as $k => $v) {
                        $wp_wr_id = $record['wp_wr_id'];
                        $wp_wr_ijin_id = $ijin_id[$k];
                        $detail = $this->detail($wp_wr_id,$wp_wr_ijin_id,$k,$ijin_nama,$ijin_nomor,$ijin_tanggal);
                        if($wp_wr_ijin_id == 0){
                            try {
                                DB::table('wp_wr_perijinan')->insert($detail);
                            } catch (Exception $e) {
                                return redirect()->route('editBU',['edit'=>$id, 'status'=>-2]);
                            }
                        } else {
                            try {
                                DB::table('wp_wr_perijinan')
                                    ->where('wp_wr_ijin_id','=',$wp_wr_ijin_id)
                                    ->update($detail);
                            } catch (Exception $e) {
                                return redirect()->route('editBU',['edit'=>$id, 'status'=>-2]);
                            }
                        }
                        
                        // $insertSQL = &$db->AutoExecute('wp_wr_perijinan', $detail, 'INSERT');
                        // print_r($detail);
                        
                    }
                }
                return redirect()->route('editBU',['edit'=>$request->input('wp_wr_id'), 'status'=>$rs]);
            } catch (Exception $e) {
                return redirect()->route('editBU',['edit'=>$request->input('wp_wr_id'), 'status'=>-1]);
            }

            
        } 
        
    }

    function detail($wp_wr_id, $wp_wr_ijin_id, $k, $ijin_nama, $ijin_nomor, $ijin_tanggal) {
        $universal = new Universal();

        $detail = array();
        if ($wp_wr_ijin_id==0) {
            $detail["wp_wr_ijin_id"] = $universal->nextVal("wp_wr_perijinan_wp_wr_ijin_id");
        }else{
            $detail["wp_wr_ijin_id"] = $wp_wr_ijin_id;
        }
        $detail["wp_wr_id"] = $wp_wr_id;
        $detail["wp_wr_ijin_nama"] = $ijin_nama[$k];
        $detail["wp_wr_ijin_nomor"] = $ijin_nomor[$k];
        $detail["wp_wr_ijin_tanggal"] = $universal->format_tgl($ijin_tanggal[$k]);
        return $detail;
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

    function editBU($id,$status=''){
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
            $perijinan = DB::table('wp_wr_perijinan')
                        ->where('wp_wr_id','=',$id)
                        ->get();
            if(count($perijinan)>0){
                $ar_ijin = (array)$perijinan;
            } else {
                $ar_ijin = [];
            }
            
            $arRs = array_merge($ar, ['kodus'=>$kodus, 'kecamatan'=>$kecamatan, 'no_urut' =>$no_urut, 'jenis' => 'Edit','status'=>$status],$ar_lrh,$ar_cmt,['ar_ijin'=>$ar_ijin]);
                // echo'<pre>';
                // print_r($arRs);
                // echo'</pre>';
                // exit;
            return view('pendaftaranwpwrbu',$arRs);
        } else {
            return redirect()->route('createBU',['status'=>-3]);
        }
    }

    function saveBidus ($data) 
    {
    $arrIdDetail = '';
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


    }
    public function wpBuDt(){
    	$records = DB::table('v_wp_wr')->where('wp_wr_gol',2)->orderBy('wp_wr_id','desc');
    	return Datatables::of($records)
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>
                                <a type='button' class='btn btn-primary' href='/daftar-bu/edit/".$row->wp_wr_id."'>Edit</a>
                                </div>";
            return $button;
        })   
        ->make(true);


    }
    public function cetakNpwpdDt(){
        // DB::enableQueryLog();
        $records = DB::table('v_wp_wr')->where('wp_wr_gol',2)->orderBy('wp_wr_id','desc');
        // dd($records);    
        
        $dt = Datatables::of($records)
        ->addColumn('action', function ($row) {
            $button = "<div class='btn-group-vertical'>
                                <a type='button' class='btn btn-primary' target=_blank' href='/cetak-npwpd-pdf/".$row->wp_wr_id."'>Cetak</a>
                                </div>";
            return $button;
        })   
        ->make(true);
        // echo "tes";
        // dd(DB::getQueryLog());
        return $dt;

    }

    public function cetakNpwpd($wpwrid){

        $dataPemda = DB::table("data_pemerintah_daerah")->first();
        $dataPejabat = DB::table("v_pejabat_daerah")->where("pejda_kode","=","01")->first();
        $dataNpwp = DB::table("v_wp_wr")->where("wp_wr_id","=",$wpwrid)->first();

        error_reporting(E_ALL ^ E_NOTICE);
        $table_default_tbl_type = array(
            'TB_ALIGN' => 'L',
            'L_MARGIN' => 0,
            'BRD_COLOR' => array(0,0,0),
            'BRD_SIZE' => 0.2,
        );
        $table_default_datax_type = array(
            'T_COLOR' => array(0,0,0),
            'T_SIZE' => 10,
            'T_FONT' => 'Arial',
            'T_ALIGN' => 'L',
            'V_ALIGN' => 'M',
            'LN_SIZE' => 5,
            'BG_COLOR' => array(255,255,255),
            'BRD_COLOR' => array(0,0,0),
            'BRD_SIZE' => 0.2,
        );
        $table_default_ttd_type = array(
            'T_COLOR' => array(0,0,0),
            'T_ALIGN' => 'C',
            'T_SIZE' => 9,
            'V_ALIGN' => 'M',
            'LN_SIZE' => 5,
            'BG_COLOR' => array(255,255,255),
            'BRD_COLOR' => array(0,0,0),
            'BRD_SIZE' => 0.2,
        );
        
        $table_default_kartu_type = array(
            'T_COLOR' => array(0,0,0),
            'T_SIZE' => 7,
            'T_FONT' => 'Arial',
            'T_ALIGN' => 'L',
            'V_ALIGN' => 'T',
            'LN_SIZE' => 4,
            'BG_COLOR' => array(255,255,255),
            'BRD_COLOR' => array(0,0,0),
            'BRD_SIZE' => 0.2,
        );
        $pdf = new \Smichaelsen\FpdfTables\FpdfTables();
        $pdf->setMargins(0,0,0,0);
        $pdf->AddPage("P","A4");
        $pdf->AliasNbPages();
        

        $pdf->SetStyle("sb","arial","B",7,"0,0,0");
        $pdf->SetStyle("b","arial","B",7,"0,0,0");
        $pdf->SetStyle("h1","arial","B",10,"0,0,0");
        $pdf->SetStyle("nu","arial","U",8,"0,0,0");
        $pdf->SetStyle("bu","arial","BU",7,"0,0,0");
        $pdf->SetStyle("small","arial","",6,"0,0,0");
        $pdf->SetStyle("su","arial","U",6,"0,0,0");
        $pdf->SetStyle("i","arial","I",6,"0,0,0");

        
        $kol = 3;
        $pdf->tbInitialize($kol, true, true);
        $pdf->tbSetTableType($table_default_tbl_type);
        
        for($a=0; $a<$kol; $a++) $w[$a] = $table_default_datax_type;
        
        $w[0]['WIDTH'] = 10;
        $w[1]['WIDTH'] = 65;
        $w[2]['WIDTH'] = 10;
        
        $pdf->tbSetHeaderType($w);
        
        for($b=0; $b<$kol; $b++) {
            $spc[$b] = $table_default_datax_type;
            $kop[$b] = $table_default_datax_type;
            $ket[$b] = $table_default_datax_type;
        }
        
        $spc[0]['TEXT'] = "";
        $spc[1]['TEXT'] = "";
        $spc[2]['TEXT'] = "";

        $spc[0]['LN_SIZE'] = 2;
        $spc[1]['LN_SIZE'] = 2;
        $spc[2]['LN_SIZE'] = 2;
        $pdf->tbDrawData($spc);
        
        $kop[0]['TEXT'] = "";
        $kop[1]['TEXT'] = "<b>PEMERINTAH ".strtoupper($dataPemda->dapemda_nama)." ".strtoupper($dataPemda->dapemda_nm_dati2) . "</b>";
        $kop[2]['TEXT'] = "";
        $kop[1]['T_ALIGN'] = 'L';
        $kop[0]['LN_SIZE'] = 3;
        $kop[1]['LN_SIZE'] = 3;
        $kop[2]['LN_SIZE'] = 3;
        $pdf->tbDrawData($kop);
        
        $kop[0]['TEXT'] = "";
        $kop[1]['TEXT'] = "DINAS PENDAPATAN, PENGELOLAAN KEUANGAN DAN ASET\nDAERAH KOTA PEKALONGAN";
        $kop[2]['TEXT'] = "";
        $kop[1]['T_SIZE'] = 5;
        $kop[1]['T_ALIGN'] = 'L';
        $pdf->tbDrawData($kop);
        
        $ket[0]['TEXT'] = "<bu>KARTU PENGENAL NPWPD</bu>";
        $ket[0]['COLSPAN'] = 3;
        $ket[0]['T_ALIGN'] = 'C';
        $ket[0]['LN_SIZE'] = 4;
        $ket[0]['BRD_TYPE'] = 'T';

        $pdf->tbDrawData($ket);
        
        $pdf->tbOuputData();
        
        $col = 5;
        $pdf->tbInitialize($col, true, true);
        $pdf->tbSetTableType($table_default_tbl_type);
        
        for($c=0; $c<$col; $c++) $l[$c] = $table_default_datax_type;
        
        $l[0]['WIDTH'] = 2;
        $l[1]['WIDTH'] = 18;
        $l[2]['WIDTH'] = 3;
        $l[3]['WIDTH'] = 60;
        $l[4]['WIDTH'] = 2;
        
        $pdf->tbSetHeaderType($l);
        
        for($d=0; $d<$col; $d++)
        {
            $ws[$d] = $table_default_kartu_type;
            $d1[$d] = $table_default_kartu_type;
            $d2[$d] = $table_default_ttd_type;
        }
        
        $ws[0]['COLSPAN'] = 5;
        $ws[0]['TEXT'] = "";

        $d1[0]['TEXT'] = "";
        $d1[1]['TEXT'] = "Nama";
        $d1[2]['TEXT'] = ":";
        if(!empty($dataNpwp->wp_wr_nama_milik)) {
            $d1[3]['TEXT'] = "" . $dataNpwp->wp_wr_nama_milik;
        }
        elseif(empty($$dataNpwp->wp_wr_nama_milik)) {
            $d1[3]['TEXT'] = "" . $dataNpwp->wp_wr_nama;
        }
        $d1[4]['TEXT'] = "";
        
        $pdf->tbDrawData($d1);
        
        $d1[0]['TEXT'] = "";
        $d1[1]['TEXT'] = "Alamat";
        $d1[2]['TEXT'] = ":";
        if(!empty($dataNpwp->wp_wr_almt_milik)) {
            $d1[3]['TEXT'] = "" . $dataNpwp->wp_wr_almt_milik;
        }
        elseif(empty($$dataNpwp->wp_wr_nama_milik)) {
            $d1[3]['TEXT'] = "" . $dataNpwp->wp_wr_almt;
        }   
        $d1[4]['TEXT'] = "";
        
        $pdf->tbDrawData($d1);
        
        $d1[0]['TEXT'] = "";
        $d1[1]['TEXT'] = "NPWPD";
        $d1[2]['TEXT'] = ":";
        $d1[3]['TEXT'] = "" . $dataNpwp->npwprd;
        $d1[4]['TEXT'] = "";    
        $pdf->tbDrawData($d1);
        $pdf->tbOuputData();

        $pdf->setY(31);
        $pdf->setFont('Arial','',6);    
        $pdf->cell(25,3,'');$pdf->cell(60,3,ucwords(strtolower($dataPemda->dapemda_nm_dati2)).", ".date("d-m-Y"),0,1,'C');
        $pdf->cell(25,3,'');$pdf->cell(60,3,"a.n " . $dataPemda->dapemda_pejabat." ".$dataPemda->dapemda_nm_dati2,0,1,'C');
        $pdf->cell(25,3,'');$pdf->cell(60,3,"Kepala DPPKAD Kota Pekalongan",0,1,'C');
        $pdf->ln(5);
        $pdf->setFont('Arial','BU',6);  
        $pdf->cell(25,3,'');$pdf->cell(60,3,$dataPejabat->pejda_nama,0,1,'C');
        $pdf->setFont('Arial','',6);
        $pdf->cell(25,3,'');$pdf->cell(60,3,"NIP. ".$dataPejabat->pejda_nip,0,1,'C');
            
        $logo = public_path('images/logo_baru_pekalongan.jpg');
        $pdf->Image($logo,3,2,6);
        $wcbbw = public_path('images/wcbbw.jpg');
        $pdf->Image($wcbbw,65,1,18);        
        $ttd = public_path('images/ttd.png');
        $pdf->Image($ttd ,40,36,28);
        $pdf->_barcode(3, $pdf->GetY()-11,$dataNpwp->wp_wr_no_urut);
        
        
        $pdf->addpage();
        $kolom = 4;
        $pdf->tbInitialize($kolom, true, true);
        $pdf->tbSetTableType($table_default_tbl_type);
        
        for($e=0; $e<$kolom; $e++) $lk[$e] = $table_default_datax_type;
        
        $lk[0]['WIDTH'] = 2;
        $lk[1]['WIDTH'] = 5;
        $lk[2]['WIDTH'] = 76;
        $lk[3]['WIDTH'] = 2;
        
        $pdf->tbSetHeaderType($lk);
        
        for($f=0; $f<$kolom; $f++) {
            $nl[$f] = $table_default_kartu_type;
            $h[$f] = $table_default_datax_type;
            $p[$f] = $table_default_kartu_type;
        }
        
        $nl[0]['TEXT'] = "";
        $nl[0]['COLSPAN'] = 4;
        $pdf->tbDrawData($nl);
        
        $pdf->tbDrawData($nl);
        
        $h[0]['TEXT'] = "<h1>P E R H A T I A N</h1>";
        $h[0]['COLSPAN'] = 4;
        $h[0]['T_ALIGN'] = 'C';
        $pdf->tbDrawData($h);
        
        $pdf->tbDrawData($nl);

        $p[0]['TEXT'] = "";
        $p[1]['TEXT'] = "<small>1.</small>";
        $p[2]['TEXT'] = "<small>Kartu ini harap disimpan baik-baik dan apabila hilang agar segera melaporkan ke DPPKAD Kota Pekalongan</small>";
        $p[3]['TEXT'] = "";
        
        $p[2]['T_ALIGN'] = 'J';

        $pdf->tbDrawData($p);
        
        $p[1]['TEXT'] = "<small>2.</small>";
        $p[2]['TEXT'] = "<small>Kartu ini hendaknya dibawa apabila Saudara akan melakukan transaksi perpajakan daerah.</small>";
        $pdf->tbDrawdata($p);
        
        $p[1]['TEXT'] = "<small>3.</small>";
        $p[2]['TEXT'] = "<small>Dalam hal wajib pajak pindah domisili, supaya melaporkan ke DPPKAD Kota Pekalongan.</small>";
        $pdf->tbDrawdata($p);
            
        $pdf->tbDrawData($nl);
        $nl[0]['LN_SIZE'] = 6;
        $nl[0]['BG_COLOR'] = array(128,128,255);
        $pdf->tbDrawData($nl);
        
        $pdf->tbOuputData();
        $pdf->Output();
        exit;
    }
}
