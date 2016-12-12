<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pribadi = DB::table('wp_wr')
                    ->where("wp_wr_gol","=",1)
                    ->count();
        $bu = DB::table('wp_wr')
                    ->where("wp_wr_gol","=",2)
                    ->count();
        //SPT
        $tablesSPT = 'v_penetapan_pajak_retribusi AS a';

        $relationsSPT = " (a.netapajrek_jenis_ketetapan NOT IN (".Setting::get('status_stpd').",".Setting::get('status_strd').") OR  a.netapajrek_jenis_ketetapan  IS NULL) ";
        


        $SPT = DB::table($tablesSPT)
            ->whereRaw($relationsSPT)
            ->count();
        //SPT
        //LHP
        $tablesLHP = 'v_laporan_hasil_pemeriksaan';

        $relationsLHP = "koderek::text not in ('41202','41104','41108')";
        $LHP = DB::table($tablesLHP)
            ->whereRaw($relationsLHP)
            ->count();
        //LHP
        //BANK
        $tablesBANK = 'setoran_ke_bank_header';

        $relationsBANK = "";
        $BANK = DB::table($tablesBANK)
            ->count();
        //LHP
        return view('home',[
            'pribadi'=>$pribadi,
            'bu' => $bu,
            'spt' => $SPT,
            'lhp' => $LHP,
            'bank' =>$BANK,
            ]);
    }
}
