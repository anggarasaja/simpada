@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Rekam Setoran Pajak (Self): </h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
          <div class="input-group">
              <a href="#" class="btn btn-success"><i class="fa fa-save"></i> Proses</a>
              <a href="#" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Form Rekam</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <br>
              <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="period">Period SPT
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input id="period_spt" class="form-control col-md-7 col-xs-12" type="text" name="period_spt">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="objek_pajak">Objek Pajak
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select id="objek_pajak" name="objek_pajak" required="required" class="form-control col-md-7 col-xs-12">
                          <option value="">-- Pilih Objek Pajak --</option>
                          <option value="1">Pajak Hotel</option>
                          <option value="2">Pajak Restoran</option>
                          <option value="3">Pajak Hiburan</option>
                          <option value="5">Pajak Penerangan Jalan</option>
                          <option value="6">Pajak Mineral Bukan Logam dan Batuan</option>
                          <option value="7">Pajak Parkir</option>
                          <option value="9">Pajak Sarang Burung Walet</option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label for="no_spt" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor SPT</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="no_spt" class="form-control col-md-7 col-xs-12" type="text" name="no_spt">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_sptpd">Kode SPTPD
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                     <select id="kode_sptpd" name="kode_sptpd" required="required" class="form-control col-md-7 col-xs-12">
                          <option value="8">[O] Surat Pemberitahuan Pajak Daerah</option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label for="pengenaan" class="control-label col-md-3 col-sm-3 col-xs-12">Dasar Pengenaan</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="pengenaan" class="form-control col-md-7 col-xs-12" type="text" name="pengenaan">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_setor">Tanggal Penyetoran 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl_setor" name="tgl_setor" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="via_bayar">Via Bayar 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select id="via_bayar" name="via_bayar" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                        <option value="1">[1] Bendahara Penerima</option>
                        <option value="2">[2] Bank/Kasda</option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bendahara">Bendahara
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select id="bendahara" name="bendahara" class="form-control col-md-7 col-xs-12">
                          <option value="">--</option>
                          <option value="103">BENDAHARA PENERIMAAN PEMBANTU - ERWIN FEBRIANO AMIEN </option>
                          <option value="106">BENDAHARA PPKD - SHEILA RISNA LAELI, S.IP</option>
                          <option value="112">BENDAHARA PPKD - RIZA MUTTAQIN, SE. M.SA</option>
                          <option value="110">BENDAHARA SKPD - NADIA PARAMITA, SE</option>
                          <option value="104">KASUBAG KEUANGAN - PURWANINGSIH, SE</option>
                          <option value="105">KASI PENAGIHAN DAN PELAPORAN PAJAK DAN RETRIBUSI DAERAH - AMAT SAPUAN</option>
                          <option value="102">KASI MONITORING DAN EVALUASI PAJAK DAN RETRIBUSI DAERAH - NURHASANAH, SH</option>
                          <option value="111">KEPALA BIDANG PAJAK DAN RETRIBUSI DAERAH - S U S E N O, SH.</option>
                          <option value="101">KASI PENDATAAN DAN PENETAPAN PAJAK DAN RETRIBUSI DAERAH - MOH. KARMANI, S.STP. MM.</option>
                          <option value="108">KEPALA BIDANG PAJAK DAN RETRIBUSI DAERAH - EKO PURWANTO, SH</option>
                          <option value="109">SEKRETARIS - NUR PRIYANTOMO, SE. MM</option>
                          <option value="99">KEPALA DPPKAD - BAMBANG NURDIYATMAN, SH</option>
                      </select>
                    </div>
                  </div>
            </div>
        </div>
      </div>
    </div>

  </div>
@stop

 @push('scripts')
    
@endpush