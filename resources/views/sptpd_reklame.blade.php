@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Isian SPTPD Pajak Reklame: <span class="label label-success">[ Baru ]</span></h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <a href="#" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Baru</a>
              <a href="#" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    @if(!isset($post))
    <form action="{{url('pendataan/store_data_reklame')}}" class="form-horizontal form-label-left" method="POST">
    @else
    <form action="{{url('')}}" class="form-horizontal form-label-left" method="POST">
    @endif
    <div class="row col-md-6">
      <div class="col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            
            <div class="x_content">
              <br>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" id="setorpajret_id_penetapan" name="setorpajret_id_penetapan" >
              @if (session()->has('flash_notification.message'))
                  <div class="alert alert-{{ session('flash_notification.level') }}">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      {!! session('flash_notification.message') !!}
                  </div>
              @endif
              
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noreg">No. Reg. Pendaftaran
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input id="noreg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" noreg="noreg" placeholder="" required="required" type="text">
                      <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="tbl-noreg"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_entry">Tanggal Entry 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl_entry" name="tgl_entry" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwpd">NPWPD
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input type="text" id="npwpd" name="npwpd" onchange="getnpwpd()" data-inputmask="'mask': 'P.9.9999999.99.999'" required="required" class="npwpd form-control col-md-7 col-xs-12">
                      <span class="input-group-btn">
                        <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">...</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_wp" class="control-label col-md-3 col-sm-3 col-xs-12">Nama WP</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_wp" class="form-control col-md-7 col-xs-12" type="text" name="nama_wp">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <textarea id="alamat" required="required" name="alamat" class="form-control col-md-7 col-xs-12"></textarea>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lurah">Kelurahan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="lurah" type="text" name="lurah" class="optional form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="camat">Kecamatan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="camat" type="text" name="camat" class="optional form-control col-md-7 col-xs-12">
                  </div>
                </div>
                 <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kota">Kabupaten/Kota 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="kota" type="text" name="kota" class="optional form-control col-md-7 col-xs-12">
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
      <!-- </form> -->
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>History Pembayaran Pajak Hotel</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <th colspan="3"><center>History Pembayaran Pajak Hotel</center></th>
                      <th><center>Detail History WP</center></th>
                    </tr>
                    <tr>
                      <th>Masa Pajak</th>
                      <th>Dasar Pengenaan</th>
                      <th>Pajak Terhutang</th>
                      <th>Tanggal Penyetoran</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row col-md-6">
      <div class=" col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            
            <div class="x_content">

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Sistem Pemungutan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <select name="pemungutan" class="form-control">
                      <option>Self Assessment</option>
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Masa Pajak
                  </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <!-- <div class="controls form-inline"> -->
                      <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="pajak_awal" name="pajak_awal" class="date-picker form-control" required="required" type="text">
                  </div>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <label>S/D</label>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="pajak_akhir" name="pajak_akhir" class="date-picker form-control" required="required" type="text">
                    <!-- </div> -->
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Wilayah
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <select name="nid_wilayah" class="form-control">
                        <option value="1">A. Central Bisnis Distrik</option>
                        <option value="2">B. Central Distrik</option>
                        <option value="3">C. Campuran</option>
                        <option value="4">D. Dalam Pusat Pertokoan/Perdagangan Pasar/Stasiun/Terminal</option>
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Jenis Reklame
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <select name="nid_reklame" id="nid_reklame"  class="form-control">
                        <option value="">(Pilih Jenis Reklame)</option>
                          <option value="1">SS (Shop Sign)</option>
                          <option value="2">BTS</option>
                          <option value="3">NBTS / BTS SINAR</option>
                          <option value="4">BTN</option>
                          <option value="5">NBTN / BTN SINAR</option>
                          <option value="6">BERJALAN</option>
                          <option value="7">WALL PAINTING</option>
                          <option value="8">SPANDUK HARIAN</option>
                          <option value="9">SPANDUK MINGGUAN</option>
                          <option value="10">SPANDUK BULANAN</option>
                          <option value="11">UMBUL - UMBUL HARIAN</option>
                          <option value="12">UMBUL - UMBUL MINGGUAN</option>
                          <option value="13">UMBUL - UMBUL BULANAN</option>
                          <option value="14">BANER HARIAN</option>
                          <option value="15">BANER MINGGUAN</option>
                          <option value="16">BANER BULANAN</option>
                          <option value="17">BALIHO HARIAN</option>
                          <option value="18">BALIHO MINGGUAN</option>
                          <option value="19">BALIHO BULANAN</option>
                          <option value="20">POSTER / STICKER</option>
                          <option value="21">SELEBARAN TIDAK BERWARNA</option>
                          <option value="22">SELEBARAN BERWARNA</option>
                          <option value="23">UDARA MINGGUAN</option>
                          <option value="24">UDARA BULANAN</option>
                          <option value="25">FILM</option>
                          <option value="26">LAYAR TOKO / WARUNG / SUN SCREEN</option>
                          <option value="27">FLAG CHAIN</option>
                          <option value="28">BANDO</option>
                  </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Kode Rekening
                  </label>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <input type="text" class=" form-control" placeholder="" id="kd_rek" readonly>
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                        <input type="text" placeholder="Nomor" class=" form-control" id="jenis">
                  </div>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                      <div class="input-group">
                        <input type="text" class=" form-control" placeholder="Klas" id="klas">
                        <span class="input-group-btn">
                          <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">...</button>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Nama Rekening</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_rek" class="form-control col-md-7 col-xs-12" type="text" name="nama_rek">
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Nama Naskah</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_rek" class="form-control col-md-7 col-xs-12" type="text" name="nama_rek">
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Lokasi</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="nama_rek" class="form-control col-md-7 col-xs-12" type="text" name="nama_rek"></textarea>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Hitungan
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" class=" form-control" placeholder="Panjang" id="kd_rek">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" placeholder="Lebar" class=" form-control" id="jenis">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" class=" form-control" placeholder="Muka" id="kd_rek">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" placeholder="Jumlah" class=" form-control" id="jenis">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Jangka Waktu
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" class=" form-control" placeholder="" id="kd_rek">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group">
                        <input type="text" readonly placeholder="" class=" form-control" id="jenis">
                        <span class="input-group-btn">
                          <button id="modal" class="btn btn-success" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">Hitung</button>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">NSR
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" class=" form-control" placeholder="" id="kd_rek">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" readonly placeholder="Persen Tarif %" class="form-control" id="jenis">
                    </div>
                  </div>
                </div>


                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Pajak Terhutang</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control" type="text" readonly>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tanggal Penetapan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl-daftar" name="tgl-daftar" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Keterangan</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="nama_rek" class="form-control col-md-7 col-xs-12" type="text" name="nama_rek"></textarea>
                  </div>
                </div>


                <div class="ln_solid"></div>
                <div class="item form-group">
                  <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Cancel</button>
                    <button type="submit" class="btn btn-success">Simpan</button>
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      </div>

    </div>
  </div>

  <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
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
      $(document).ready(function() {
        $(":input").inputmask();
        // $(".npwpd").mask('P.9.9999999.99.9');
        noreg();
      });

      $(document).on('click','#tbl-noreg', function(){
        noreg();
      });

      function noreg(){
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/getnoreg')}}",
        }).success(function(e){
          $('#noreg').val(e);
        });
      }

      function getnpwpd(){
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/getnoreg')}}",
          data: {}
        }).success(function(e){
          $('#noreg').val(e);
        });
      }

      $(document).on("click", "#modal", function () {
        oTable = $('#table-npwpd').DataTable();
           gettablenpwpd();
      });

      function gettablenpwpd(){
        oTable.destroy();
         oTable = $('#table-npwpd').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('pendataan/getnpwpd') }}",
            type: "GET",
            data: {  },
          },
          columns: [
              { data: 'wp_wr_no_form', name: 'wp_wr_no_form' },
              { data: 'npwprd', name: 'npwprd' },
              { data: 'wp_wr_no_kartu', name: 'wp_wr_no_kartu' },
              { data: 'wp_wr_nama', name: 'wp_wr_nama' },
              { data: 'wp_wr_almt', name: 'wp_wr_almt' },
              { data: 'wp_wr_lurah', name: 'wp_wr_lurah' },
              { data: 'wp_wr_camat', name: 'wp_wr_camat' },
              { data: 'wp_wr_kabupaten', name: 'wp_wr_kabupaten' },
          ],
          // order: [[ 1, "asc" ]]
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


          $('#npwpd').val(npwpd);
          $('#nama_wp').val(nama_wp);
          $('#alamat').val(alamat);
          $('#lurah').val(lurah);
          $('#camat').val(camat);
          $('#kota').val(kota);
          // return false; 
        } );
    </script>
@endpush