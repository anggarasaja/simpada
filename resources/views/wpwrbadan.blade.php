 @extends('layouts.layout')
@section('content')
  <div class="row">
      <form class="form-horizontal form-label-left" action="{{ URL::to('daftar-badan/store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <span class="section">Form Pendaftaran WP/WR Badan Usaha: <label>[Baru]</label></span>
        <div class="col-md-6">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="no_reg">No. Registrasi
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <div class="input-group">
                <input id="no_reg" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="no_reg" placeholder="" required="required" type="text">
                <span class="input-group-btn">
                  <button class="btn btn-info" type="button"><i class="fa fa-refresh" aria-hidden="true"></i></button>
                </span>
              </div>
              
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Pendaftaran 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <select class="form-control">
                <option>Wajib Pajak (P)</option>
                <option>Wajib Retribusi (R)</option>
              </select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Nama WP/WR 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="email" id="email2" name="confirm_email" data-validate-linked="email" required="required" class="form-control col-md-7 col-xs-12">
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Kecamatan 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <select class="form-control">
                <option>-- Pilih Kecamatan --</option>
                <option>--</option>
                <option>--</option>
              </select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kelurahan 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <select class="form-control">
                <option>--</option>
                <option>--</option>
                <option>--</option>
              </select>
            </div>
          </div>
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kabupaten/Kota 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input id="occupation" type="text" name="occupation" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12" value="Pekalongan">
            </div>
          </div>
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Kodepos
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="tel" id="telephone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telp">No. Telepon 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input required="required" name="telp" class="form-control col-md-7 col-xs-12" />
            </div>
          </div>
        </div>
        <!--col kanan -->
        <div class="col-md-6">
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama Pemilik  
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input id="nama" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="nama" placeholder="" required="required" type="text">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat2">Alamat
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <textarea id="alamat2" required="required" name="alamat2" class="form-control col-md-7 col-xs-12"></textarea>
            </div>
          </div>

          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Kecamatan 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <select class="form-control">
                <option>-- Pilih Kecamatan --</option>
                <option>--</option>
                <option>--</option>
              </select>
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kelurahan 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <select class="form-control">
                <option>--</option>
                <option>--</option>
                <option>--</option>
              </select>
            </div>
          </div>
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kabupaten/Kota 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input id="occupation" type="text" name="occupation" data-validate-length-range="5,20" class="optional form-control col-md-7 col-xs-12" value="Pekalongan">
            </div>
          </div>
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Kodepos
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input type="tel" id="telephone" name="phone" required="required" data-validate-length-range="8,20" class="form-control col-md-7 col-xs-12">
            </div>
          </div>
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telp">No. Telepon 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input required="required" name="telp" class="form-control col-md-7 col-xs-12" />
            </div>
          </div>
              
          <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Tgl Form Diterima WP 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
             <input  data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl-terima" name="tgl-terima" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text">
            </div>
          </div>
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Tgl Batas Kirim 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <input id="tgl-bts-kirim" name="tgl-bts-kirim" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text">
            </div>
          </div>
           <div class="item form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tgl Pendaftaran 
            </label>
            <div class="col-md-8 col-sm-6 col-xs-12">
             <input id="tgl-daftar" name="tgl-daftar" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text">
            </div>
          </div>
         
        </div>
        <div class="ln_solid"></div>
        <div class="form-group">
          <div class="col-md-6 col-md-offset-9">
            <button type="submit" class="btn btn-lg btn-primary">Cancel</button>
            <button id="send" type="submit" class="btn btn-lg btn-success">Submit</button>
          </div>
        </div>
      </form>
    
    <div class="col-md-6">
      
    </div>
  </div>
@stop

 @push('scripts')
    <script>
      $(document).ready(function() {
        
      });
    </script>
@endpush