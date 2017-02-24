 @extends('layouts.layout')
@section('content')
  <div class="row">

        <div class="x_panel">
        <h2>Tabel Daftar SPT yang sudah ditetapkan </h2>
        <hr>
        <table class="table stripe dataTable" id="rml-table">
            <thead>
                <tr>
                    <th>Kohir</th>
                    <th>Obyek Pajak</th>
                    <th>Periode</th>
                    <th>No. SPT</th>
                    <th>Tgl Penetapan</th>
                    <th>Jenis Penetapan</th>
                    <th>Jatuh Tempo</th>
                    <th>Rekening</th>
                    <th>NPWD/NPWRD</th>
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
        $('.dataTable th').addClass('bg-blue');
        var rmlTable = $('#rml-table').DataTable({
            "scrollX": true,
            processing: true,
            serverSide: true,
            ajax: '/datatables/spt',
            columns: [
                { data: 'netapajrek_kohir' },
                { data: 'korek_nama' },
                { data: 'spt_periode' },
                { data: 'spt_nomor' },
                { data: 'netapajrek_tgl' },
                { data: 'ketspt_ket' },
                { data: 'netapajrek_tgl_jatuh_tempo' },
                { data: 'koderek' },
                { data: 'npwprd' },
            ],

        });
        rmlTable.on( 'draw.dt', function () {
        });
      });
    </script>
@endpush