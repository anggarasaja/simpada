@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Isian SPTPD Pajak Air Tanah: 
          @if(isset($id_spt))
          <span class="label label-warning">[ Edit ]</span></h3>
          @else
          <span class="label label-success">[ Baru ]</span></h3>
          @endif
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <a href="{{ URL::to('pendataan/sptpd/8') }}" class="btn btn-info"><i class="fa fa-plus"></i> Tambah Baru</a>
              <a href="{{ URL::to('pendataan/lihat_data_airtanah') }}" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    @if(!isset($id_spt))
    <form action="{{url('pendataan/store_data_airtanah')}}" class="form-horizontal form-label-left" method="POST">
    @else
      @if(!$spr)
        <form action="{{url('pendataan/edit_data_airtanah/'.$id_spt)}}" class="form-horizontal form-label-left" method="POST">
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
        <!-- </div> -->
      </div>
      <div class="col-md-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>History Pembayaran Pajak Air Tanah</h2>
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
                      <option value="2">Official Assessment</option>
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kd_rek">Kode Rekening
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="kd_rek" id="kd_rek"  class="form-control" onchange="changeJenis()">
                        <option value="28" selected>(4.1.1.08.01.00) PAJAK AIR TANAH</option>
                        <!-- MANUAL -->
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Sumur Ke
                  </label>
                  <div class="col-md-2 col-sm-2 col-xs-12">
                    <input id="sumur" name="sumur" class="form-control" type="text" value="{{ (isset($id_spt)) ? $spt_airtanah[0]->nsumur : ''}}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="wilayah">Wilayah
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select name="wilayah" id="wilayah"  class="form-control" onchange='changewilayah(this.value)'>
                        <option>(Pilih Wilayah)</option>
                        @if(isset($id_spt))
                        <option value="1" {{ ($spt_airtanah[0]->nid_wilayah == 1) ? 'selected' : '' }}>Wilayah A</option>
                        <option value="2" {{ ($spt_airtanah[0]->nid_wilayah == 2) ? 'selected' : '' }}>Wilayah B</option>
                        <option value="3" {{ ($spt_airtanah[0]->nid_wilayah == 3) ? 'selected' : '' }}>KHUSUS</option>
                        @else
                        <option value="1">Wilayah A</option>
                        <option value="2">Wilayah B</option>
                        <option value="3">KHUSUS</option>
                        @endif
                      </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kelompok">Kelompok
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12" id="divkelompok">
                    <select name="kelompok" id="kelompok"  class="form-control" onchange="">
                        <option value="">(Pilih Jenis Reklame)</option>
                        @if(isset($id_spt))
                          @foreach($kelompok as $key)
                            @if($key->nid == $spt_airtanah[0]->nid_wilayah)
                              @if($key->nid != 6)
                                <option class="bukanpdam" value="{{$key->nid}}" selected>{{ $key->cdescription }}</option>
                              @else
                                <option disabled id="optpdam" value="{{$key->nid}}" selected>{{ $key->cdescription }}</option>
                              @endif
                            @else
                              @if($key->nid != 6)
                                <option class="bukanpdam" value="{{$key->nid}}" >{{ $key->cdescription }}</option>
                              @else
                                <option disabled id="optpdam" value="{{$key->nid}}" >{{ $key->cdescription }}</option>
                              @endif
                            @endif
                          @endforeach
                        @else
                          @foreach($kelompok as $key)
                            @if($key->nid != 6)
                              <option class="bukanpdam" value="{{$key->nid}}">{{ $key->cdescription }}</option>
                            @else
                              <option disabled id="optpdam" value="{{$key->nid}}">{{ $key->cdescription }}</option>
                            @endif
                          @endforeach
                        @endif
                      </select>
                  </div>
                </div>

                <!-- BIAYA -->
                <input type="hidden" id="biaya_dasar" name="biaya_dasar">

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Volume (M3)
                  </label>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                      <input type="text" class=" form-control" placeholder="" id="volume_m3" name="volume_m3" value="{{ (isset($id_spt)) ? $spt_airtanah[0]->nvolume : '0,00'}}">
                  </div>
                  <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group">
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
                      <td><input class="form-control" name="volume" id="volume" value="{{ (isset($id_spt)) ? $spt_airtanah[0]->nvolume : ''}}"></td>
                      <td><input class="form-control" name="harga_dasar" id="harga_dasar" value="{{ (isset($id_spt)) ? $spt_airtanah_vol[0]->ntarif : ''}}"></td>
                      <td><input class="form-control" name="tarif_pajak" id="tarif_pajak" value="{{ (isset($id_spt)) ? $spt_airtanah_vol[0]->njumlah : ''}}"></td>
                      <td><input class="form-control" name="jumlah" id="jumlah" value="{{ (isset($id_spt)) ? $spt_airtanah[0]->npajak : ''}}"></td>
                    </tr> 
                  </table>
                  </div>
                </div>


                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Pajak Terhutang</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control uang" type="text" readonly id="pajak_terhutang" name="pajak_terhutang" value="{{ (isset($id_spt)) ? $spt_airtanah[0]->npajak : ''}}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tanggal Penetapan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl_daftar" name="tgl_daftar" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($ppr[0]->netapajrek_tgl)) : date('d/m/Y') }}">
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
            url: "{{ URL::to('pendataan/gethistory/airtanah') }}/"+wp_wr_id,
            type: "GET",
            data: { 'wp_wr_id':wp_wr_id  },
          },
          columns: [
              { data: 'spt_nomor', name: 'spt_nomor' },
              { data: 'spt_periode_jual1', name: 'spt_periode_jual1' },
              { data: 'nvolume', name: 'nvolume' },
              { data: 'nsumur', name: 'nsumur' },
              { data: 'spt_pajak', name: 'spt_pajak' },
              { data: 'setorpajret_tgl_bayar', name: 'setorpajret_tgl_bayar' }, 
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
        var volume_m3 = $('#volume_m3').val();
        var persen = '20';  //BELOM TAU DARI MANA DAPAT 20 PERSEN
        var sumur = $('#sumur').val();
        var kelompok = $('#kelompok').val();
        var wilayah = $('#wilayah').val();
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/hitungAirTanah')}}",
          data: {'volume_m3' : volume_m3, 
                'sumur': sumur,
                'kelompok': kelompok,
                'wilayah': wilayah,
                'persen': persen,
                }
        }).success(function(e){
          var obj = JSON.parse(e);
          console.log(obj);
          $('#volume').val(volume_m3);
          $('#harga_dasar').val(obj[0].harga_dasar);
          $('#tarif_pajak').val(persen);
          $('#jumlah').val(obj[0].jumlah);
          $('#pajak_terhutang').val(obj[0].jumlah);
        });
      });

      function changewilayah(value){
        if (value==3) {
          $('#optpdam').prop('disabled',false);
          $('.bukanpdam').prop('disabled',true);
        }else{
          $('#optpdam').prop('disabled',true);
          $('.bukanpdam').prop('disabled',false);
        };

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
    </script>
@endpush