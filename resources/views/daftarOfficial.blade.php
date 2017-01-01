 @extends('layouts.layout')
@section('content')
  <div class="row">

        <div class="x_panel">
        <h2>Daftar Setor Official Assesment </h2>
        <hr>
        <a href="{{ url('penyetoran/menu1') }}" class="btn btn-lg btn-primary"><i class="fa fa-plus"></i> Baru</a>
        <table class="table table-stripe" id="rml-table">
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
            <tbody></tbody>
        </table>
        </div>
        
  
  </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>
    var rmlTable;
        function formatNumber(n) {
  return n.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
      $(document).ready(function() {
        rmlTable = $('#rml-table').DataTable({
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            processing: true,
            serverSide: true,
            ajax: "{{ URL::to('datatables/official') }}",
            columns: [
                { data: 'netapajrek_kohir', name: 'netapajrek_kohir' },
                { data: 'periode_tap', name: 'periode_tap' },
                { data: 'ketspt_singkat', name: 'ketspt_singkat' },
                { data: 'setorpajret_tgl_bayar', name: 'setorpajret_tgl_bayar' },
                { data: 'korek_nama', name: 'korek_nama' },
                { data: 'npwprd', name: 'npwprd' },
                { data: 'wp_wr_nama', name: 'wp_wr_nama' },
                { data: 'ref_viabaypajret_ket', name: 'ref_viabaypajret_ket' },
                { data: 'action', name: 'action' },
            ]
        });
        rmlTable.on( 'draw.dt', function () {
        });
      });
    </script>
@endpush