@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Isian SPTPD Pajak Sarang Walet: 
          @if(isset($id_spt))
          <span class="label label-warning">[ Edit ]</span></h3>
          @else
          <span class="label label-success">[ Baru ]</span></h3>
          @endif
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <a href="{{ URL::to('pendataan/sptpd/8') }}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Baru</a>
              <a href="{{ URL::to('pendataan/lihat_data_sarang') }}" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    @if(!isset($id_spt))
    <form action="{{url('pendataan/store_data_sarang')}}" class="form-horizontal form-label-left" method="POST">
    @else
      @if(!$spr)
        <form action="{{url('pendataan/edit_data_sarang/'.$id_spt)}}" class="form-horizontal form-label-left" method="POST">
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
                  <div class="col-md-6 col-sm-6 col-xs-12">
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
            <h2>History Pembayaran Pajak Sarang Walet</h2>
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
                      <th>Pajak Terhutang</th>
                      <!-- <th>Pembayaran</th> -->
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Masa Pajak
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <!-- <div class="controls form-inline"> -->
                      <input onchange="tanggal()" placeholder="dd/mm/yyyy" data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="pajak_awal" name="pajak_awal" class="date-picker form-control" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($spt->spt_periode_jual1)) : '' }}">
                  </div>
                  <div class="col-md-1 col-sm-1 col-xs-12">
                    <label class="control-label">S/D</label>
                  </div>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input placeholder="dd/mm/yyyy" data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="pajak_akhir" name="pajak_akhir" class="date-picker form-control" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($spt->spt_periode_jual2)) : '' }}">
                    <!-- </div> -->
                  </div>
                </div>

                <div class="item form-group">
                  <table id="tbl_detail" class="table table-striped table-bordered">
                    <tr>
                      <th rowspan="3" style="text-align: center">Kode Rekening</th>
                      <th rowspan="3" style="text-align: center">Lokasi</th>
                      <th rowspan="2" style="text-align: center">Jumlah (Kg)</th>
                      <th rowspan="2" style="text-align: center">Tarif Dasar (Rp)</th>
                      <th rowspan="2" style="text-align: center">Dasar Pengenaan</th>
                      <th colspan="2" style="text-align: center">Pajak Nilai</th>
                      <th rowspan="3" style="text-align: center"></th>
                    </tr>
                    <tr>
                      <th style="text-align: center">%</th>
                      <th style="text-align: center">Nilai (Rp)</th>
                    </tr>
                    <tr>
                      <th style="text-align: center">(a)</th>
                      <th style="text-align: center">(b)</th>
                      <th style="text-align: center">(c = (axb))</th>
                      <th style="text-align: center">(d)</th>
                      <th style="text-align: center">(c x d)</th>
                    </tr>
                    <input type='hidden' id="no" value='{{ (isset($id_spt) ? count($spt) : 0)}}'>
                    @if(isset($id_spt))

                      @for($x = 0 ; $x < count($spt_detail) ; $x++)
                      <tr id="row{{$x}}">
                        <td><select class="form-control" id="korek.{{$x}}" name="korek[]" onchange="gantikorek(this.id,this.value)">
                          @foreach($korek as $k)
                          @if($k->korek_id == $spt_detail[$x]->spt_dt_korek)
                            <option selected value="{{ $k->korek_id }};{{ $k->korek_persen_tarif}}">({{ $k->korek_tipe.'.'.$k->korek_kelompok.'.'.$k->korek_jenis.'.'.$k->korek_objek.'.'.$k->korek_rincian.'.'.$k->korek_sub1}}) {{  $k->korek_nama}}</option>
                          @else
                            <option value="{{ $k->korek_id }};{{ $k->korek_persen_tarif}}">({{ $k->korek_tipe.'.'.$k->korek_kelompok.'.'.$k->korek_jenis.'.'.$k->korek_objek.'.'.$k->korek_rincian.'.'.$k->korek_sub1}}) {{  $k->korek_nama}}</option>
                          @endif
                          @endforeach
                        </select></td>
                        <td><input type="text" class="form-control" id="lokasi{{$x}}" name="lokasi[]" value="{{ (isset($id_spt)) ? $spt_detail[$x]->spt_dt_lokasi : ''}}"></td>
                        <td><input type="number" class="form-control" id="jumlah{{$x}}" name="jumlah[]" value="{{ (isset($id_spt)) ? $spt_detail[$x]->spt_dt_volume : ''}}" onchange="gantipajak(this.id)"></td>
                        <td><input type="number" class="form-control" id="tarif_dasar{{$x}}" name="tarif_dasar[]" value="{{ (isset($id_spt)) ? $spt_detail[$x]->spt_dt_tarif_dasar : ''}}" onchange="gantipajak(this.id)"></td>
                        <td><input type="number" class="form-control" id="dasar_pengenaan{{$x}}" name="dasar_pengenaan[]" value="{{ (isset($id_spt)) ? $spt_detail[$x]->spt_dt_jumlah : ''}}" readonly></td>
                        <td><input type="number" class="form-control" id="persen{{$x}}" name="persen[]" value="{{ $korek[0]->korek_persen_tarif }}" readonly></td>
                        <td><input type="number" class="form-control" id="pajak{{$x}}" name="pajak[]" value="{{ (isset($id_spt)) ? $spt_detail[$x]->spt_dt_pajak : ''}}" readonly></td>
                        <td><a id="hapus.{{$x}}" onclick="hapus(this.id)"><i class="fa fa-trash"></i>&nbsp; HAPUS</a></td>
                      </tr>

                      @endfor
                    @endif
                    <!-- <div id="tambah"></div> -->
                  </table>
                  <a id="btn_detail" class="btn btn-warning">Tambah Detail</a>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Total
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                      <input id="total_pajak" name="total_pajak" class="form-control" readonly type="number" value="{{ (isset($id_spt)) ? $spt->spt_pajak : '' }}">
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
            url: "{{ URL::to('pendataan/gethistory/sarang') }}/"+wp_wr_id,
            type: "GET",
            data: { 'wp_wr_id':wp_wr_id  },
          },
          columns: [
              { data: 'spt_nomor', name: 'spt_nomor' },
              { data: 'spt_periode_jual1', name: 'spt_periode_jual1' },
              { data: 'spt_dt_jumlah', name: 'spt_dt_jumlah' },
              { data: 'spt_pajak', name: 'spt_pajak' },
              { data: 'setorpajret_tgl_bayar', name: 'setorpajret_tgl_bayar' },
          ],
          order: [[ 0, "desc" ]]
        });
      }

      function gantiRek(){
        var kd_rek = $('#kd_rek').val();
        var korek_rincian = $('#korek_rincian').val();
        var korek_sub1 = $('#korek_sub1').val();
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/gantiRek')}}",
          data: {'korek_rincian':korek_rincian,
                  'korek_sub1':korek_sub1,
                  'kd_rek':kd_rek
                }
        }).success(function(e){
          // console.log(e);
          if (e.length > 2) {
            var obj = JSON.parse(e);
            var id_korek = obj[0].korek_id;
            var korek_nama = obj[0].korek_nama;
            var korek_persen_tarif = obj[0].korek_persen_tarif;

            $('#id_korek').val(id_korek);
            $('#korek_nama').val(korek_nama);
            $('#korek_persen_tarif').val(korek_persen_tarif);
          };
        });
      }

      function gantipajak(id){
        nomor = id.substr(id.length - 1);
        var jumlah = $('#jumlah'+nomor).val();
        var tarif_dasar = $('#tarif_dasar'+nomor).val();
        var dasar = jumlah*tarif_dasar;
        $('#dasar_pengenaan'+nomor).val(dasar);

        var persen = $('#persen'+nomor).val();

        var pajak = (dasar*persen)/100;
        $('#pajak'+nomor).val(pajak);
        totalpajak();
      }

      function totalpajak(){
        var total = 0;
        nomor = $('#no').val();
        for (var i = 0; i < nomor ; i++) {
          nilaipajak = $('#pajak'+i).val();
          if (nilaipajak != "" && nilaipajak != "NaN" && nilaipajak != null) {
            total = parseInt(total)+parseInt(nilaipajak);
          };
        };
        $('#total_pajak').val(total);
      }

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

      function gantikorek(id,value){
        pecah_id = id.split('.');
        nomor = pecah_id[1];
        pecah_val = value.split(';');
        persen = pecah_val[1];
        $('#persen'+nomor).val(persen);

        dp = $('#dasar_pengenaan'+nomor).val();
        if (dp != "" || dp != "NaN") {
          jumlah = (dp * persen ) / 100;
          $('#pajak'+nomor).val(jumlah);
          totalpajak();
        };
      }

      $(document).on("click", "#btn_detail", function () {
        nomor = $('#no').val();
        $('#tbl_detail').append('<tr id="row'+nomor+'">'
                            +'<td><select class="form-control" id="korek.'+nomor+'" name="korek[]" onchange="gantikorek(this.id,this.value)">'
                                +'<option>== PILIH KODE REKENING ==</option>'
                                @foreach($korek as $k)
                                  +'<option value="{{ $k->korek_id }};{{ $k->korek_persen_tarif}}">({{ $k->korek_tipe.".".$k->korek_kelompok.".".$k->korek_jenis.".".$k->korek_objek.".".$k->korek_rincian.".".$k->korek_sub1}}) {{  $k->korek_nama}}</option>'
                                @endforeach
                              +'</select></td>'
                              +'<td><input type="text" class="form-control" id="lokasi'+nomor+'" name="lokasi[]"></td>'
                              +'<td><input type="number" class="form-control" id="jumlah'+nomor+'" name="jumlah[]" onchange="gantipajak(this.id)"></td>'
                              +'<td><input type="number" class="form-control" id="tarif_dasar'+nomor+'" name="tarif_dasar[]" onchange="gantipajak(this.id)"></td>'
                              +'<td><input type="number" class="form-control" id="dasar_pengenaan'+nomor+'" name="dasar_pengenaan[]" readonly></td>'
                              +'<td><input type="number" class="form-control" id="persen'+nomor+'" name="persen[]" readonly></td>'
                              +'<td><input type="number" class="form-control" id="pajak'+nomor+'" name="pajak[]" readonly></td>'
                              +'<td><a id="hapus.'+nomor+'" onclick="hapus(this.id)"><i class="fa fa-trash"></i>&nbsp; HAPUS</a></td>'
                            +'</tr>'
                            );
        nomor = parseInt(nomor)+1;
        $('#no').val(nomor);
      });

      function hapus(id){
        swal({
          title: "Apakah Anda Yakin?",
          text: "Anda akan menghapus salah satu baris!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Hapuskan!",
          cancelButtonText: "Tidak, Batalkan!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
             swal("Deleted!", "Baris Berhasil Dihapus", "success");
             setTimeout(function() {
                   pecah_id = id.split('.');
                    nomor = pecah_id[1];
                    $('#row'+nomor).remove();
                    totalpajak();
                }, 500);
          } else {
            swal("Batal", "Proses Telah Dibatalkan", "error");
          }
        });
      }

    </script>
@endpush