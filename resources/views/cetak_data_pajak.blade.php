@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cetak Kartu Data {{ $getpajak[0]->ref_jenparet_ket }}
      </div>

      <div class="title_right">
      </div>
    </div>
    <div class="clearfix"></div>

    <form action="{{url('pendataan/proses_cetak_kartu_data')}}" class="form-horizontal form-label-left" method="POST">

    <div class="row">
      <div class="col-md-12 col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            
            <div class="x_content">
              <br>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" id="id_pajak" name="id_pajak" value="{{$id_pajak}}" >
              @if (session()->has('flash_notification.message'))
                  <div class="alert alert-{{ session('flash_notification.level') }}">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      {!! session('flash_notification.message') !!}
                  </div>
              @endif
              
                <div class="item form-group{{ $errors->has('period') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="period">Period
                  </label>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                    <input id="period" data-inputmask="'mask': '9999'"  class="form-control col-md-7 col-xs-12" type="text" name="period" value="{{ (isset($post)) ? date('Y',strtotime($post->setorpajret_tgl_bayar)) : date('Y')}}">
                   @if ($errors->has('period'))
                        <span class="help-block">
                            <strong>{{ $errors->first('period') }}</strong>
                        </span>
                    @endif
                  </div>
                </div>

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwpd">NPWPD
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input type="text" id="npwpd" name="npwpd" data-inputmask="'mask': 'P.9.9999999.99.999'" required="required" class="npwpd form-control col-md-7 col-xs-12" placeholder="P._._______.__.___" value="{{ (isset($id_spt)) ? $wp_wr->npwprd : '' }}">
                      <span class="input-group-btn">
                        <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target="#mdl1">...</button>
                      </span>
                    </div>
                  </div>
                </div>

                <input type="hidden" id="id_wpwr" name="id_wpwr">

                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mengetahui">Mengetahui
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="mengetahui" name="mengetahui" class="form-control">
                      @foreach($pejabat as $key)
                      <option value="{{$key->pejda_id}}">{{$key->ref_japeda_nama.' - '.$key->pejda_nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="diperiksa">Diperiksa Oleh
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="diperiksa" name="diperiksa" class="form-control">
                      @foreach($pejabat as $key)
                      <option value="{{$key->pejda_id}}">{{$key->ref_japeda_nama.' - '.$key->pejda_nama}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <a href="#" class="btn btn-info btn-lg"><i class="fa fa-print"></i> CETAK</a>
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
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
            <table id="table-npwpd" class="table table-striped table-bordered hover" >
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
      $(document).ready(function() {
        $(":input").inputmask();
      });

      $(document).on("click", "#modal", function () {
        oTable = $('#table-npwpd').DataTable();
           gettablenpwpd();
      });

      function gettablenpwpd(){
        var id_pajak = $('#id_pajak').val();
        var tahun = $('#period').val();
        oTable.destroy();
         oTable = $('#table-npwpd').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('bkp/getnpwpd/') }}",
            type: "GET",
            data: { 'id_pajak':id_pajak,
                    'tahun':tahun},
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
          var npwpd = $(this).closest("tr").children("td").eq(1).html();
          var id = sData.wp_wr_id;
          $('#id_wpwr').val(id);
          $('#npwpd').val(npwpd);
        } );

      
    </script>
@endpush