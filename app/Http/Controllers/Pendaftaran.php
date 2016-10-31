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

    public function wpwrpribadi(){
        return view('pendaftaranwpwrpribadi');
    }

    public function wpwrbadan(){
        return view('pendaftaranwpwrbadan');
    }
}
