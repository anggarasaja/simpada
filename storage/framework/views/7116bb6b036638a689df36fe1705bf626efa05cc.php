 
<?php $__env->startSection('content'); ?>
  <div class="row">

        <div class="x_panel">
        <h2>Tabel Daftar Setor Self Assesment </h2>
        <hr>
        <table class="table stripe" id="rml-table">
            <thead>
                <tr>
                    <th>No. SPT</th>
                    <th>Periode</th>
                    <th>Tanggal Setor</th>
                    <th>Nama Rekening</th>
                    <th>Nomor WPWR</th>
                    <th>Nama WPWR</th>
                    <th>Jumlah Setoran</th>
                    <th>Bayar Via</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
        </div>
        
  
  </div>
<?php $__env->stopSection(); ?>

 <?php $__env->startPush('scripts'); ?>
 <?php echo Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js');; ?>

    <script>
        function formatNumber(n) {
  return n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
      $(document).ready(function() {
        var rmlTable = $('#rml-table').DataTable({
            "language": {
            "decimal": ",",
            "thousands": "."
        },
            "scrollX": true,
            processing: true,
            serverSide: true,
            ajax: '/datatables/self',
            columns: [
                { data: 'spt_nomor' },
                { data: 'sprsd_periode_jual1' },
                { data: 'setorpajret_tgl_bayar' },
                { data: 'korek_nama' },
                { data: 'npwprd_format' },
                { data: 'wp_wr_nama' },
                { data: 'setorpajret_jlh_bayar',
                    "render" : function( data, type, full ) {
                    // you could prepend a dollar sign before returning, or do it
                    // in the formatNumber method itself
                    return 'Rp. '+formatNumber(data); }
                },
                { data: 'ref_viabaypajret_ket' },
                { data: 'action' },
            ],

        });
        rmlTable.on( 'draw.dt', function () {
        });
      });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>