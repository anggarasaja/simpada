@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3><i class="fa fa-print"></i>Proses Cetak BPPS :</h3>
      </div>

      <div class="title_right">
        <div class="form-group pull-right top_search">
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <form id="form_simpan" action="{{url('bkp/cetak_bpps_rek')}}" class="form-horizontal form-label-left" method="POST">
    <div class="row">
      <!-- <div class=" col-md-6 col-xs-12"> -->
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            <div class="x_title">
              <h2>Form BPPS</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
              <br>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              @if (session()->has('flash_notification.message'))
                  <div class="alert alert-{{ session('flash_notification.level') }}">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      {!! session('flash_notification.message') !!}
                  </div>
              @endif
                  <div class="item form-group{{ $errors->has('tgl_data') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_data">Tanggal Proses 
                    </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_data" name="tgl_data" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y')}}">
                      
                      @if ($errors->has('tgl_data'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_data') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="col-md-1 col-sm-6 col-xs-12">
                      <label class="control-label">s/d</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_data2" name="tgl_data2" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y')}}">
                      
                      @if ($errors->has('tgl_data2'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_data2') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('korek') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="korek">Kode Rekening 
                    </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                      <select id="korek" name="korek" class="form-control col-md-7 col-xs-12" required>
                        <option>---PILIH Kode Rekening---</option>
                          @foreach($korek as $korek)
                          <option value="{{ $korek->korek_id}}">({{ $korek->korek_tipe.$korek->korek_kelompok.$korek->korek_jenis.$korek->korek_objek }}) {{$korek->korek_nama}}</option>
                          @endforeach
                      </select>
                      
                      @if ($errors->has('korek'))
                          <span class="help-block">
                              <strong>{{ $errors->first('korek') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('bpps_via') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bpps_via">BPPS via
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                      <select id="bpps_via" name="bpps_via" class="form-control col-md-7 col-xs-12" required>
                        <option>---PILIH BPPS Via---</option>
                        <option value="1">BENDAHARA PENERIMAAN</option>
                        <option value="2">BANK</option>
                      </select>
                      
                      @if ($errors->has('bpps_via'))
                          <span class="help-block">
                              <strong>{{ $errors->first('bpps_via') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  
                  <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-print"></i> [PDF] Cetak Berdasar Per Rekening</button> <br>
                      <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-print"></i> [PDF] Cetak Berdasar Tanggal Setor -- per harian</button> <br>
                      <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-print"></i> [PDF] Cetak Berdasar Tanggal Setor -- per bulanan</button>
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      <!-- </div> -->

      </form>
    </div>
  </div>
@stop

@push('scripts')
<script>
  $(document).ready(function() {
      
  });

  function ganticamat(value){
    $.ajax({
      type: 'GET', 
      url: "{{URL::to('pendataan/getlurah')}}",
      data: {'camat_id':value}
    }).success(function(e){
      var obj = JSON.parse(e);
      $('#kelurahan').empty();
      for (var i = 0; i < obj.length; i++) {
        $('#kelurahan').append('<option value="'+obj[i].lurah_id+'">'+obj[i].lurah_kode+' || '+obj[i].lurah_nama+'</option>');
      };
    });
  }
</script>
@endpush
