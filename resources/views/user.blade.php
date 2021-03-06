 @extends('layouts.layout')
@section('content')
  <div class="row">

        <div class="x_panel">
        <h2>Manajemen Operator <a href="{{ URL::to('user/create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Baru</a></h2>
        <hr>
        @if (session()->has('flash_notification.message'))
              <div class="alert alert-{{ session('flash_notification.level') }}">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                  {!! session('flash_notification.message') !!}
              </div>
          @endif
        <table class="table stripe table-bordered dataTable" id="table1">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>NIP</th>
                    <th>Operator Level</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        </div>
        
  
  </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>

      $(document).ready(function() {
        $('.dataTable th').addClass('bg-blue');
        rmlTable = $('#table1').DataTable({
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            processing: true,
            serverSide: true,
            ajax: "{{ URL::to('getdatauser') }}",
            columns: [
                { data: 'opr_nama', name: 'opr_nama' },
                { data: 'opr_user', name: 'opr_user' },
                { data: 'opr_nip', name: 'opr_nip' },
                { data: 'opr_level', name: 'opr_level' },
                { data: 'opr_status', name: 'opr_status' },
                { data: 'aksi', name: 'aksi' },
            ]
        });
        rmlTable.on( 'draw.dt', function () {
        });
      });

      $(document).on("click", ".btn-delete", function (e){
        e.preventDefault();
        var self = $(this);
        swal({
          title: "Apakah Anda Yakin?",
          text: "Anda akan menghapus salah satu data Operator!",
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
             swal("Deleted!", "Data Operator Berhasil Dihapus", "success");
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