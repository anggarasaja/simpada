@extends('layouts.layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Cetak Daftar Kartu Data</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><a href="{{ URL::to('pendataan/cetak_daftar') }}">Cetak Daftar Kartu Data Pajak Hotel/ Restoran/ Hiburan/ Parkir</a></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td><a href="{{ URL::to('pendataan/cetak_daftar_reklame') }}">Cetak Daftar Kartu Data Pajak Reklame</a></td>
                    </tr>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop