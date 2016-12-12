<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class Pendataan extends Controller
{
    public function __construct(){
    	$this->middleware('auth');
    }

    public function sptpd_hotel(){
    	return view('sptpd_hotel');
    }

    public function sptpd_restoran(){
    	return view('sptpd_restoran');
    }
}
