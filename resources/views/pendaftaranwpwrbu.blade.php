 @extends('layouts.layout')
@section('content')
<?php 
  $wp_wr_jenis = (isset($wp_wr_jenis))?$wp_wr_jenis:'';
  $wp_wr_kd_camat = (isset($wp_wr_kd_camat))?$wp_wr_kd_camat:'';
  $wp_wr_wn = (isset($wp_wr_wn))?$wp_wr_wn:'';
  $wp_wr_jns_tb = (isset($wp_wr_jns_tb))?$wp_wr_jns_tb:'';
  $wp_wr_pekerjaan = (isset($wp_wr_pekerjaan))?$wp_wr_pekerjaan:'';
?>
  <div class="">
            <div class="clearfix"></div>

            <div class="row">

              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <span class="section">Form Pendaftaran WP/WR Badan Usaha: <label>{{$jenis or ''}}</label>  
                  <?php if(isset($wp_wr_id)){ ?>
                  <span class="label label-success" style="padding: .3em">{{strtoupper($wp_wr_jenis)}}.{{$wp_wr_gol or ''}}.{{$wp_wr_no_urut or ''}}.{{$camat_kode or ''}}.{{$lurah_kode or ''}}</span>
                  <?php } ?>
                  </span>
                  <form class="form-horizontal form-label-left" method="POST" action="{{ URL::to('daftar-bu/store') }}">
                  <div class="x_content">


                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">IDENTITAS</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">BIDANG USAHA</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">JENIS PRIJINAN</a>
                        </li>
                      </ul>

                      <div id="myTabContent" class="tab-content">

                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                          
                           <div class="x_panel">
                            <div class="col-md-6">
                              <input type="hidden" name="jenis" value="{{$jenis or ''}}" readonly="true">
                              <input type="hidden" name="wp_wr_id" value="{{$wp_wr_id or ''}}" readonly="true">
                              <input type="hidden" name="wp_wr_gol" value="{{$wp_wr_gol or '2'}}" size="1" maxlength="1" readonly="true">
                              <input type="hidden" name="wp_wr_tgl_form_kembali" id="wp_wr_tgl_form_kembali" data-provide="datepicker" data-date-format="dd/mm/yyyy" readonly>
                              <input type="hidden" name="wp_wr_pejabat" value="{{Auth::user()->opr_id}}" readonly>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Reg. Pendaftaran
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <div class="input-group">
                                    <input id="no_urut" class="form-control col-md-7 col-xs-12" name="wp_wr_no_urut" required="required" type="text" value="{{$wp_wr_no_urut or $no_urut}}" readonly="true">
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
                                  <select class="form-control" name="wp_wr_jenis">
                                    <option value="p" <?php  echo ($wp_wr_jenis=='p')? 'selected' : '' ?>>Wajib Pajak (P)</option>
                                    <option value="r" <?php echo ($wp_wr_jenis=='r')? 'selected' : '' ?>>Wajib Retribusi (R)</option>
                                  </select>
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Nama WP/WR 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="text" id="wp_wr_nama" name="wp_wr_nama"  required="required" class="form-control col-md-7 col-xs-12" value="{{$wp_wr_nama or ''}}">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Alamat 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <textarea id="wp_wr_almt" required="required" name="wp_wr_almt" class="form-control col-md-7 col-xs-12" >{{$wp_wr_almt or ''}}</textarea>
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Kodepos
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="text" id="wp_wr_kodepos" name="wp_wr_kodepos" required="required" data-inputmask="'mask' : '99999'" class="form-control col-md-7 col-xs-12" value="{{$wp_wr_kodepos or ''}}">
                                </div>
                              </div>
                              
                              </div>
                              <div class="col-md-6">
                                <div class="item form-group">
                                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">No. Telepon 
                                  </label>
                                  <div class="col-md-8 col-sm-6 col-xs-12">
                                    <input type="tel" id="wp_wr_telp" name="wp_wr_telp" required="required"  class="form-control col-md-7 col-xs-12" value="{{$wp_wr_telp or ''}}">
                                  </div>
                                </div>
                                <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Kecamatan 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <select class="form-control" id="wp_wr_kd_camat" name="wp_wr_kd_camat">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <?php

                                      foreach ($kecamatan as $k => $v) {
                                        # code...
                                      if($v->camat_id == $wp_wr_kd_camat){
                                        echo '<option value="'.$v->camat_id.'|'.$v->camat_nama.'" selected>'.$v->camat_kode.' | '.$v->camat_nama.'</option>';
                                      } else {
                                        echo '<option value="'.$v->camat_id.'|'.$v->camat_nama.'">'.$v->camat_kode.' | '.$v->camat_nama.'</option>';
                                      }
                                      
                                      }
                                    ?>
                                  </select>
                                </div>

                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kelurahan 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <select class="form-control" id="wp_wr_kd_lurah" name="wp_wr_kd_lurah">
                                    <option>--</option>
                                  </select>
                                </div>
                              </div>
                              <div class="item form-group" id="luar_kota">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input id="wp_wr_lurah" type="text" name="wp_wr_lurah" class="optional form-control col-md-7 col-xs-12" readonly>
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kabupaten/Kota 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input id="wp_wr_kabupaten" type="text" name="wp_wr_kabupaten" class="optional form-control col-md-7 col-xs-12" value="{{$wp_wr_kabupaten or ''}}">
                                </div>
                              </div>

                               
                              
                              
                            </div>
                          </div>
                          <div class="x_panel">
                            <div class="col-md-6">
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Nama Pemilik 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="text" id="wp_wr_nama_milik" name="wp_wr_nama_milik"  required="required" class="form-control col-md-7 col-xs-12" value="{{$wp_wr_nama_milik or ''}}">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">No. Telepon 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="tel" id="wp_wr_telp_milik" name="wp_wr_telp_milik" required="required"  class="form-control col-md-7 col-xs-12" value="{{$wp_wr_telp_milik or ''}}">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Alamat 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <textarea id="wp_wr_almt_milik" required="required" name="wp_wr_almt_milik" class="form-control col-md-7 col-xs-12" >{{$wp_wr_almt_milik or ''}}</textarea>
                                </div>
                              </div>
                              
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Kodepos
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="text" id="wp_wr_kodepos_milik" name="wp_wr_kodepos_milik" required="required" data-inputmask="'mask' : '99999'" class="form-control col-md-7 col-xs-12" value="{{$wp_wr_kodepos_milik or ''}}">
                                </div>
                              </div>
                              </div>
                              <div class="col-md-6">
                                
                                <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="website">Kecamatan 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="text" id="wp_wr_camat_milik" name="wp_wr_camat_milik"  required="required" class="form-control col-md-7 col-xs-12" value="{{$wp_wr_camat_milik or ''}}">
                                </div>

                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kelurahan 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input type="text" id="wp_wr_lurah_milik" name="wp_wr_lurah_milik"  required="required" class="form-control col-md-7 col-xs-12" value="{{$wp_wr_lurah_milik or ''}}">
                                </div>
                              </div>
                              <div class="item form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kabupaten/Kota 
                                </label>
                                <div class="col-md-8 col-sm-6 col-xs-12">
                                  <input id="wp_wr_kabupaten_milik" type="text" name="wp_wr_kabupaten_milik" class="optional form-control col-md-7 col-xs-12" value="{{$wp_wr_kabupaten_milik or ''}}">
                                </div>
                              </div>
                              
                              
                              
                            </div>
                          </div>
                          <div class="x_panel">
                            <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Tgl Form Diterima WP 
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                             <input data-inputmask="'mask':'99/99/9999'" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd/mm/yyyy" id="wp_wr_tgl_terima_form" name="wp_wr_tgl_terima_form" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" placeholder="dd/mm/yyyy" value="" readonly>
                            </div>
                          </div>
                           <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Tgl Batas Kirim 
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                              <input data-inputmask="'mask':'99/99/9999'" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd/mm/yyyy" id="wp_wr_tgl_bts_kirim" name="wp_wr_tgl_bts_kirim" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" placeholder="dd/mm/yyyy" value="" readonly>
                            </div>
                          </div>
                           <div class="item form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="telephone">Tgl Pendaftaran 
                            </label>
                            <div class="col-md-8 col-sm-6 col-xs-12">
                             <input data-inputmask="'mask':'99/99/9999'" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd/mm/yyyy" id="wp_wr_tgl_kartu" name="wp_wr_tgl_kartu" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" placeholder="dd/mm/yyyy" value="" readonly>
                            </div>
                          </div>
                          </div>
                          
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                            <div class="row ">
                              <div class="col-md-offset-1"></div>
                              <?php
                                if(!isset($wp_wr_bidang_usaha)){
                                  $wp_wr_bidang_usaha = '';
                                }
                                $ar = explode("::", $wp_wr_bidang_usaha);

                                $count = count($kodus);
                                $countdiv = $count/2;
                                $i = 1;
                                $e='';
                                foreach ($kodus as $k => $v) {
                                  if($i==1 or $i== $countdiv+1){
                                    $e = $e.'<div class="col-md-4"><p style="padding: 5px;">';
                                  }
                                  if(in_array($v->ref_kodus_id, $ar)){
                                    $e = $e.'<input type="checkbox" name="bidus[]" value="'.$v->ref_kodus_id.'" checked/> '.trim($v->ref_kodus_kode).'. '.trim($v->ref_kodus_nama).'<br />';
                                  } else {
                                    $e = $e.'<input type="checkbox" name="bidus[]" value="'.$v->ref_kodus_id.'" /> '.trim($v->ref_kodus_kode).'. '.trim($v->ref_kodus_nama).'<br />';
                                  }
                                  

                                  if($i==$countdiv or $i == $count){
                                    $e = $e.'</p>
                                        </div>';
                                  }
                                  $i++;
                                }
                                echo $e;
                              ?>
                              
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>Nama Perijinan</th>
                                <th>Nomor</th>
                                <th>Tanggal</th>
                                <th>  </th>
                              </tr>
                            </thead>
                            <tbody id="table-body">
                              <?php 
                                $row_table=0;
                                if(!empty($ar_ijin)){
                                  
                                  foreach ($ar_ijin as $value) {
                                    echo '<tr id="row-'.$row_table.'">'.
                                      '<input type="hidden" name="ijin_id[]" style="width:100%" value="'.$value->wp_wr_ijin_id.'" />'.
                                      '<td><input type="text" name="ijin_nama[]" style="width:100%" value="'.$value->wp_wr_ijin_nama.'" /></td>'.
                                      '<td><input type="text" name="ijin_nomor[]" style="width:100%" value="'.$value->wp_wr_ijin_nomor.'"/></td>'.
                                      '<td><input type="text" name="ijin_tanggal[]" data-inputmask=""mask":"99/99/9999" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd/mm/yyyy" id="wp_wr_tgl_kartu" name="wp_wr_tgl_kartu" required="required" type="text" placeholder="dd/mm/yyyy" value="'.date_format(date_create_from_format("Y-m-d",$value->wp_wr_ijin_tanggal),"d/m/Y").'"/></td>'.
                                      '<td><button href="#" class="btn btn-warning btn-xs hapus-row" value="'.$row_table.'">Hapus</button></td>'.
                                    '</tr>';
                                    $row_table++;
                                  }
                                }
                              ?>
                            </tbody>
                          </table>
                          <a class="btn btn-primary" id="tambah-detail"><i class="fa fa-plus-square-o"></i> Tambah Detail</a>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="margin-top: 20px">
                      {{ csrf_field() }}
                      <div class="form-group">
                        <div class="text-center">
                          <a href="/" class="btn btn-warning">Batal</a>
                          <button id="send" type="submit" class="btn btn-success">Simpan</button>
                        </div>
                      </div>
                    </div>  
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
  </div>
@stop

 @push('scripts')
  {!! Html::script('vendors/validation/dist/jquery.validate.min.js'); !!}
  {!! Html::script('vendors/jquery.inputmask/dist/min/jquery.inputmask.bundle.min.js'); !!}

    <script> 
    var row_table=<?php echo $row_table ?>;
    var idCamat = '{{$wp_wr_kd_camat or ''}}';
    var idLurah = '{{$wp_wr_kd_lurah or ''}}';
    var wp_wr_tgl_form_kembali = '{{$wp_wr_tgl_form_kembali or ''}}';
    var wp_wr_tgl_terima_form = '{{$wp_wr_tgl_terima_form or ''}}';
    var wp_wr_tgl_bts_kirim = '{{$wp_wr_tgl_bts_kirim or ''}}';
    var wp_wr_tgl_kartu = '{{$wp_wr_tgl_kartu or ''}}';
    var wp_wr_tgl_tb = '{{$wp_wr_tgl_tb or ''}}';
    var wp_wr_tgl_kk = '{{$wp_wr_tgl_kk or ''}}';
    var status = '{{$status or ''}}';
      $(document).ready(function() {
        //notify
        if(status=='1'){
          updatedNotify();
        }else if(status=='-1'){
          notupdatedNotify();
        }else if(status=='2'){
          createdNotify();
        }else if(status=='-2'){
          notcreatedNotify();
        }else if(status=='-3'){
          notfoundNotify();
        }
        
        if(idCamat!=''){
          camatChange(idCamat,idLurah);
        }


        $(document).on("click","#tambah-detail",function(){
          // alert('tes');
          $('#table-body').append(
            '<tr id="row-'+row_table+'">'+
              '<input type="hidden" name="ijin_id[]" style="width:100%" value="0" />'+
              '<td><input type="text" name="ijin_nama[]" style="width:100%"/></td>'+
              '<td><input type="text" name="ijin_nomor[]" style="width:100%" /></td>'+
              '<td><input type="text" name="ijin_tanggal[]" data-inputmask=""mask":"99/99/9999" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd/mm/yyyy" id="wp_wr_tgl_kartu" name="wp_wr_tgl_kartu" required="required" type="text" placeholder="dd/mm/yyyy"/></td>'+
              '<td><button href="#" class="btn btn-warning btn-xs hapus-row" value="'+row_table+'">Hapus</button></td>'+
            '</tr>'
            );
          row_table++;
        });

        $(document).on("click",".hapus-row",function(e){
          e.preventDefault();
          var val = $(this).val();
          swal({
            title: "Anda yakin ingin menghapus detail ini ?",
            // text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Hapus!",
            closeOnConfirm: false
          },
          function(){
             $('#row-'+val).remove();
            swal({
              title:"Berhasil Dihapus!", 
              text:"Detail berhasil dihapus",
              type:"success",
              timer: 1000,
              showConfirmButton: false});
          });
         
        });
        $(":input").inputmask();

        $("form").validate({
          rules: {
            wp_wr_kodepos: {
              maxlength: 5
            }
          }
        });
        var d = new Date();
        //datepicker
        if(wp_wr_tgl_form_kembali!=''){
          $('#wp_wr_tgl_form_kembali').datepicker("setDate", formatTgl(wp_wr_tgl_form_kembali));
        } else {
          $('#wp_wr_tgl_form_kembali').datepicker("setDate", "0");
        }
        if(wp_wr_tgl_terima_form!=''){
          $('#wp_wr_tgl_terima_form').datepicker("setDate", formatTgl(wp_wr_tgl_terima_form));
        } else {
          $('#wp_wr_tgl_terima_form').datepicker("setDate", "0");
        }
        if(wp_wr_tgl_bts_kirim!=''){
          $('#wp_wr_tgl_bts_kirim').datepicker("setDate", formatTgl(wp_wr_tgl_bts_kirim));
        } else {
          $('#wp_wr_tgl_bts_kirim').datepicker("setDate", "+7d");
        }
        if(wp_wr_tgl_kartu!=''){
          $('#wp_wr_tgl_kartu').datepicker("setDate", formatTgl(wp_wr_tgl_kartu));
        } else {
          $('#wp_wr_tgl_kartu').datepicker("setDate", "0");
        }
        if(wp_wr_tgl_kk!=''){
          $('#wp_wr_tgl_kk').datepicker("setDate", formatTgl(wp_wr_tgl_kk));
        }

        if(wp_wr_tgl_tb!=''){
          $('#wp_wr_tgl_tb').datepicker("setDate", formatTgl(wp_wr_tgl_tb));
        }
        $('#wp_wr_kd_camat').change(function() {
          val = $(this).val().split("|");
          camatChange(val[0]);
        })

        $('#wp_wr_kd_lurah').change(function() {
          val = $(this).val();
          lurahChange(val);
        });

        $('#wp_wr_pekerjaan2').change(function() {
          val = $(this).val();
          
          if (val == "LAINNYA"){
            $("#wp_wr_pekerjaan").attr('readonly', false)
            $("#wp_wr_pekerjaan").val('');
          } else {
            $("#wp_wr_pekerjaan").attr('readonly', true);
            $("#wp_wr_pekerjaan").val(val);
          }
        });

        //phone
          $("#wp_wr_telp").keypress(function (e) {
             //if the letter is not digit then display error and don't type anything
             if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                return false;
            }
           });


      });

      function camatChange(idCamat, idLurah=''){
        $.ajax({
            method: "POST",
            url: "/getKelurahan",
            data: { idKecamatan : idCamat },
            success: function(data){
              kelurahan = $.parseJSON(data);
              var o = '<option value=""> == pilih kelurahan == </option>';
              $.each(kelurahan, function( k, v ) {
                if(v.lurah_id == idLurah){
                  o = o+'<option value="'+v.lurah_id+'" selected>'+v.lurah_kode+' | '+v.lurah_nama+'</option>'
                } else {
                  o = o+'<option value="'+v.lurah_id+'">'+v.lurah_kode+' | '+v.lurah_nama+'</option>'
                }
                
              });
              $('#wp_wr_kd_lurah').html(o);
            }
          })
          .done(function( data ) {
            if(idLurah!=''){
              lurahChange(idLurah);
            }
            

          });
      }
      function lurahChange(val){
        text = $("#wp_wr_kd_lurah option:selected").text().split("|");
          
          
          if (val == 84){
            $("#wp_wr_lurah").val('{{$wp_wr_lurah or ''}}');
            $("#wp_wr_lurah").attr('readonly', false);
          } else {

            $("#wp_wr_lurah").val(text[1]);
            $("#wp_wr_lurah").attr('readonly', true);
          }
      }
      function formatTgl(tgl){
        ar = tgl.split("-");
        return ar[2]+"/"+ar[1]+"/"+ar[0];
      }
      function updatedNotify(){
        new PNotify({
                        title: 'BERHASIL',
                        text: 'Pembaharuan data telah berhasil',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
      }
      function notupdatedNotify(){
        new PNotify({
                        title: 'GAGAL',
                        text: 'Pembaharuan data tidak berhasil',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
      }
      function createdNotify(){
        new PNotify({
                        title: 'BERHASIL',
                        text: 'Penambahan data baru telah berhasil',
                        type: 'success',
                        styling: 'bootstrap3'
                    });
      }
      function notcreatedNotify(){
        new PNotify({
                        title: 'GAGAL',
                        text: 'Penambahan data baru telah gagal',
                        type: 'error',
                        styling: 'bootstrap3'
                    });
      }
      function notfoundNotify(){
        new PNotify({
                        title: 'TIDAK ADA',
                        text: 'Data tidak ditemukan',
                        type: 'danger',
                        styling: 'bootstrap3'
                    });
      }
    </script>
@endpush