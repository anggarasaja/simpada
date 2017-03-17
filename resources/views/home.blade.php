@extends('layouts.layout')

@section('content')
          <!-- top tiles -->
      
          <!-- /top tiles -->
          
          <div class="row col-md-6">
            <div class="">
              <a href="{{ URL::to('/daftar-pribadi/create')}}" >
                <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12 " >
                  <div class="tile-stats hvr-underline-reveal">
                    <div class="icon"><i class="fa fa-user"></i></div>
                    <div class="count"><br></div>
                    <h3>Pendaftaran<br>WP/WR Pribadi</h3>
                    <p></p>
                  </div>
                </div>
              </a>
             
            
              <a href="{{ URL::to('/daftar-bu/create')}}">
                <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="tile-stats hvr-underline-reveal">
                    <div class="icon"><i class="fa fa-building"></i></div>
                    <div class="count"><br></div>
                    <h3>Pendaftaran<br>WP/WR Badan Usaha</h3>
                    <p></p>
                  </div>
                </div>
              </a>

              <a href="{{ URL::to('/pendataan/rekam_data')}}">
                <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="tile-stats hvr-underline-reveal">
                    <div class="icon"><i class="fa fa-list-alt"></i></div>
                    <div class="count"><br></div>
                    <h3>Pendataan SPT</h3>
                    <p></p>
                  </div>
                </div>
              </a>
             
              <a href="#">
                <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="tile-stats hvr-underline-reveal">
                    <div class="icon"><i class="fa fa-check-square"></i></div>
                    <div class="count"><br></div>
                    <h3>Laporan Hasil Pemeriksaan</h3>
                    <p></p>
                  </div>
                </div>
              </a>
            </div>
            <div class="">
              <a href="#">
              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats hvr-underline-reveal">
                  <div class="icon"><i class="fa fa-file-text"></i></div>
                  <div class="count"><br></div>
                  <h3>Penetapan Pajak/Retribusi</h3>
                  <p></p>
                </div>
              </div>
            </a>
            
             <a href="#">
              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats hvr-underline-reveal">
                  <div class="icon"><i class="fa fa-file-text-o"></i></div>
                  <div class="count"><br></div>
                  <h3>Penetapan<br>STPD/STRP</h3>
                  <p></p>
                </div>
              </div>
            </a>

            <a href="#">
               <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats hvr-underline-reveal">
                  <div class="icon"><i class="fa fa-money"></i></div>
                  <div class="count"><br></div>
                  <h3>Penerimaan (Setoran)</h3>
                  <p></p>
                </div>
              </div>
            </a>
           
            <a href="#">
              <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="tile-stats hvr-underline-reveal">
                  <div class="icon"><i class="fa fa-bank"></i></div>
                  <div class="count"><br></div>
                  <h3>Setoran Ke Bank</h3>
                  <p></p>
                </div>
              </div>
            </a>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
              <div class="x_panel tile  overflow_hidden">
                <div class="x_content">
                  <table class="" style="width:100%">
                    <tr>
                      <th style="width:37%;">
                        <p>Realisasi</p>
                      </th>
                      <th>
                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                          <p class="">Pajak/Retribusi</p>
                        </div>
                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
                          <p class="">Progress</p>
                        </div>
                      </th>
                    </tr>
                    <tr>
                      <td>
                        <canvas id="canvas1" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                      </td>
                      <td>
                        <table class="tile_info">
                          <tr>
                            <td>
                              <p><i class="fa fa-square blue"></i>Pajak Hotel </p>
                            </td>
                            <td>15%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Pajak Restoran  </p>
                            </td>
                            <td>5%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square purple"></i>Pajak Hiburan </p>
                            </td>
                            <td>10%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square aero"></i>Pajak Reklame </p>
                            </td>
                            <td>5%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square red"></i>Pajak Penerangan Jalan </p>
                            </td>
                            <td>15%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Pajak Mineral Bukan Logam dan Batuan</p>
                            </td>
                            <td>5%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Pajak Parkir</p>
                            </td>
                            <td>15%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Pajak Air Tanah</p>
                            </td>
                            <td>15%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Pajak Sarang Burung Walet</p>
                            </td>
                            <td>10%</td>
                          </tr>
                          <tr>
                            <td>
                              <p><i class="fa fa-square green"></i>Retribusi Kekayaan Daerah </p>
                            </td>
                            <td>5%</td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Jatuh Tempo</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item One Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Two Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month">April</p>
                        <p class="day">23</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">Item Three Title</a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                      </div>
                    </article>
                  </div>
                </div>
              </div>
          </div>

@endsection

@push('scripts')

    <!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- Doughnut Chart -->
    <script>
      $(document).ready(function() {
        var options = {
          legend: false,
          responsive: false
        };

        new Chart(document.getElementById("canvas1"), {
          type: 'doughnut',
          tooltipFillColor: "rgba(51, 51, 51, 0.55)",
          data: {
            labels: [
              'Pajak Hotel',
              'Pajak Restoran',
              'Pajak Hiburan',
              'Pajak Reklame',
              'Pajak Penerangan Jalan',
              'Pajak Mineral Bukan Logam dan Batuan',
              'Pajak Parkir',
              'Pajak Air Tanah',
              'Pajak Sarang Burung Walet',
              'Retribusi Kekayaan Daerah'
            ],
            datasets: [{
              data: [15, 5, 10, 5, 15, 5, 15, 15, 10, 5,],
              backgroundColor: [
                "#BDC3C7",
                "#9B59B6",
                "#E74C3C",
                "#26B99A",
                "#26B99A",
                "#26B99A",
                "#26B99A",
                "#26B99A",
                "#26B99A",
                "#3498DB"
              ],
              hoverBackgroundColor: [
                "#CFD4D8",
                "#B370CF",
                "#E95E4F",
                "#36CAAB",
                "#36CAAB",
                "#36CAAB",
                "#36CAAB",
                "#36CAAB",
                "#36CAAB",
                "#49A9EA"
              ]
            }]
          },
          options: options
        });
      });
    </script>
    <!-- /Doughnut Chart -->
@endpush