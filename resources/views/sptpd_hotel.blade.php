@extends('layouts.layout')
@section('content')
<div class="">
    <h3>SPTPD</h3>
    <div class="clearfix"></div>

  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
      <div class="x_panel">
          <div class="x_title">
            <h2>Isian SPTPD Pajak Hotel:<small>[Baru]</small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br>
            <form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" action="{{ URL::to('daftar-badan/store') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="col-md-6">
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Reg. Pendaftaran
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="" required="required" type="text">
                      <span class="input-group-btn">
                        <button class="btn btn-info" type="button" onclick="noreg()"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tanggal Entry 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl-daftar" name="tgl-daftar" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">NPWPD
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12">
                      <span class="input-group-btn">
                        <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target=".bs-example-modal-lg">...</button>
                      </span>
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Nama WP</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="middle-name">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Alamat 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <textarea id="textarea" required="required" name="alamat" class="form-control col-md-7 col-xs-12"></textarea>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kelurahan">Kelurahan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="kelurahan" type="text" name="kelurahan" class="optional form-control col-md-7 col-xs-12">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kecamatan">Kecamatan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="kecamatan" type="text" name="kecamatan" class="optional form-control col-md-7 col-xs-12">
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

              <!-- kolom kanan -->
              <div class="col-md-6">
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pemungutan">Sistem Pemungutan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <select name="pemungutan" class="form-control">
                      <option>Self Assessment</option>
                      <option>--</option>
                      <option>--</option>
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Masa Pajak
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="controls form-inline">
                      <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="pajak_awal" name="pajak_awal" class="date-picker form-control" required="required" type="text">
                      <label>S/D</label>
                      <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="pajak_akhir" name="pajak_akhir" class="date-picker form-control" required="required" type="text">
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Kode Rekening
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="controls form-inline">
                        <input type="text" class=" form-control" placeholder="" id="kd_rek">
                        <label for="jenis">No:</label>
                        <input type="text" class=" form-control" placeholder="" id="jenis">
                        <label for="inputValue">Klas</label>
                        <input type="text" class=" form-control" placeholder="" id="klas">
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
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="">Dasar Pengenaan
                  </label>
                  <div class="col-md-8 col-sm-8 col-xs-12">
                    <div class="controls form-inline">
                        <input type="text" class=" form-control" placeholder="" id="pengenaan">
                        <label for="jenis">Persen Tarif</label>
                        <input type="text" class=" form-control" placeholder="" id="persen"> %
                    </div>
                  </div>
                </div>
                <div class="item form-group">
                  <label for="nama_rek" class="control-label col-md-3 col-sm-3 col-xs-12">Pajak Terhutang</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" type="text" disabled>
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
            </form>
          </div>
        </div>
    </div>
  </div>
</div>

<div class="clearfix"></div>

    <div class="row">
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



      <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Pilihan Nomor Kohir</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="datatable-checkbox" class="table table-striped table-bordered" >
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
              <tbody></tbody>
              </table>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->

          </div>
        </div>
      </div>
@stop

@push('scripts')
    <script>
      $(document).ready(function() {
        noreg();
        var $datatable = $('#datatable');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
      });

      function noreg(){
        var tgl = $('#tgl-daftar').val();
        $.ajax({
          url : '{{ url("getnoreg/sptpd_hotel") }}',
          type: 'GET',
          data: { 'tgl' : tgl },
        }).success(function(e){
          $('#name').val(e);
        });
      }

      $(document).on("click", "#modal", function () {
        oTable = $('#datatable-checkbox').DataTable();
           gettable();
      });

      function gettable(){
        oTable.destroy();
        var tgl = $('#tgl').val();
         oTable = $('#datatable-checkbox').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "",
            type: "GET",
            data: { 'period_spt':period_spt,
                    'objek_pajak': objek_pajak },
          },
          columns: [
              // { data: '_id', name: '_id' },
              { data: 'periode', name: 'periode' },
              { data: 'netapajrek_kohir', name: 'netapajrek_kohir'},
              { data: 'wp_wr_nama', name: 'wp_wr_nama'},
              { data: 'npwprd2', name: 'npwprd2'},
              { data: 'ketspt_singkat', name: 'ketspt_singkat'},
              { data: 'netapajrek_tgl', name: 'netapajrek_tgl'},
              { data: 'netapajrek_tgl_jatuh_tempo', name: 'netapajrek_tgl_jatuh_tempo'},
              { data: 'masa_pajak', name: 'masa_pajak'},
          ],
          order: [[ 1, "asc" ]]
        });
      }
    </script>
@endpush