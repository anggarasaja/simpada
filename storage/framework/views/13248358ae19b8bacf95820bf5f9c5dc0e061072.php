<?php $__env->startSection('content'); ?>
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Rekam Setoran Pajak/Retribusi Official:</h3>
      </div>

      <div class="title_right">
        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
              <a href="#" class="btn btn-primary"><i class="fa fa-list"></i> Lihat Data</a>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>

    <?php if(!isset($post)): ?>
    <form action="<?php echo e(url('penyetoran/store_menu1')); ?>" class="form-horizontal form-label-left" method="POST">
    <?php else: ?>
    <form action="<?php echo e(url('penyetoran/update_menu1')); ?>" class="form-horizontal form-label-left" method="POST">
    <?php endif; ?>
    <div class="row">
      <div class=" col-md-6 col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
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
              <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
              <input type="hidden" id="setorpajret_id_penetapan" name="setorpajret_id_penetapan" >
              <?php if(session()->has('flash_notification.message')): ?>
                  <div class="alert alert-<?php echo e(session('flash_notification.level')); ?>">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      <?php echo session('flash_notification.message'); ?>

                  </div>
              <?php endif; ?>
                  <div class="item form-group<?php echo e($errors->has('period_spt') ? ' has-error' : ''); ?>">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="period_spt">Period SPT
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <input id="period_spt" data-inputmask="'mask': '9999'"  class="form-control col-md-7 col-xs-12" type="text" name="period_spt" value="<?php echo e((isset($post)) ? date('Y',strtotime($post->setorpajret_tgl_bayar)) : date('Y')); ?>">
                     <?php if($errors->has('period_spt')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('period_spt')); ?></strong>
                          </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="item form-group<?php echo e($errors->has('objek_pajak') ? ' has-error' : ''); ?>">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="objek_pajak">Objek Pajak
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select id="objek_pajak" name="objek_pajak" class="form-control col-md-7 col-xs-12">
                            <option value="">-- Pilih Objek Pajak --</option>
                            <option value="4">Pajak Reklame</option>
                            <option value="8">Pajak Air Tanah</option>
                            <option value="10">Retribusi Kekayaan Daerah</option>
                      </select>
                      <?php if($errors->has('objek_pajak')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('objek_pajak')); ?></strong>
                          </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="form-group<?php echo e($errors->has('no_kohir') ? ' has-error' : ''); ?>">
                        <label class="col-sm-3 control-label">Nomor Kohir</label>

                        <div class="col-sm-9">
                          <div class="input-group">
                            <input id="no_kohir" class="form-control" type="text" name="no_kohir">
                            <span class="input-group-btn">
                                <button id="modal" type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-lg" >...</button>
                            </span>
                          </div>
                      <?php if($errors->has('no_kohir')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('no_kohir')); ?></strong>
                          </span>
                      <?php endif; ?>
                        </div>
                      </div>
                  <div class="item form-group<?php echo e($errors->has('tgl_setor') ? ' has-error' : ''); ?>">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_setor">Tanggal Penyetoran 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                     <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_setor" name="tgl_setor" class="date-picker form-control col-md-7 col-xs-12 active" required="required" type="text" value="<?php echo e(date('d/m/Y')); ?>">
                      
                      <?php if($errors->has('tgl_setor')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('tgl_setor')); ?></strong>
                          </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="item form-group<?php echo e($errors->has('bendahara') ? ' has-error' : ''); ?>">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="bendahara">Bendahara 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select id="bendahara" name="bendahara" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                        <?php foreach($pejda as $key => $value): ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                        <?php endforeach; ?>
                      </select>
                      
                      <?php if($errors->has('bendahara')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('bendahara')); ?></strong>
                          </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="item form-group<?php echo e($errors->has('via_bayar') ? ' has-error' : ''); ?>">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="via_bayar">Via Bayar 
                    </label>
                    <div class="col-md-8 col-sm-6 col-xs-12">
                      <select id="via_bayar" name="via_bayar" class="form-control col-md-7 col-xs-12">
                        <option value="">--</option>
                        <?php foreach($viabayar as $key => $value): ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                        <?php endforeach; ?>
                      </select>
                    
                      <?php if($errors->has('via_bayar')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('via_bayar')); ?></strong>
                          </span>
                      <?php endif; ?>
                    </div>
                  </div>
                  <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                  <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Lakukan Penyetoran</button>
                  </div>
                </div>
            </div>
          </div>
        <!-- </div> -->
      </div>
    <!-- </form> -->

      <div class=" col-md-6 col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            <div class="x_title">
              <h2>Informasi Tagihan</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            
            <div class="x_content">
              <!-- <form novalidate> -->
                <div class=" form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama_wp">Nama WP
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="nama_wp" class="form-control" type="text" name="nama_wp" readonly>
                  </div>
                </div>
                <div class=" form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwp">NPWPD / NPWRD
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="npwp" class="form-control" type="text" name="npwp" readonly>
                  </div>
                </div>
                <div class=" form-group">
                  <label for="masa_pajak" class="control-label col-md-3 col-sm-3 col-xs-12">Masa Pajak</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="masa_pajak" class="form-control" type="text" name="masa_pajak" readonly>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_tetap">Tanggal Penetapan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-date-format="dd/mm/yyyy" id="tgl_tetap" name="tgl_tetap" class="date-picker form-control col-md-7 col-xs-12 active" readonly type="text">
                  </div>
                </div>
                <div class="item form-group<?php echo e($errors->has('kd_tetap') ? ' has-error' : ''); ?>">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kd_tetap">Kode Ketetapan 
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <select id="kd_tetap" name="kd_tetap" class="form-control col-md-7 col-xs-12">
                      <option value="">--</option>
                      <?php foreach($ket as $key => $value): ?>
                      <option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                      <?php endforeach; ?>
                    </select>
                  
                      <?php if($errors->has('kd_tetap')): ?>
                          <span class="help-block">
                              <strong><?php echo e($errors->first('kd_tetap')); ?></strong>
                          </span>
                      <?php endif; ?>
                  </div>
                </div>
                <div class=" form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_tempo">Jatuh Tempo
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="tgl_tempo" class="form-control" type="text" name="tgl_tempo" readonly>
                  </div>
                </div>
                <div class=" form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pajak">Jumlah Pajak
                  </label>
                  <div class="col-md-8 col-sm-6 col-xs-12">
                    <input id="pajak" class="form-control" type="text" name="pajak" readonly>
                  </div>
                </div>
              </form>
            </div>
          </div>
        <!-- </div> -->
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
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->

          </div>
        </div>
      </div>

    </div>
  </div>
<?php $__env->stopSection(); ?>

 <?php $__env->startPush('scripts'); ?>
    <script>
    var oTable ;
      $(document).ready(function() {
        $(":input").inputmask();
      });

      $(document).on("click", "#modal", function () {
        oTable = $('#table-kohir').DataTable();
           gettable();
      });
      $('#table-kohir tbody').on("click", "tr td", function () {
          var sData = oTable.row( this ).data();
          // console.log(sData );

          var no_kohir = $(this).closest("tr").children("td").eq(1).html();
          var nama_wp = $(this).closest("tr").children("td").eq(2).html();
          var npwp = $(this).closest("tr").children("td").eq(3).html();
          var masa_pajak = $(this).closest("tr").children("td").eq(8).html();
          var tgl_tetap = $(this).closest("tr").children("td").eq(5).html();
          var kd_tetap = $(this).closest("tr").children("td").eq(4).html();
          var tgl_tempo = $(this).closest("tr").children("td").eq(6).html();
          var pajak = $(this).closest("tr").children("td").eq(7).html();

          var setorpajret_id_penetapan = sData.netapajrek_id;

          $('#no_kohir').val(no_kohir);
          $('#nama_wp').val(nama_wp);
          $('#npwp').val(npwp);
          $('#masa_pajak').val(masa_pajak);
          $('#tgl_tetap').val(tgl_tetap);
          $('#kd_tetap').val(kd_tetap);
          $('#tgl_tempo').val(tgl_tempo);
          $('#pajak').val(pajak);
          $('#setorpajret_id_penetapan').val(setorpajret_id_penetapan);
          // return false; 
        } );

      function gettable(){
        oTable.destroy();
        var period_spt = $('#period_spt').val();
        var objek_pajak = $('#objek_pajak').val();
         oTable = $('#table-kohir').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "<?php echo e(URL::to('getkohir')); ?>",
            type: "GET",
            data: { 'period_spt':period_spt,
                    'objek_pajak': objek_pajak },
          },
          columns: [
              // { data: '_id', name: '_id' },
              { data: 'periode', name: 'periode' },
              { data: 'netapajrek_kohir', name: 'netapajrek_kohir'},
              { data: 'wp_wr_nama', name: 'wp_wr_nama'},
              { data: 'npwprd2', name: 'npwprd2'},
              { data: 'ketspt_singkat', name: 'ketspt_singkat'},
              { data: 'netapajrek_tgl', name: 'netapajrek_tgl'},
              { data: 'netapajrek_tgl_jatuh_tempo', name: 'netapajrek_tgl_jatuh_tempo'},
              { data: 'netapajrek_besaran', name: 'netapajrek_besaran'},
              { data: 'masa_pajak', name: 'masa_pajak'},
              { data: 'netapajrek_id_spt', visible: false,name: 'netapajrek_id_spt'},
          ],
          order: [[ 1, "asc" ]]
        });
      }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>