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

    <form id="form_simpan" action="{{url('spt/cetak')}}" class="form-horizontal form-label-left" method="POST">
    <div class="row">
      <!-- <div class=" col-md-6 col-xs-12"> -->
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            <div class="x_title">
              <h2>Form Cetak Daftar Kartu Data</h2>
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
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="golongan">Objek Pajak 
                    </label>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                      <select id="objek_pajak" name="objek_pajak" class="form-control col-md-7 col-xs-12">
                        <option value="4">Pajak Reklame</option>
                        <option value="8">Pajak Air Tanah</option>
                      </select>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usaha">Jenis Ketetapan 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select id="jenis_ketetapan" name="jenis_ketetapan" class="form-control col-md-7 col-xs-12">
                        <option value="">== Pilih Jenis Ketetapan ==</option>
                        @foreach($ketetapan as $key => $value)
                          <option value="{{ $value->ketspt_id}}">{{ "[".$value->ketspt_singkat."]: ".$value->ketspt_ket }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usaha">Periode SPT 
                    </label>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                      <input id="periode_spt" name="periode_spt" type="text" class="form-control col-md-7 col-xs-12" value="{{date('Y')}}"></input>
                    </div>
                  </div>


                  

                  <div class="item form-group{{ $errors->has('tgl_data') ? ' has-error' : '' }}">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_data">Tanggal Penetapan
                    </label>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_awal" name="tgl_awal" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y')}}">
                      
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
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_akhir" name="tgl_akhir" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="{{ date('d/m/Y')}}">
                      
                      @if ($errors->has('tgl_data2'))
                          <span class="help-block">
                              <strong>{{ $errors->first('tgl_data2') }}</strong>
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
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usaha">Nama Petugas 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="operator" name="operator" type="text" class="form-control col-md-7 col-xs-12" value="{{$session_user['staff_user']}}" readonly></input>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usaha">Jabatan 
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="jabatan" name="jabatan" type="text" class="form-control col-md-7 col-xs-12" value="{{$session_user['staff_name']}}" readonly></input>
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-info" value="pdf" name="button_val"><i class="fa fa-print"></i> CETAK PDF</button>
                      <button type="submit" class="btn btn-info" value="excel" name="button_val"><i class="fa fa-print"></i> CETAK EXCEL</button>
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
