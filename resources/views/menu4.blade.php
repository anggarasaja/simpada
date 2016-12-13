@extends('layouts.layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Daftar Cetak Rekam Setoran Dari Dinas Lain </h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>DAFTAR SETORAN DINAS LAIN</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
              <a href="{{ url('daftar-badan/create') }}" class="btn btn-md btn-success"><i class="fa fa-plus"></i>&nbsp; Baru</a>
              <a href="#" class="btn btn-md btn-warning"><i class="fa fa-pencil"></i>&nbsp; Edit</a>
              <a href="#" class="btn btn-md btn-danger"><i class="fa fa-close"></i>&nbsp; Hapus</a>
                <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th><input type="checkbox" id="check-all" class="flat"></th>
                      <th>Nomor Bukti</th>
                      <th>Tanggal Setor</th>
                      <th>SKPD</th>
                      <th>Bayar via</th>
                      <th>Validasi</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop

 @push('scripts')
    <script>
      $(document).ready(function() {
        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });
      });
    </script>
@endpush