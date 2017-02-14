@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Isian SPTPD Pajak Reklame:
          @if(isset($id_spt))
          <span class="label label-warning">[ Edit ]</span></h3>
          @else
          <span class="label label-success">[ Baru ]</span></h3>
          @endif
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <a href="{{ URL::to('pendataan/sptpd/4') }}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Baru</a>
              <a href="{{ URL::to('pendataan/lihat_data_reklame') }}" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    @if(!isset($id_spt))
    <form action="{{url('pendataan/store_data_reklame')}}" class="form-horizontal form-label-left" method="POST">
    @else
      @if(!$spr)
        <form action="{{url('pendataan/edit_data_reklame/'.$id_spt)}}" class="form-horizontal form-label-left" method="POST">
      @else
        <form class="form-horizontal form-label-left" >
      @endif    
    @endif
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            
            <div class="x_content">
              <br>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @if(!empty($tambah_spt))
                <input type="hidden" name="id_spt2" value="{{ $tambah_spt[0]->spt_id }}">
              @endif
              @if (session()->has('flash_notification.message'))
                  <div class="alert alert-{{ session('flash_notification.level') }}">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      {!! session('flash_notification.message') !!}
                  </div>
              @endif
              
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noreg">No. Reg. Pendaftaran
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <div class="input-group">
                      <input id="noreg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="noreg" placeholder="" required="required" type="text" value="{{ (isset($id_spt)) ? $spt->spt_nomor : ''}}">
                      <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="tbl-noreg"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_entry">Tanggal Entry 
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                   <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_entry" name="tgl_entry" class="date-picker form-control col-md-7 col-xs-12 active tanggal" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($spt->spt_tgl_entry)) : date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwpd">NPWPD
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input type="text" id="npwpd" name="npwpd" onchange="getnpwpd()" data-inputmask="'mask': 'P.9.9999999.99.999'" required="required" class="npwpd form-control col-md-7 col-xs-12" placeholder="P._._______.__.___" value="{{ (isset($id_spt)) ? $wp_wr->npwprd : '' }}">
                      <span class="input-group-btn">
                        <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target="#mdl1">...</button>
                      </span>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="id_wpwr" name="id_wpwr" value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_id : '' }}">
                <div class="item form-group">
                  <label for="nama_wp" class="control-label col-md-3 col-sm-3 col-xs-12">Nama WP</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_wp" class="form-control col-md-7 col-xs-12" type="text" name="nama_wp" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_nama : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="alamat" required="required" name="alamat" class="form-control col-md-7 col-xs-12" readonly>{{ (isset($id_spt)) ? $wp_wr->wp_wr_almt : '' }}</textarea>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lurah">Kelurahan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="lurah" type="text" name="lurah" class="optional form-control col-md-7 col-xs-12" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_lurah : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="camat">Kecamatan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="camat" type="text" name="camat" class="optional form-control col-md-7 col-xs-12" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_camat : '' }}">
                  </div>
                </div>
                 <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kota">Kabupaten/Kota 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="kota" type="text" name="kota" class="optional form-control col-md-7 col-xs-12" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_kabupaten : '' }}">
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>History Pembayaran Pajak Reklame</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
                <table id="tbl_hist" class="table table-striped table-bordered bulk_action hover">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>No SPT</th>
                      <th>Masa Pajak</th>
                      <th>Dasar Pengenaan</th>
                      <th>Ketetapan</th>
                      <th>Pembayaran</th>
                      <th>Tanggal Setor</th>
                      <th>Jenis</th>
                      <th>Wilayah</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
      <div class="col-md-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Sistem Pemungutan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="pemungutan" class="form-control">
                      <option value="2">Official Assessment</option>
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Masa Pajak
                  </label>
                  <div class="col-md-2 col-sm-1 col-xs-12">
                    <!-- <div class="controls form-inline"> -->
                      <input onchange="tanggal()" placeholder="dd/mm/yyyy" data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="pajak_awal" name="pajak_awal" class="date-picker form-control" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($spt->spt_periode_jual1)) : '' }}">
                  </div>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <label class="control-label">S/D</label>
                  </div>
                  <div class="col-md-2 col-sm-1 col-xs-12">
                      <input placeholder="dd/mm/yyyy" data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="pajak_akhir" name="pajak_akhir" class="date-picker form-control" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($spt->spt_periode_jual2)) : '' }}">
                    <!-- </div> -->
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Wilayah
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="nid_wilayah" name="nid_wilayah" class="form-control">
                        @foreach($wilayah as $key)
                          @if(isset($id_spt))
                            @if($spt_dt_rek[0]->nid_wilayah == $key->nid)
                            <option value="{{ $key->nid }}" selected>{{ $key->cname }}</option>
                            @else
                            <option value="{{ $key->nid }}">{{ $key->cname }}</option>
                            @endif
                          @else
                          <option value="{{ $key->nid }}">{{ $key->cname }}</option>
                          @endif
                        @endforeach

                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Jenis Reklame
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="nid_reklame" id="nid_reklame"  class="form-control" onchange="changeJenis()">
                        <option value="">(Pilih Jenis Reklame)</option>
                        @foreach($jenis_reklame as $key)
                          @if(isset($id_spt))
                            @if($spt_dt_rek[0]->nid_reklame == $key->nid)
                            <option value="{{ $key->nid }}" selected>{{ $key->cname }}</option>
                            @else
                            <option value="{{ $key->nid }}">{{ $key->cname }}</option>
                            @endif
                          @else
                          <option value="{{ $key->nid }}">{{ $key->cname }}</option>
                          @endif
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Kode Rekening
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input type="text" class="form-control" placeholder="" id="kd_rek" name="kd_rek" value="41104" readonly>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="text" placeholder="Nomor" class="form-control" id="korek_rincian" name="korek_rincian" value="{{ (isset($id_spt)) ? $korek[0]->korek_rincian : '' }}">
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <div class="input-group">
                        <input type="text" class="form-control" placeholder="Klas" id="korek_sub1" name="korek_sub1" value="{{ (isset($id_spt)) ? $korek[0]->korek_sub1 : '' }}">
                        <span class="input-group-btn">
                          <button id="modal2" class="btn btn-info" type="button" data-toggle="modal" data-target=".mdl2">...</button>
                        </span>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="id_korek" name="id_korek" value="{{ (isset($id_spt)) ? $korek[0]->korek_id : ''}}">
                <div class="item form-group">
                  <label for="korek_nama" class="control-label col-md-3 col-sm-3 col-xs-12">Nama Rekening</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="korek_nama" class="form-control col-md-7 col-xs-12" type="text" name="korek_nama" value="{{ (isset($id_spt)) ? $korek[0]->korek_nama : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_naskah" class="control-label col-md-3 col-sm-3 col-xs-12">Nama Naskah</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_naskah" class="form-control col-md-7 col-xs-12" type="text" name="nama_naskah" value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->cnaskah : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label for="lokasi" class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="lokasi" class="form-control col-md-7 col-xs-12" type="text" name="lokasi">{{ (isset($id_spt)) ? $spt_dt_rek[0]->clokasi : '' }}</textarea>
                  </div>
                </div>

                <!-- BIAYA -->
                <input type="hidden" id="biaya_dasar" name="biaya_dasar">

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Panjang
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input type="text" class=" form-control" placeholder="Panjang" id="panjang" name="panjang"  value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->npanjang : '1' }}">
                  </div>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <label class="control-label pull-right">Lebar</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="text" placeholder="Lebar" class=" form-control" id="lebar" name="lebar"  value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->nlebar : '1' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Muka
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input type="text" class=" form-control" placeholder="Muka" id="muka" name="muka" value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->nmuka : '1' }}">
                  </div>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <label class="control-label pull-right">Jumlah</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                        <input type="text" placeholder="Jumlah" class=" form-control" id="jumlah" name="jumlah" value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->njumlah : '1' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Jangka Waktu
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input type="text" class=" form-control" placeholder="Jangka Waktu" id="jangka_waktu" name="jangka_waktu" value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->njangka_waktu : '1' }}">
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="input-group">
                        <input type="text" readonly placeholder="" class="form-control" id="satuan" name="satuan"  value="{{ (isset($id_spt)) ? $spt_dt_rek[0]->cjangka_waktu : '' }}">
                        <span class="input-group-btn">
                          <button id="hitung" class="btn btn-success" type="button" data-target=".bs-example-modal-lg">Hitung</button>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">NSR
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input type="text" class="form-control" placeholder="NSR" id="nsr" name="nsr" value="{{ (isset($id_spt)) ? $spt_detail[0]->spt_dt_jumlah : '' }}">
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="input-group">
                        <input type="text" placeholder="Persen Tarif %" class="form-control" id="korek_persen_tarif" name="korek_persen_tarif" value="{{ (isset($id_spt)) ? $spt_detail[0]->spt_dt_persen_tarif : '' }}">
                        <span class="input-group-btn">
                          <button class="btn btn-default">%</button>
                        </span>
                    </div>
                  </div>
                  </div>
                <!-- </div> -->


                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Pajak Terhutang</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" type="text" readonly id="pajak_terhutang" name="pajak_terhutang" value="{{ (isset($id_spt)) ? $spt_detail[0]->spt_dt_pajak : '' }}">
                  </div>
                </div>
                <div id="divrethutang" class="item form-group" style="display:none">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Retribusi Terhutang</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" type="text" readonly id="ret_hutang" name="ret_hutang" value="{{ (isset($id_spt)) ? $tambah_spt[0]->spt_pajak : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tanggal Penetapan 
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl_daftar" name="tgl_daftar" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($ppr[0]->netapajrek_tgl)) : date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="keterangan" class="form-control col-md-7 col-xs-12" type="text" name="keterangan">{{ (isset($id_spt)) ? $spt_dt_rek[0]->keterangan_pajak : '' }}</textarea>
                  </div>
                </div>


                <div class="ln_solid"></div>
                <div class="item form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    @if(isset($id_spt))
                      @if(!$spr)
                      <button type="submit" class="btn btn-lg btn-warning"><i class="fa fa-pencil"></i> EDIT</button>
                      @endif
                    @else
                    <button type="submit" class="btn btn-lg btn-success"><i class="fa fa-save"></i> Simpan</button>
                    @endif
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </div>

    <div id="mdl1" class="modal fade bs-example-modal-lg mdl1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Tabel Referensi Wajib Pajak</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="table-npwpd" class="table table-striped table-bordered" >
              <thead>
                <tr>
                  <!-- <th>No</th> -->
                  <th>No. Pendaftaran</th>
                  <th>NPWP</th>
                  <th>No. Kartu WP/WR</th>
                  <th>Nama WP/WR</th>
                  <th>Alamat</th>
                  <th>Kelurahan</th>
                  <th>Kecamatan</th>
                  <th>Kabupaten</th>
                  <th></th>
                </tr>
              </thead>
              <tbody data-dismiss="modal"></tbody>
              </table>
            </div>

          </div>
        </div>
      </div>

      <div class="modal fade bs-example-modal-lg mdl2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Tabel Kode Rekening</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="table-rek" class="table table-striped table-bordered hover" >
              <thead>
                <tr>
                  <!-- <th>No</th> -->
                  <th>Kode Rekening</th>
                  <th>Nama Rekening</th>
                  <th>Tarif Dasar</th>
                  <th>Persen Dasar</th>
                  <th></th>
                </tr>
              </thead>
              <tbody data-dismiss="modal"></tbody>
              </table>
            </div>

          </div>
        </div>
  </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>
    var oTable ;
    var oTable2 ;
    var status = '{{$status or ''}}';
    var id_spt = '{{$id_spt or ''}}';
      $(document).ready(function() {
        if(status=='1'){
          berhasil();
        }else if(status == '2'){
          editBerhasil();
        }

        $(":input").inputmask();

        if (id_spt == '') {
          noreg();
        };

        oTable2 = $('#tbl_hist').DataTable({
          bFilter: false,
        });

        var cek_id_wpwr = $('#id_wpwr').val();
        if (cek_id_wpwr != "") {
          gethistory(cek_id_wpwr);
        };

        if (id_spt != '') {
          var nid_reklame = $('#nid_reklame').val();
          if (nid_reklame == 4 || nid_reklame == 5) {
            $('#divrethutang').show();
          }else{
            $('#divrethutang').hide();
          };
        };
      });

      $(document).on('click','#tbl-noreg', function(){
        noreg();
      });

      function berhasil(){
        new PNotify({
                title: 'BERHASIL',
                text: 'Penambahan data baru telah berhasil',
                type: 'success',
                styling: 'bootstrap3'
            });
      }

      function editBerhasil(){
        new PNotify({
                title: 'BERHASIL',
                text: 'Pengubahan data telah berhasil',
                type: 'success',
                styling: 'bootstrap3'
            });
      }

      function noreg(){
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/getnoreg')}}",
        }).success(function(e){
          $('#noreg').val(e);
        });
      }

      function getnpwpd(){
        var npwpd = $('#npwpd').val();
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/getnpwpd')}}/"+npwpd,
          data: {}
        }).success(function(e){
          var obj = JSON.parse(e);
          var id_wpwr = obj[0].wp_wr_id;
          var nama_wp = obj[0].wp_wr_nama;
          var alamat = obj[0].wp_wr_almt;
          var lurah = obj[0].wp_wr_lurah;
          var camat = obj[0].wp_wr_camat;
          var kota = obj[0].wp_wr_kabupaten;
          var id = obj[0].wp_wr_id;

          $('#id_wpwr').val(id_wpwr);
          $('#nama_wp').val(nama_wp);
          $('#alamat').val(alamat);
          $('#lurah').val(lurah);
          $('#camat').val(camat);
          $('#kota').val(kota);

          gethistory(id);
        });
      }

      $(document).on("click", "#modal", function () {
        oTable = $('#table-npwpd').DataTable();
           gettablenpwpd();
      });

      $(document).on("click", "#modal2", function () {
        oTable3 = $('#table-rek').DataTable();
           gettablerek();
      });

      function gettablerek(){
        var kd_rek = '41417';
        oTable3.destroy();
         oTable3 = $('#table-rek').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('pendataan/getrek') }}",
            type: "GET",
            data: {  'kd_rek':kd_rek },
          },
          columns: [
              { data: 'kodereken', name: 'kodereken' },
              { data: 'korek_nama', name: 'korek_nama' },
              { data: 'korek_tarif_dsr', name: 'korek_tarif_dsr' },
              { data: 'korek_persen_tarif', name: 'korek_persen_tarif' },
              { data: 'korek_id',visible:false, name: 'korek_id' },
          ],
          order: [[4,'desc']]
        });
      }

      $('#table-rek tbody').on("click", "tr td", function () {
          var sData = oTable3.row( this ).data();
          var koderek = $(this).closest("tr").children("td").eq(0).html();
          var korek_nama = $(this).closest("tr").children("td").eq(1).html();
          var korek_persen_tarif = $(this).closest("tr").children("td").eq(3).html();
          var korek_tarif_dsr = $(this).closest("tr").children("td").eq(2).html();

          var id = sData.korek_id;
          // var korek_rincian = sData.korek_rincian;
          // var korek_sub1 = sData.korek_sub1;

          $('#id_korek').val(id);
          $('#kd_rek').val('41417');
          $('#korek_nama').val(korek_nama);
          $('#korek_persen_tarif').val(korek_persen_tarif);
          // $('#korek_rincian').val(korek_rincian);
          // $('#korek_sub1').val(korek_sub1);
          
        } );

      function gettablenpwpd(){
        oTable.destroy();
         oTable = $('#table-npwpd').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('pendataan/getnpwpd/') }}",
            type: "GET",
            data: {  },
          },
          columns: [
              { data: 'no_reg', name: 'no_reg' },
              { data: 'npwprd', name: 'npwprd' },
              { data: 'wp_wr_no_kartu', name: 'wp_wr_no_kartu' },
              { data: 'wp_wr_nama', name: 'wp_wr_nama' },
              { data: 'wp_wr_almt', name: 'wp_wr_almt' },
              { data: 'wp_wr_lurah', name: 'wp_wr_lurah' },
              { data: 'wp_wr_camat', name: 'wp_wr_camat' },
              { data: 'wp_wr_kabupaten', name: 'wp_wr_kabupaten' },
              { data: 'wp_wr_id', visible:false, name: 'wp_wr_id' },
          ],
          order: [[ 0, "desc" ]]
        });
      }

      $('#table-npwpd tbody').on("click", "tr td", function () {
          var sData = oTable.row( this ).data();
          // console.log(sData );

          var npwpd = $(this).closest("tr").children("td").eq(1).html();
          var nama_wp = $(this).closest("tr").children("td").eq(3).html();
          var alamat = $(this).closest("tr").children("td").eq(4).html();
          var lurah = $(this).closest("tr").children("td").eq(5).html();
          var camat = $(this).closest("tr").children("td").eq(6).html();
          var kota = $(this).closest("tr").children("td").eq(7).html();

          var id = sData.wp_wr_id;

          $('#id_wpwr').val(id);
          $('#npwpd').val(npwpd);
          $('#nama_wp').val(nama_wp);
          $('#alamat').val(alamat);
          $('#lurah').val(lurah);
          $('#camat').val(camat);
          $('#kota').val(kota);

          gethistory(id);
        } );

      function gethistory(wp_wr_id){
        oTable2.destroy();
        oTable2 = $('#tbl_hist').DataTable({
          processing: true,
          serverSide: true, 
          bFilter: false,   
          ajax: {
            url: "{{ URL::to('pendataan/gethistory/rek') }}/"+wp_wr_id,
            type: "GET",
            data: { 'wp_wr_id':wp_wr_id  },
          },
          columns: [
              { data: 'spt_nomor', name: 'spt_nomor' },
              { data: 'spt_periode_jual1', name: 'spt_periode_jual1' },
              { data: 'spt_dt_jumlah', name: 'spt_dt_jumlah' },
              { data: 'spt_pajak', name: 'spt_pajak' },
              { data: 'setorpajret_jlh_bayar', name: 'setorpajret_jlh_bayar' }, 
              { data: 'setorpajret_tgl_bayar', name: 'setorpajret_tgl_bayar' }, 
              { data: 'jenis', name: 'jenis' },
              { data: 'wilayah', name: 'wilayah' },
              { data: 'keterangan', name: 'keterangan' },
          ],
          order: [[ 0, "desc" ]]
        });
      }

      function changeJenis(){
        var jenis = $('#nid_reklame').val();
        var wilayah = $('#nid_wilayah').val();
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/getRekening')}}",
          data: {'jenis' : jenis, 'wilayah': wilayah}
        }).success(function(e){
          var obj = JSON.parse(e);
          console.log(obj);
          $('#id_korek').val(obj[0].id_korek);
          $('#kd_rek').val('41104');
          $('#korek_nama').val(obj[0].korek_nama);
          $('#satuan').val(obj[0].satuan);
          $('#korek_rincian').val(obj[0].korek_rincian);
          $('#korek_sub1').val(obj[0].korek_sub1);
          $('#korek_persen_tarif').val(obj[0].korek_persen_tarif);
          $('#biaya_dasar').val(obj[0].biaya_dasar);
          if (jenis == 4 || jenis == 5) {
            $('#divrethutang').show();
          }else{
            $('#divrethutang').hide();
          };
        });
      }

      $(document).on("click", "#hitung", function () {
        var panjang = $('#panjang').val();
        var lebar = $('#lebar').val();
        var muka = $('#muka').val();
        var jumlah = $('#jumlah').val();
        var jangka_waktu = $('#jangka_waktu').val();
        var korek_persen_tarif = $('#korek_persen_tarif').val();
        var biaya_dasar = $('#biaya_dasar').val();
        var nid_reklame = $('#nid_reklame').val();
        var nid_wilayah = $('#nid_wilayah').val();
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/hitungReklame')}}",
          data: {'panjang' : panjang, 
                'lebar': lebar,
                'muka': muka,
                'jumlah': jumlah,
                'jangka_waktu': jangka_waktu,
                'korek_persen_tarif': korek_persen_tarif,
                'biaya_dasar': biaya_dasar,
                'nid_reklame': nid_reklame,
                'nid_wilayah': nid_wilayah,
                }
        }).success(function(e){
          var obj = JSON.parse(e);
          console.log(obj);
          $('#pajak_terhutang').val(obj[0].pajak_terhutang);
          $('#nsr').val(obj[0].nsr);
          if (nid_reklame == 4 || nid_reklame == 5) {
            $('#divrethutang').show();
          }else{
            $('#divrethutang').hide();
          };
          $('#ret_hutang').val(obj[0].ntarif);
        // $('.uang').mask('000.000.000.000.000', {reverse: false});
        });
      });

      function tanggal(){
        var awal = $('#pajak_awal').val();
        var value = awal.split('/');
        var tahun = value[2];
        var bulan = value[1];
        var tanggal = value[0];
        var akhir = new Date(tahun, bulan,  0, 23, 59, 59);
        var bulan_akhir = (akhir.getMonth() + 1);
        if (bulan_akhir < 10) {
          var bulan_akhir = '0'+bulan_akhir;
        };
        var tgl_akhir = akhir.getDate()+'/'+bulan_akhir+'/'+akhir.getFullYear();
        $('#pajak_akhir').val(tgl_akhir);
      }

    </script>
@endpush