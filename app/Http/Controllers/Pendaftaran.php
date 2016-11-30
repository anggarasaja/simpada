<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\bank;

class Pendaftaran extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    ### PRIBADI ###

    public function wpwrpribadi(){
        return view('pendaftaranwpwrpribadi');
    }

    public function show_wpwrpribadi(){
        return view('show_wpwrpribadi');
    }

    public function store_wpwrpribadi(){

    }

    ### BADAN USAHA  ####

    public function wpwrbadan(){
        return view('wpwrbadan');
    }

    public function show_wpwrbadan(){
        return view('show_wpwrbadan');
    }

    public function store_wpwrbadan(){

    }

    ### CETAK KARTU ####

    public function cetak_kartu(){
        return view('cetak_kartu');
    }
}
