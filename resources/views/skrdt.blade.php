@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>CETAK MEDIA PENETAPAN SKRDT</h3>
      </div>

      <div class="title_right">
        <div class="form-group pull-right top_search">
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <form action="{{url('skrdt/cetak')}}" class="form-horizontal form-label-left" method="POST">

    <div class="row">
      <!-- <div class=" col-md-6 col-xs-12"> -->
        <div class="col-md-12 col-sm-12 col-xs-12">
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
                  <div class="item form-group{{ $errors->has('tahun') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tahun">Tahun Penetapan
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="tahun" data-inputmask="'mask': '9999'"  class="form-control col-md-7 col-xs-12" type="text" name="tahun" value="{{ date('Y') }}">
                     @if ($errors->has('tahun'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tahun') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="item form-group{{ $errors->has('objek_pajak') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="objek_pajak">Objek Pajak
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="objek_pajak" name="objek_pajak" class="form-control col-md-7 col-xs-12">
                            <option value="">-- Pilih Objek Pajak --</option>
                            @foreach($jenis as $key => $value)
                            <option value="{{ $key }}">{{$value}}</option>
                            @endforeach
                      </select>
                      @if ($errors->has('objek_pajak'))
                          <span class="help-block">
                              <strong>{{ $errors->first('objek_pajak') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="item form-group{{ $errors->has('tgl_tetap') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_tetap">Tanggal Penetapan 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_tetap" name="tgl_tetap" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ (isset($post)) ? date('d/m/Y',strtotime($post-> setorpajret_tgl_bayar)) : date('d/m/Y')}}">
                      
                      @if ($errors->has('tgl_tetap'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_tetap') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="form-group{{ $errors->has('no_kohir1') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Nomor Kohir</label>

                        <div class="col-sm-2">
                          <div class="input-group">
                            <input id="no_kohir1" class="form-control" type="text" name="no_kohir1" value="">
                            <span class="input-group-btn">
                                <button id="modal" type="button" class="btn btn-primary" data-toggle="modal" data-target=".satu" >...</button>
                            </span>
                          </div>
                        </div>
                        <div class="col-sm-1">
                          <label>S/D</label>
                        </div>
                        <div class="col-sm-2">
                          <div class="input-group">
                            <input id="no_kohir2" class="form-control" type="text" name="no_kohir2" value="">
                            <span class="input-group-btn">
                                <button id="modal2" type="button" class="btn btn-primary" data-toggle="modal" data-target=".dua" >...</button>
                            </span>
                          </div>
                        </div>
                  </div>
                  
                  <div class="item form-group{{ $errors->has('pejabat') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pejabat">Pejabat 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="pejabat" name="pejabat" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                          @foreach($pejda as $key => $value)
                          <option value="{{ $key}}">{{ $value }}</option>
                          @endforeach
                      </select>
                      
                      @if ($errors->has('pejabat'))
                          <span class="help-block">
                              <strong>{{ $errors->first('pejabat') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-print"></i> CETAK SKRDT</button>
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
    <!-- </form> -->

      <div class="modal satu fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Pilihan Nomor Kohir</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="table-kohir" class="table table-striped table-bordered" >
              <thead>
                <tr>
                  <!-- <th>No</th> -->
                  <th>Periode</th>
                  <th>Kohir</th>
                  <th>Nama Wajib Pajak</th>
                  <th>NPWPD / NPWRD</th>
                  <th>Ketetapan</th>
                  <th>Tgl. Penetapan</th>
                  <th>Tgl. Jatuh Tempo</th>
                  <th>Jml. Penetapan</th>
                  <th>Masa Pajak</th>
                  <th></th>
                </tr>
              </thead>
              <tbody data-dismiss="modal"></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="modal dua fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Pilihan Nomor Kohir</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="table-kohir2" class="table table-striped table-bordered" >
              <thead>
                <tr>
                  <th>Periode</th>
                  <th>Kohir</th>
                  <th>Nama Wajib Pajak</th>
                  <th>NPWPD / NPWRD</th>
                  <th>Ketetapan</th>
                  <th>Tgl. Penetapan</th>
                  <th>Tgl. Jatuh Tempo</th>
                  <th>Jml. Penetapan</th>
                  <th>Masa Pajak</th>
                  <th></th>
                </tr>
              </thead>
              <tbody data-dismiss="modal"></tbody>
              </table>
            </div>
          </div>
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
        oTable = $('#table-kohir').DataTable();
        oTable2 = $('#table-kohir2').DataTable();
        $(":input").inputmask();
      });

      $(document).on("click", "#modal", function () {
           gettable();
      });

      $('#table-kohir tbody').on("click", "tr td", function () {
          var sData = oTable.row( this ).data();
          var no_kohir = $(this).closest("tr").children("td").eq(1).html();
          $('#no_kohir1').val(no_kohir);
      });

      function gettable(){
        oTable.destroy();
        var period_spt = $('#tahun').val();
        var objek_pajak = $('#objek_pajak').val();
         oTable = $('#table-kohir').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('ketetapan/getkohir') }}",
            type: "GET",
            data: { 'period_spt':period_spt,
                    'objek_pajak': objek_pajak },
          },
          columns: [
              // { data: '_id', name: '_id' },
              { data: 'periode', name: 'periode' },
              { data: 'netapajrek_kohir', name: 'netapajrek_kohir'},
              { data: 'wp_wr_nama', name: 'wp_wr_nama'},
              { data: 'npwprd', name: 'npwprd'},
              { data: 'ketspt_singkat', name: 'ketspt_singkat'},
              { data: 'netapajrek_tgl', name: 'netapajrek_tgl'},
              { data: 'netapajrek_tgl_jatuh_tempo', name: 'netapajrek_tgl_jatuh_tempo'},
              { data: 'spt_pajak', name: 'spt_pajak'},
              { data: 'masa_pajak', name: 'masa_pajak'},
              { data: 'netapajrek_id_spt', visible: false,name: 'netapajrek_id_spt'},
          ],
          order: [[ 1, "asc" ]]
        });
      }


      $(document).on("click", "#modal2", function () {
           gettable2();
      });

      $('#table-kohir2 tbody').on("click", "tr td", function () {
          var sData = oTable2.row( this ).data();
          var no_kohir = $(this).closest("tr").children("td").eq(1).html();
          $('#no_kohir2').val(no_kohir);
      });

      function gettable2(){
        oTable2.destroy();
        var period_spt = $('#tahun').val();
        var objek_pajak = $('#objek_pajak').val();
         oTable2 = $('#table-kohir2').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('ketetapan/getkohir') }}",
            type: "GET",
            data: { 'period_spt':period_spt,
                    'objek_pajak': objek_pajak },
          },
          columns: [
              // { data: '_id', name: '_id' },
              { data: 'periode', name: 'periode' },
              { data: 'netapajrek_kohir', name: 'netapajrek_kohir'},
              { data: 'wp_wr_nama', name: 'wp_wr_nama'},
              { data: 'npwprd', name: 'npwprd'},
              { data: 'ketspt_singkat', name: 'ketspt_singkat'},
              { data: 'netapajrek_tgl', name: 'netapajrek_tgl'},
              { data: 'netapajrek_tgl_jatuh_tempo', name: 'netapajrek_tgl_jatuh_tempo'},
              { data: 'spt_pajak', name: 'spt_pajak'},
              { data: 'masa_pajak', name: 'masa_pajak'},
              { data: 'netapajrek_id_spt', visible: false,name: 'netapajrek_id_spt'},
          ],
          order: [[ 1, "asc" ]]
        });
      }
    </script>
@endpush