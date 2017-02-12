@extends('layouts.layout')
@section('content')
<div class="row">
        <div class="x_panel">
        <h2>Tabel Isian SPTPD Pajak Sarang Walet <a href="{{ URL::to('pendataan/sptpd/1') }}" class="btn btn-info pull-right"><i class="fa fa-plus"></i> Tambah Baru</a>
        </h2>
        <hr>
        <table id="tbl_hist" class="table stripe table-bordered row-border hover order-column" id="rml-table">
            <thead>
              <tr>
                <!-- <th>No</th> -->
                <th>No SPT</th>
                <th>Periode</th>
                <th>NPWPD / NPWRD</th>
                <th>Nama WP/WR</th>
                <th>Alamat</th>
                <th>Rekening</th>
                <th>Jumlah Pajak</th>
                <th>Tanggal Setor</th>
                <th></th>
              </tr>
            </thead>
        </table>
        </div>
  </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>
    var oTable ;
    var status = '{{$status or ''}}';
      $(document).ready(function() {
        if(status=='3'){
          hapus();
        }

        function hapus(){
          new PNotify({
                title: 'BERHASIL',
                text: 'Penghapusan data telah berhasil',
                type: 'danger',
                styling: 'bootstrap3'
            });
        }

        oTable = $('#tbl_hist').DataTable({
          processing: true,
          serverSide: true, 
          bFilter: true,   
          ajax: {
            url: "{{ URL::to('pendataan/get_data_sarang') }}",
            type: "GET",
            data: {  },
          },
          columns: [
              { data: 'spt_nomor', name: 'spt_nomor' },
              { data: 'spt_periode_jual1', name: 'spt_periode_jual1' },
              { data: 'npwprd', name: 'npwprd' },
              { data: 'wp_wr_nama', name: 'wp_wr_nama' },
              { data: 'wp_wr_almt', name: 'wp_wr_almt' },
              { data: 'korek_nama', name: 'korek_nama' },
              { data: 'spt_pajak', name: 'spt_pajak' },
              { data: 'setorpajret_tgl_bayar', name: 'setorpajret_tgl_bayar' }, 
              { data: 'aksi', name: 'aksi' }, 
          ],
          order: [[ 0, "desc" ]]
        });

        $('#tbl_hist tbody')
        .on( 'mouseenter', 'td', function () {
            var colIdx = oTable.cell(this).index().column;
 
            $( oTable.cells().nodes() ).removeClass( 'highlight' );
            $( oTable.column( colIdx ).nodes() ).addClass( 'highlight' );
        } );


      });

      $(document).on("click", ".btn-delete", function (e){
            e.preventDefault();
            var self = $(this);
            swal({
              title: "Apakah Anda Yakin?",
              text: "Anda akan menghapus salah satu data SPT!",
              type: "warning",
              showCancelButton: true,
              confirmButtonColor: "#DD6B55",
              confirmButtonText: "Ya, Hapuskan!",
              cancelButtonText: "Tidak, Batalkan!",
              closeOnConfirm: false,
              closeOnCancel: false
            },
            function(isConfirm){
              if (isConfirm) {
                 // $(this).parents("form").submit();
                 swal("Deleted!", "Data SPT Berhasil Dihapus", "success");
                 setTimeout(function() {
                        self.parents("form").submit();
                    }, 2000);
              } else {
                swal("Batal", "Proses Telah Dibatalkan", "error");
              }
            });
          });
    </script>
@endpush