 
<?php $__env->startSection('content'); ?>
<!-- load js -->
  <!-- iCheck -->
  <script src="../vendors/iCheck/icheck.min.js"></script>
<!-- load js -->
 <div class="right_col" role="main">
          <div class="row">
            
              <form class="form-horizontal form-label-left" novalidate>
                <span class="section">Form Pendaftaran WP/WR Badan Usaha: <label>[Baru]</label></span>
                <div class="col-md-6">
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Reg. Pendaftaran
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <div class="input-group">
                        <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="" required="required" type="text">
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
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="textarea">No. Telepon 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <textarea id="textarea" required="required" name="textarea" class="form-control col-md-7 col-xs-12"></textarea>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Kewarganegaraan
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select class="form-control">
                        <option>WNI</option>
                        <option>WNA</option>
                      </select>
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="occupation">Tanda Bukti Diri
                    </label>
                    <div class="col-md-8 col-sm-8 col-xs-12">
                      <div class="controls form-inline">
                        <select class="form-control">
                          <option>KTP</option>
                          <option>SIM</option>
                        </select>
                          <label for="inputValue">No:</label>
                          <input type="text" class=" form-control" placeholder="" id="inputValue">
                      </div>
                    </div>
                  </div>
                </div>
                <!--col kanan -->
                <div class="col-md-6">
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">No. Kartu Keluarga  
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input id="name" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="name" placeholder="" required="required" type="text">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Pekerjaan/usaha 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input type="email" id="email" name="email" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Nama Instansi Tempat Bekerja/Usaha 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input type="email" id="email2" name="confirm_email" data-validate-linked="email" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="item form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="number">Alamat Instansi
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input type="number" id="number" name="number" required="required" data-validate-minmax="10,100" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Bidang Usaha:</label>
                      <div class="row ">
                        <div class="col-md-offset-1"></div>
                        <div class="col-md-4">
                          <p style="padding: 5px;">
                            <input type="checkbox" name="hobbies[]" id="hobby1" value="ski" class="flat" /> 01. Hotel
                            <br />

                            <input type="checkbox" name="hobbies[]" id="hobby2" value="run" class="flat" /> 02. Restoran
                            <br />

                            <input type="checkbox" name="hobbies[]" id="hobby3" value="eat" class="flat" /> 03/ Hiburan
                            <br />
                            <input type="checkbox" name="hobbies[]" id="hobby4" value="sleep" class="flat" /> 04. Reklame
                            <br />

                            <input type="checkbox" name="hobbies[]" id="hobby1" value="ski" class="flat" /> 05. Listrik
                            <br />

                           
                          <p>
                        </div>
                         <div class="col-md-4">
                          <p style="padding: 5px;">
                           

                            <input type="checkbox" name="hobbies[]" id="hobby2" value="run" class="flat" /> 06. Mineral Bukan Logam dan Batuan
                            <br />
                             <input type="checkbox" name="hobbies[]" id="hobby3" value="eat" class="flat" /> 07. Parkir
                            <br />

                            <input type="checkbox" name="hobbies[]" id="hobby4" value="sleep" class="flat" /> 08. Air Bawah Tanah
                            <br />
                            <input type="checkbox" name="hobbies[]" id="hobby1" value="ski" class="flat" /> 09. Sarang Burung Walet
                            <br />

                            <input type="checkbox" name="hobbies[]" id="hobby2" value="run" class="flat" /> 10. Kekayaan Daerah
                            <br />

                           
                          <p>
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
               <!--  <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-primary">Cancel</button>
                    <button id="send" type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div> -->
              </form>
            
            <div class="col-md-6">
              
            </div>
          </div>
        </div>
        <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        
      });
    </script>
    <!-- /bootstrap-daterangepicker -->
        <?php $__env->stopSection(); ?>
<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>