@extends('layouts.layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Menu LHP</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><a href="{{ url('lhp/self') }}" >Laporan Hasil Pemeriksaan (LHP) - Self Assessment</a></td>
                    </tr> 
                    <tr>
                      <td>2</td>
                      <td><a href="{{ url('lhp/reklame') }}" >Laporan Hasil Pemeriksaan (LHP) - Reklame</a></td>
                    </tr> 
                    <tr>
                      <td>3</td>
                      <td><a href="{{ url('lhp/retribusi') }}" >Laporan Hasil Pemeriksaan (LHP) - Retribusi</a></td>
                    </tr>
                  </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
