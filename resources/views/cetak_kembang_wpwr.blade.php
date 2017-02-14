@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cetak Daftar Perkembangan WP/WR</h3>
      </div>

      <div class="title_right">
        <div class="form-group pull-right top_search">
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <form id="form_simpan" action="{{url('report/cetak_kembang_wpwr')}}" class="form-horizontal form-label-left" method="POST">
    <div class="row">
      <!-- <div class=" col-md-6 col-xs-12"> -->
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            <div class="x_title">
              <h2>Form Cetak</h2>
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

                  <div class="item form-group{{ $errors->has('tgl_data1') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_data">Tanggal Terdaftar s/d 
                    </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_data1" name="tgl_data1" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y') }}">
                    </div>
                    <div class="col-md-1 col-sm-6 col-xs-12">
                     <label class="control-label">S/D</label>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_data2" name="tgl_data2" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y') }}">
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('mengetahui') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mengetahui">Mengetahui 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="mengetahui" name="mengetahui" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                          @foreach($pejda as $key => $value)
                          <option value="{{ $key}}">{{ $value }}</option>
                          @endforeach
                      </select>
                      
                      @if ($errors->has('mengetahui'))
                          <span class="help-block">
                              <strong>{{ $errors->first('mengetahui') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                  <div class="item form-group{{ $errors->has('diperiksa') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="diperiksa">Diperiksa Oleh 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="diperiksa" name="diperiksa" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                          @foreach($pejda as $key => $value)
                          <option value="{{ $key}}">{{ $value }}</option>
                          @endforeach
                      </select>
                      
                      @if ($errors->has('diperiksa'))
                          <span class="help-block">
                              <strong>{{ $errors->first('diperiksa') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('tgl_cetak') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_cetak">Tanggal Cetak 
                    </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_cetak" name="tgl_cetak" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ (isset($post)) ? date('d/m/Y',strtotime($post-> setorpajret_tgl_bayar)) : date('d/m/Y')}}">
                      
                      @if ($errors->has('tgl_cetak'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_cetak') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-info btn-lg"><i class="fa fa-print"></i> CETAK</button>
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
