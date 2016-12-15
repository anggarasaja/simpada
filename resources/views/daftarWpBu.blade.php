 @extends('layouts.layout')
@section('content')
  <div class="row">

        <div class="x_panel">
        <h2>Tabel Data Pendaftaran WP Badan Usaha</h2>
        <hr>
        <table class="table stripe table-condensed" id="rml-table">
            <thead>
                <tr>
                    <th>Nomor Pendaftaran</th>
                    <th>NPWD</th>
                    <th>No Kartu WP</th>
                    <th>Nama WP</th>
                    <th>Alamat</th>
                    <th>Kelurahan</th>
                    <th>Kecamatan</th>
                    <th>Kabupaten</th>
                    <th>Nama Pemilik</th>
                    <th>Alamat Pemilik</th>
                    <th>Kelurahan Pemilik</th>
                    <th>Kecamatan Pemilik</th>
                    <th>Kabupaten Pemilik</th>
                    <th>Tgl Form Diterima</th>
                    <th>Tgl Batas Kirim</th>
                    <th>Tgl Form Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
        </div>
        
  
  </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>

      $(document).ready(function() {
        var rmlTable = $('#rml-table').DataTable({
            "scrollX": true,    
            processing: true,
            serverSide: true,
            ajax: '/datatables/wp-bu',
            columns: [
                { data: 'no_reg' },
                { data: 'npwprd' },
                { data: 'wp_wr_no_kartu' },
                { data: 'wp_wr_nama' },
                { data: 'wp_wr_almt' },
                { data: 'wp_wr_lurah' },
                { data: 'wp_wr_camat' },
                { data: 'wp_wr_kabupaten' },
                { data: 'wp_wr_nama_milik' },
                { data: 'wp_wr_almt_milik' },
                { data: 'wp_wr_lurah_milik' },
                { data: 'wp_wr_camat_milik' },
                { data: 'wp_wr_kabupaten_milik' },
                { data: 'wp_wr_tgl_terima_form' },
                { data: 'wp_wr_tgl_bts_kirim' },
                { data: 'wp_wr_tgl_form_kembali' },
                { data: 'action' },
            ],

        });
        rmlTable.on( 'draw.dt', function () {
            // $('[data-toggle="popover"]').popover();

            // $( ".btn-update" ).click(function() {
            //      // alert( $(this).val() );
            //      var id = $(this).val();
            //      $("#progress-"+id).show();
            //      $.ajax({
            //         url: '/updater/updateId/'+id,
            //         error: function() {
            //             alertl('<p>An error has occurred</p>');
            //         }
            //     }).done(function(data){

            //         $("#progress-"+id).hide();
            //         new PNotify({
            //                 title: 'Pembaharuan selesai',
            //                 text: 'Pembaharuan dataset telah selesai',
            //                 type: 'success',
            //                 styling: 'bootstrap3'
            //             });
            //         rmlTable.ajax.reload( null, false );
            //     });
            // });
        });
      });
    </script>
@endpush