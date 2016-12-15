@extends('layouts.layout')
@section('content')
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Daftar Cetak NPWPD</h3>
          </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Daftar Cetak NPWPD</h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                  <a href="{{ URL::to('cetak_npwpd') }}"  class="btn btn-md btn-success"><i class="fa fa-print"></i>&nbsp; Cetak</a>
                    <table id="datatable-checkbox" class="table table-striped table-bordered bulk_action">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th><input type="checkbox" id="check-all" class="flat"></th>
                          <th>No. Pendaftaran</th>
                          <th>NPWP</th>
                          <th>No. Kartu WP/WR</th>
                          <th>Nama WP/WR</th>
                          <th>Alamat</th>
                          <th>Kelurahan</th>
                          <th>Kecamatan</th>
                          <th>Kabupaten</th>
                          <th>Nama Pemilik</th>
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
        $('#datatable-checkbox').DataTable();
      });
    </script>
@endpush