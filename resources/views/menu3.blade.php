@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Rekam Setoran Pajak (LHP) : </h3>
      </div>

      <div class="title_right">
        <div class="form-group pull-right top_search">
              <!-- <a href="{{ URL::to('bkp/daftar-lhp') }}" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a> -->
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
              @if(!isset($post))
              <form id="form_simpan" action="{{url('bkp/store_menu3')}}" class="form-horizontal form-label-left" method="POST">
              @else
              <form action="{{url('bkp/update_menu3/'.$post->setorpajret_id)}}" class="form-horizontal form-label-left" method="POST">
              @endif

              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" id="spt_id" name="spt_id" >
                  <div class="item form-group{{ $errors->has('period_spt') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="period_spt">Period SPT
                    </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                      <input id="period_spt" data-inputmask="'mask': '9999'"  class="form-control col-md-7 col-xs-12" type="text" name="period_spt" value="{{ (isset($post)) ? date('Y',strtotime($post->setorpajret_tgl_bayar)) : date('Y')}}">
                     @if ($errors->has('period_spt'))
                          <span class="help-block">
                              <strong>{{ $errors->first('period_spt') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="item form-group{{ $errors->has('objek_pajak') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="objek_pajak">Objek Pajak
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="objek_pajak" name="objek_pajak" required="required" class="form-control col-md-7 col-xs-12">
                          <option value="">-- Pilih Objek Pajak --</option>
                          @if(isset($post))
                          <option value="1" {{ ($spt[0]->spt_jenis_pajakretribusi == 1) ? 'selected' : ''}}>Pajak Hotel</option>
                          <option value="2" {{ ($spt[0]->spt_jenis_pajakretribusi == 2) ? 'selected' : ''}}>Pajak Restoran</option>
                          <option value="3" {{ ($spt[0]->spt_jenis_pajakretribusi == 3) ? 'selected' : ''}}>Pajak Hiburan</option>
                          <option value="4" {{ ($spt[0]->spt_jenis_pajakretribusi == 4) ? 'selected' : ''}}>Pajak Reklame</option>
                          <option value="5" {{ ($spt[0]->spt_jenis_pajakretribusi == 5) ? 'selected' : ''}}>Pajak Penerangan Jalan</option>
                          <option value="6" {{ ($spt[0]->spt_jenis_pajakretribusi == 6) ? 'selected' : ''}}>Pajak Mineral Bukan Logam dan Batuan</option>
                          <option value="7" {{ ($spt[0]->spt_jenis_pajakretribusi == 7) ? 'selected' : ''}}>Pajak Parkir</option>
                          <option value="8" {{ ($spt[0]->spt_jenis_pajakretribusi == 8) ? 'selected' : ''}}>Pajak Air Tanah</option>
                          <option value="9" {{ ($spt[0]->spt_jenis_pajakretribusi == 9) ? 'selected' : ''}}>Pajak Sarang Burung Walet</option>
                          <option value="10" {{ ($spt[0]->spt_jenis_pajakretribusi == 10) ? 'selected' : ''}}>Retribusi Kekayaan Daerah</option>
                          @else
                          <option value="1">Pajak Hotel</option>
                          <option value="2">Pajak Restoran</option>
                          <option value="3">Pajak Hiburan</option>
                          <option value="4">Pajak Reklame</option>
                          <option value="5">Pajak Penerangan Jalan</option>
                          <option value="6">Pajak Mineral Bukan Logam dan Batuan</option>
                          <option value="7">Pajak Parkir</option>
                          <option value="8">Pajak Air Tanah</option>
                          <option value="9">Pajak Sarang Burung Walet</option>
                          <option value="10">Retribusi Kekayaan Daerah</option>
                          @endif
                      </select>
                      @if ($errors->has('objek_pajak'))
                          <span class="help-block">
                              <strong>{{ $errors->first('objek_pajak') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  
                  <div class="form-group{{ $errors->has('no_kohir') ? ' has-error' : '' }}">
                        <label class="col-sm-3 control-label">Nomor Kohir</label>

                        <div class="col-sm-3">
                          <div class="input-group">
                            <input id="no_kohir" class="form-control" type="text" name="no_kohir" value="{{ isset($post) ? $spt[0]->spt_nomor : ''}}">
                            <span class="input-group-btn">
                                <button id="modal" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" >...</button>
                            </span>
                          </div>
                      @if ($errors->has('no_kohir'))
                          <span class="help-block">
                              <strong>{{ $errors->first('no_kohir') }}</strong>
                          </span>
                      @endif
                        </div>
                  </div>

                  
                <div class="item form-group{{ $errors->has('kd_tetap') ? ' has-error' : '' }}">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kd_tetap">Kode Ketetapan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <select id="kd_tetap" name="kd_tetap" class="form-control col-md-7 col-xs-12">
                      <option value="">--</option>
                      @if(isset($post))
                        @foreach($ket as $key => $value)
                          @if($ketsingkat == $key)
                          <option value="{{ $key}}" selected>{{ $value }}</option>
                          @else
                          <option value="{{ $key}}">{{ $value }}</option>
                          @endif
                        @endforeach
                      @else
                        @foreach($ket as $key => $value)
                        <option value="{{ $key}}">{{ $value }}</option>
                        @endforeach
                      @endif
                    </select>
                  
                      @if ($errors->has('kd_tetap'))
                          <span class="help-block">
                              <strong>{{ $errors->first('kd_tetap') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>

                  <div class="item form-group{{ $errors->has('tgl_setor') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_setor">Tanggal Penyetoran 
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                     <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl_setor" name="tgl_setor" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ (isset($post)) ? date('d/m/Y',strtotime($post-> setorpajret_tgl_bayar)) : date('d/m/Y')}}">
                     @if ($errors->has('tgl_setor'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_setor') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="item form-group{{ $errors->has('via_bayar') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="via_bayar">Via Bayar 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="via_bayar" name="via_bayar" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                        @if(isset($post))
                          @foreach($viabayar as $key => $value)
                            @if($post->setorpajret_via_bayar == $key)
                            <option value="{{ $key}}" selected>{{ $value }}</option>
                            @else
                            <option value="{{ $key}}">{{ $value }}</option>
                            @endif
                          @endforeach
                        @else
                          @foreach($viabayar as $key => $value)
                          <option value="{{ $key}}">{{ $value }}</option>
                          @endforeach
                        @endif
                      </select>
                    
                      @if ($errors->has('via_bayar'))
                          <span class="help-block">
                              <strong>{{ $errors->first('via_bayar') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="ln_solid"></div>

                  <div class="form-group">
                    <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                        <a id="save" type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Proses</a>
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
              <h4 class="modal-title" id="myModalLabel">Pilihan Nomor Kohir</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="table-kohir" class="table table-striped table-bordered" >
              <thead>
                <tr>
                  <!-- <th>No</th> -->
                  <th>No SPT</th>
                  <th>Periode</th>
                  <th>Periode Jual</th>
                  <th>Kode Rekening</th>
                  <th>NPWPD / NPWRD</th>
                  <th>Nama Wajib Pajak</th>
                  <th>Jumlah Pajak</th>
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
    var post = "{{ isset($post) ? $post->setorpajret_id : ''}}"
      $(document).ready(function() {
        oTable = $('#table-kohir').DataTable();
        $(":input").inputmask();

        if (post != '') {

        };
      });

      $(document).on("click", "#modal", function () {
           gettable();
      });

      $(document).on("click", "#save", function (e){
          e.preventDefault();
          var self = $(this);
           swal({
            title: 'Are you sure?',
            text: "Proses Penyetoran?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, save it!',
            closeOnCancel: false
          },
            function(isConfirm){
              if (isConfirm) {
                $("#form_simpan").submit();
              } else {
                swal("Batal", "Proses Telah Dibatalkan", "error");
              }
          });
      });

      $('#table-kohir tbody').on("click", "tr td", function () {
          var sData = oTable.row( this ).data();          
          var spt_id = sData.spt_id;
          var spt_nomor = $(this).closest("tr").children("td").eq(0).html();
          var spt_pajak = $(this).closest("tr").children("td").eq(6).html();
          $('#no_kohir').val(spt_nomor);
          $('#pajak').val(spt_pajak);
          $('#spt_id').val(spt_id);
          
          $.ajax({
            type: "GET",
            url: "{{url('bkp/getpajak')}}",
            data: {'spt_id':spt_id}
          }).success(function(e){
            console.log(e);
            $('#dasar_pengenaan').val(e);
          });

        } );

      function gettable(){
        oTable.destroy();
        var period_spt = $('#period_spt').val();
        var objek_pajak = $('#objek_pajak').val();
         oTable = $('#table-kohir').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('getkohir3') }}",
            type: "GET",
            data: { 'period_spt':period_spt,
                    'objek_pajak': objek_pajak },
          },
          columns: [
              // { data: '_id', name: '_id' },
              { data: 'spt_nomor', name: 'spt_nomor' },
              { data: 'spt_periode', name: 'spt_periode' },
              { data: 'masa_pajak', name: 'masa_pajak'},
              { data: 'korek', name: 'korek'},
              { data: 'npwprd', name: 'npwprd'},
              { data: 'wp_wr_nama', name: 'wp_wr_nama'},
              { data: 'spt_pajak', name: 'spt_pajak'},
              { data: 'spt_id', visible: false,name: 'spt_id'},
          ],
          order: [[ 1, "asc" ]]
        });
      }
    </script>
@endpush