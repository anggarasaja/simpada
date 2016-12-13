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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="period_tetap">Period Penetapan
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input id="period_tetap" class="form-control col-md-7 col-xs-12" type="text" name="period_tetap">
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
                          <option value="4">Pajak Reklame</option>
                          <option value="5">Pajak Penerangan Jalan</option>
                          <option value="6">Pajak Mineral Bukan Logam dan Batuan</option>
                          <option value="7">Pajak Parkir</option>
                          <option value="8">Pajak Air Tanah</option>
                          <option value="10">Retribusi Kekayaan Daerah</option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label for="no_kohir" class="control-label col-md-3 col-sm-3 col-xs-12">Nomor Kohir</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="no_kohir" class="form-control col-md-7 col-xs-12" type="text" name="no_kohir">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kode_sptpd">Kode Ketetapan
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                     <select id="kode_sptpd" name="kode_sptpd" required="required" class="form-control col-md-7 col-xs-12">
                          <option value="">--</option>
                          <option value="8">[O] Surat Pemberitahuan Pajak Daerah</option>
                          <option value="2">[D] Surat Ketetapan Pajak Daerah Tambahan</option>
                          <option value="1">[B] Surat Ketetapan Pajak Daerah</option>
                          <option value="4">[G] STRD</option>
                          <option value="3">[F] STPD</option>
                          <option value="12">[L] Surat Ketetapan Pajak Daerah Lebih Bayar</option>
                          <option value="14">[N] Surat Ketetapan Pajak Daerah Nihil</option>
                          <option value="9">[R] Surat Ketetapan Retribusi Daerah</option>
                          <option value="11">[K] Surat Ketetapan Pajak Daerah Kurang Bayar</option>
                          <option value="5">[H] SKRDKB</option>
                          <option value="17">[P] Surat Ketetapan Retribusi Daerah Tambahan</option>
                      </select>
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
            </div>
        </div>
      </div>
    </div>

  </div>
@stop

 @push('scripts')
    
@endpush