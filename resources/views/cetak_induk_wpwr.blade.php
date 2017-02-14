@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cetak Daftar Induk WP/WR</h3>
      </div>

      <div class="title_right">
        <div class="form-group pull-right top_search">
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <form id="form_simpan" action="{{url('report/cetak_induk_wpwr')}}" class="form-horizontal form-label-left" method="POST">
    <div class="row">
      <!-- <div class=" col-md-6 col-xs-12"> -->
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            <div class="x_title">
              <h2>Form Cetak Daftar Kartu Data</h2>
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
                  <div class="item form-group{{ $errors->has('golongan') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="golongan">Golongan 
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <select id="golongan" name="golongan" class="form-control col-md-7 col-xs-12">
                        <option value="p">P</option>
                        <option value="r">R</option>
                      </select>
                      
                      @if ($errors->has('golongan'))
                          <span class="help-block">
                              <strong>{{ $errors->first('golongan') }}</strong>
                          </span>
                      @endif
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <select id="jenis" name="jenis" class="form-control col-md-7 col-xs-12">
                        <option value="">Semua Golongan</option>
                        <option value="1">Pribadi</option>
                        <option value="2">Badan Usaha</option>
                      </select>
                      
                      @if ($errors->has('jenis'))
                          <span class="help-block">
                              <strong>{{ $errors->first('jenis') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('usaha') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usaha">Bidang Usaha 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="usaha" name="usaha" class="form-control col-md-7 col-xs-12">
                        <option value="">Semua Bidang Usaha</option>
                          @foreach($jenis as $key)
                          <option value="{{ $key->ref_kodus_id }}">{{ $key->ref_kodus_nama }}</option>
                          @endforeach
                      </select>
                      
                      @if ($errors->has('usaha'))
                          <span class="help-block">
                              <strong>{{ $errors->first('usaha') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('kecamatan') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kecamatan">Kecamatan 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="kecamatan" name="kecamatan" onchange="ganticamat(this.value)" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                          @foreach($kecamatan as $key)
                          <option value="{{ $key->camat_id }}">{{ $key->camat_kode.' || '.$key->camat_nama }}</option>
                          @endforeach
                      </select>
                      
                      @if ($errors->has('kecamatan'))
                          <span class="help-block">
                              <strong>{{ $errors->first('kecamatan') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('kelurahan') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kelurahan">Kelurahan 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="kelurahan" name="kelurahan" class="form-control col-md-7 col-xs-12">
                      </select>
                      
                      @if ($errors->has('kelurahan'))
                          <span class="help-block">
                              <strong>{{ $errors->first('kelurahan') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>

                  <div class="item form-group{{ $errors->has('tgl_data') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_data">Tanggal Pendaftaran s/d 
                    </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_data" name="tgl_data" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ (isset($post)) ? date('d/m/Y',strtotime($post-> setorpajret_tgl_bayar)) : date('d/m/Y')}}">
                      
                      @if ($errors->has('tgl_data'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_data') }}</strong>
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
