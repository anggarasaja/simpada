@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Isian SPTPD Pajak Air Tanah: <span class="label label-success">[ Baru ]</span></h3>
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
    <div class="row">
      <div class="col-md-12 col-xs-12">
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
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input id="noreg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="noreg" placeholder="" required="required" type="text">
                      <span class="input-group-btn">
                        <button class="btn btn-info" type="button" id="tbl-noreg"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_entry">Tanggal Entry 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_entry" name="tgl_entry" class="date-picker form-control col-md-7 col-xs-12 active tanggal" required="required" type="text" value="{{ date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwpd">NPWPD
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input type="text" id="npwpd" name="npwpd" onchange="getnpwpd()" data-inputmask="'mask': 'P.9.9999999.99.999'" required="required" class="npwpd form-control col-md-7 col-xs-12" placeholder="P._._______.__.___">
                      <span class="input-group-btn">
                        <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">...</button>
                      </span>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="id_wpwr" name="id_wpwr">
                <div class="item form-group">
                  <label for="nama_wp" class="control-label col-md-3 col-sm-3 col-xs-12">Nama WP</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_wp" class="form-control col-md-7 col-xs-12" type="text" name="nama_wp" readonly>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="alamat" required="required" name="alamat" class="form-control col-md-7 col-xs-12" readonly></textarea>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lurah">Kelurahan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="lurah" type="text" name="lurah" class="optional form-control col-md-7 col-xs-12" readonly>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="camat">Kecamatan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="camat" type="text" name="camat" class="optional form-control col-md-7 col-xs-12" readonly>
                  </div>
                </div>
                 <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kota">Kabupaten/Kota 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="kota" type="text" name="kota" class="optional form-control col-md-7 col-xs-12" readonly>
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>History Pembayaran Pajak Air Bawah Tanah</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li>
              <button class="btn btn-primary btn-md pull-right">Detail History</button></li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
                <table id="tbl_hist" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <!-- <th>No</th> -->
                      <th>No SPT</th>
                      <th>Masa Pajak</th>
                      <th>Volume (m2)</th>
                      <th>Sumur Ke</th>
                      <th>Pajak Terhutang</th>
                      <th>Tanggal Setor</th>
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
                      <option value="1">Self Assessment</option>
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kd_rek">Kode Rekening
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="kd_rek" id="kd_rek"  class="form-control" onchange="changeJenis()">
                        <option value="">(Pilih Jenis Reklame)</option>
                      </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Masa Pajak
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <!-- <div class="controls form-inline"> -->
                      <input placeholder="dd/mm/yyyy" data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="pajak_awal" name="pajak_awal" class="date-picker form-control" required="required" type="text">
                  </div>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <label class="control-label">S/D</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input placeholder="dd/mm/yyyy" data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="pajak_akhir" name="pajak_akhir" class="date-picker form-control" required="required" type="text">
                    <!-- </div> -->
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Sumur Ke
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="sumur" name="sumur" class="form-control" type="text">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah">Wilayah
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="wilayah" id="wilayah"  class="form-control" onchange="changeJenis()">
                        <option value="">(Pilih Jenis Reklame)</option>
                      </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kelompok">Kelompok
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="kelompok" id="kelompok"  class="form-control" onchange="changeJenis()">
                        <option value="">(Pilih Jenis Reklame)</option>
                      </select>
                  </div>
                </div>

                <!-- BIAYA -->
                <input type="hidden" id="biaya_dasar" name="biaya_dasar">

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Volume (M3)
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" class=" form-control" placeholder="" id="volume_m3" name="volume_m3" value="0,00">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group">
                        <!-- <input type="text" readonly placeholder="" class="form-control" id="satuan" name="satuan"> -->
                        <span class="input-group-btn">
                          <button id="hitung" class="btn btn-success" type="button" data-target=".bs-example-modal-lg">Hitung</button>
                        </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                  <table id="tbl_detail" class="table table-striped table-bordered bulk_action">
                    <tr>
                      <th>Volume</th>
                      <th>Harga Dasar Air</th>
                      <th>Tarif Pajak</th>
                      <th>Jumlah (Rp)</th>
                    </tr>
                    <tr>
                      <td><input class="form-control" name="volume" id="volume"></td>
                      <td><input class="form-control" name="harga_dasar" id="harga_dasar"></td>
                      <td><input class="form-control" name="tarif_pajak" id="tarif_pajak"></td>
                      <td><input class="form-control" name="jumlah" id="jumlah"></td>
                    </tr> 
                  </table>
                  </div>
                </div>


                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Pajak Terhutang</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control uang" type="text" readonly id="pajak_terhutang" name="pajak_terhutang">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tanggal Penetapan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl-daftar" name="tgl-daftar" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y') }}">
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
      $(document).ready(function() {
        if(status=='1'){
          berhasil();
        }

        $(":input").inputmask();
        // $('.uang').mask("#.##0,00", {reverse: true});
        $('.uang').mask('000.000.000.000.000', {reverse: false});
        noreg();
        oTable2 = $('#tbl_hist').DataTable({
          bFilter: false,
        });
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
          // return false; 
        } );

      function gethistory(wp_wr_id){
        oTable2.destroy();
        oTable2 = $('#tbl_hist').DataTable({
          processing: true,
          serverSide: true, 
          bFilter: false,   
          ajax: {
            url: "{{ URL::to('pendataan/gethistory') }}/"+wp_wr_id,
            type: "GET",
            data: { 'wp_wr_id':wp_wr_id  },
          },
          columns: [
              { data: 'spt_nomor', name: 'spt_nomor' },
              { data: 'spt_periode_jual1', name: 'spt_periode_jual1' },
              { data: 'spt_dt_jumlah', name: 'spt_dt_jumlah' },
              { data: 'spt_pajak', name: 'spt_pajak' },
              { data: 'spt_pajak', name: 'spt_pajak' }, //pembayaran salah
              { data: 'spt_tgl_proses', name: 'spt_tgl_proses' }, //tgl setor salah
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
          $('#korek_nama').val(obj[0].korek_nama);
          $('#satuan').val(obj[0].satuan);
          $('#korek_rincian').val(obj[0].korek_rincian);
          $('#korek_sub1').val(obj[0].korek_sub1);
          $('#korek_persen_tarif').val(obj[0].korek_persen_tarif);
          $('#biaya_dasar').val(obj[0].biaya_dasar);
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
                }
        }).success(function(e){
          var obj = JSON.parse(e);
          console.log(obj);
          $('#pajak_terhutang').val(obj[0].pajak_terhutang);
          $('#nsr').val(obj[0].nsr);
        $('.uang').mask('000.000.000.000.000', {reverse: false});
        });
      });

    </script>
@endpush