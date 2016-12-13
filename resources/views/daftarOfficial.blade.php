 @extends('layouts.layout')
@section('content')
  <div class="row">

        <div class="x_panel">
        <h2>Daftar Setor Official Assesment </h2>
        <hr>
        <table class="table stripe" id="rml-table">
            <thead>
                <tr>
                    <th>Kohir</th>
                    <th>Penetapan</th>
                    <th>Ketetapan</th>
                    <th>Tgl Setor</th>
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
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
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
            ajax: '/datatables/official',
            columns: [
                { data: 'netapajrek_kohir' },
                { data: 'periode_tap' },
                { data: 'ketspt_singkat' },
                { data: 'setorpajret_tgl_bayar' },
                { data: 'korek_nama' },
                { data: 'npwprd' },
                { data: 'wp_wr_nama' },
                { data: 'ref_viabaypajret_ket' },
                { data: 'action' },
            ],

        });
        rmlTable.on( 'draw.dt', function () {
        });
      });
    </script>
@endpush