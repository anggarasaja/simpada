<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class pendaftaranPribadiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // View::make('pendaftaranwpwrpribadi');
        $kodus = $this->getBidangUsaha();
        $kecamatan = $this->getKecamatan();
        $no_urut = $this->getNomorUrut();
        return view('pendaftaranwpwrpribadi',['kodus'=>$kodus, 'kecamatan'=>$kecamatan, 'no_urut' =>$no_urut]);
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
}
