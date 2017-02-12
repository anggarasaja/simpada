<?php $__env->startSection('content'); ?>
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Menu Penyetoran</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <!-- <div class="x_title">
            <h2>Daftar Wajib Pajak</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div> -->
          <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($array as $key => $val): ?>
                    <tr>
                      <td><?php echo e($key+1); ?></td>
                      <?php if($key+1 < 5): ?>
                      <td><a href="<?php echo e(url($link[$key])); ?>" ><?php echo e($val); ?></a></td>
                      <?php else: ?>
                      <td><a href="#" data-toggle="modal" data-target=".bs-example-modal-sm"><?php echo e($val); ?></a></td>
                      <?php endif; ?>
                    </tr> 
                    <?php endforeach; ?>
                  </tbody>
                </table>
          </div>

          <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">

                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                  </button>
                  <h4 class="modal-title" id="myModalLabel2">Pilihan Cetak Kartu Data Pajak</h4>
                </div>
                <div class="modal-body">
                  <table class="table">
                    <thead>
                      <tr>
                          <th>#</th>
                          <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($data_pajak as $key): ?>
                      <tr>
                        <td><?php echo e($key->ref_jenparet_id); ?></td>
                        <td><a href="<?php echo e(url('cetak_data_pajak/'.$key->ref_jenparet_id)); ?>"><?php echo e($key->ref_jenparet_ket); ?></a></td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>

              </div>
            </div>
          </div>
          <!-- /modals -->
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

 <?php $__env->startPush('scripts'); ?>
    <script>
      $(document).ready(function() {
        var $datatable = $('#datatable');

        $datatable.dataTable({
          'order': [[ 0, 'asc' ]],

        });
      });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>