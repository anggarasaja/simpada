@extends('layouts.layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Menu Cetak Media Ketetapan</h3>
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
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><a href="{{ url('ketetapan/skpd') }}" >Cetak Media Ketetapan SKPD</a></td>
                    </tr> 
                    <tr>
                      <td>2</td>
                      <td><a href="{{ url('ketetapan/skrd') }}" >Cetak Media Ketetapan SKRD</a></td>
                    </tr> 
                    <tr>
                      <td>3</td>
                      <td><a href="{{ url('ketetapan/skpdkb') }}" >Cetak Media Ketetapan SKPDKB (Surat Ketetapan Pajak Kurang Bayar)</a></td>
                    </tr> 
                    <tr>
                      <td>4</td>
                      <td><a href="{{ url('ketetapan/skrdkb') }}" >Cetak Media Ketetapan SKRDKB (Surat Ketetapan Retribusi Kurang Bayar)</a></td>
                    </tr> 
                    <tr>
                      <td>5</td>
                      <td><a href="{{ url('ketetapan/skpdkb') }}" >Cetak Media Ketetapan SKPDKB (Surat Ketetapan Pajak Kurang Bayar)</a></td>
                    </tr> 
                    <tr>
                      <td>6</td>
                      <td><a href="{{ url('ketetapan/skpdlb') }}" >Cetak Media Ketetapan SKPDLB (Surat Ketetapan Pajak Lebih Bayar)</a></td>
                    </tr> 
                    <tr>
                      <td>7</td>
                      <td><a href="{{ url('ketetapan/skpdt') }}" >Cetak Media Ketetapan SKPDT(Surat Ketetapan Pajak Daerah Tambahan)</a></td>
                    </tr> 
                    <tr>
                      <td>8</td>
                      <td><a href="{{ url('ketetapan/skrdt') }}" > Cetak Media Ketetapan SKRDT(Surat Ketetapan Retribusi Daerah Tambahan)</a></td>
                    </tr> 
                  </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@stop
