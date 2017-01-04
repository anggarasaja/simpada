@extends('layouts.layout')

@section('content')
          <!-- top tiles -->
          <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total WP Pribadi</span>
              <div class="count green">{{$pribadi or ''}}</div>
              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total WR Pribadi</sian>
              <div class="count green">{{$pribadi or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total WP Badan Usaha</span>
              <div class="count green">{{$bu or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total WR Badan Usaha</span>
              <div class="count green">{{$bu or ''}}</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total LHP</span>
                <div class="count">{{$lhp or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Penetapan</span>
                <div class="count">{{$spt or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
          </div>
          <!-- /top tiles -->

          <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Transaction Summary <small>Weekly progress</small></h2>
                    <div class="filter">
                      <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                        <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                        <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <div class="demo-container">
                        <div id="placeholder33x" class="demo-placeholder"></div>
                      </div>
                    </div>

                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <div class="x_title">
                          <h2>Pajak/Retribusi</h2>
                          <div class="clearfix"></div>
                        </div>
                        <ul class="list-unstyled scroll-view">
                          <li class="media event">
                            <a class="pull-left border-aero">
                              <i class="fa fa-money aero"></i>
                            </a>
                            <div class="media-body">
                              <a class="title" href="#">Official Assessment</a>
                              <p><strong>Rp 2.300.000 </strong></p>
                              <!-- <p> <small>12 Sales Today</small> -->
                              </p>
                            </div>
                          </li>
                          <li class="media event">
                            <a class="pull-left border-aero">
                              <i class="fa fa-money aero"></i>
                            </a>
                            <div class="media-body">
                              <a class="title" href="#">Self Assessment</a>
                              <p><strong>Rp 2.300.000 </strong></p>
                              <!-- <p> <small>12 Sales Today</small> -->
                              </p>
                            </div>
                          </li>
                        </ul>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          
          <div class="row col-md-6">
            <span class="count_top"><i class="fa fa-gear"></i> Quick Menu</span>
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

          <div class="row">
            <a href="/penetapan/table">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats hvr-underline-reveal">
                  <div class="icon"><i class="fa fa-list-alt"></i></div>
                  <div class="count">0</div>
                  <h3>Pendataan SPT</h3>
                  <p></p>
                </div>
              </div>
            </a>
           
            <a href="#">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="tile-stats hvr-underline-reveal">
                  <div class="icon"><i class="fa fa-check-square"></i></div>
                  <div class="count">{{$lhp or ''}}</div>
                  <h3>LHP</h3>
                  <p></p>
                </div>
              </div>
            </a>
            
            <a href="#">
               <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
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
    <!-- DateJS -->
    <script src="{{ asset('vendors/DateJS/build/date.js')}}"></script>
    <!-- Flot -->
    <script src="{{ asset('vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
  <script>
    $(document).ready(function() {
      var cb = function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        };

        var optionSet1 = {
          startDate: moment().subtract(29, 'days'),
          endDate: moment(),
          minDate: '01/01/2012',
          maxDate: '12/31/2015',
          dateLimit: {
            days: 60
          },
          showDropdowns: true,
          showWeekNumbers: true,
          timePicker: false,
          timePickerIncrement: 1,
          timePicker12Hour: true,
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          opens: 'left',
          buttonClasses: ['btn btn-default'],
          applyClass: 'btn-small btn-primary',
          cancelClass: 'btn-small',
          format: 'MM/DD/YYYY',
          separator: ' to ',
          locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Clear',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
          }
        };
        $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));
        $('#reportrange').daterangepicker(optionSet1, cb);
        $('#reportrange').on('show.daterangepicker', function() {
          console.log("show event fired");
        });
        $('#reportrange').on('hide.daterangepicker', function() {
          console.log("hide event fired");
        });
        $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
          console.log("apply event fired, start/end dates are " + picker.startDate.format('MMMM D, YYYY') + " to " + picker.endDate.format('MMMM D, YYYY'));
        });
        $('#reportrange').on('cancel.daterangepicker', function(ev, picker) {
          console.log("cancel event fired");
        });
        $('#options1').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet1, cb);
        });
        $('#options2').click(function() {
          $('#reportrange').data('daterangepicker').setOptions(optionSet2, cb);
        });
        $('#destroy').click(function() {
          $('#reportrange').data('daterangepicker').remove();
        });
      });
  </script>

  <!-- Flot -->
    <script>
      $(document).ready(function() {
        //define chart clolors ( you maybe add more colors if you want or flot will add it automatic )
        var chartColours = ['#96CA59', '#3F97EB', '#72c380', '#6f7a8a', '#f7cb38', '#5a8022', '#2c7282'];

        //generate random number for charts
        randNum = function() {
          return (Math.floor(Math.random() * (1 + 40 - 20))) + 20;
        };

        var d1 = [];
        //var d2 = [];

        //here we generate data for chart
        for (var i = 0; i < 30; i++) {
          d1.push([new Date(Date.today().add(i).days()).getTime(), randNum() + i + i + 10]);
          //    d2.push([new Date(Date.today().add(i).days()).getTime(), randNum()]);
        }

        var chartMinDate = d1[0][0]; //first day
        var chartMaxDate = d1[20][0]; //last day

        var tickSize = [1, "day"];
        var tformat = "%d/%m/%y";

        //graph options
        var options = {
          grid: {
            show: true,
            aboveData: true,
            color: "#3f3f3f",
            labelMargin: 10,
            axisMargin: 0,
            borderWidth: 0,
            borderColor: null,
            minBorderMargin: 5,
            clickable: true,
            hoverable: true,
            autoHighlight: true,
            mouseActiveRadius: 100
          },
          series: {
            lines: {
              show: true,
              fill: true,
              lineWidth: 2,
              steps: false
            },
            points: {
              show: true,
              radius: 4.5,
              symbol: "circle",
              lineWidth: 3.0
            }
          },
          legend: {
            position: "ne",
            margin: [0, -25],
            noColumns: 0,
            labelBoxBorderColor: null,
            labelFormatter: function(label, series) {
              // just add some space to labes
              return label + '&nbsp;&nbsp;';
            },
            width: 40,
            height: 1
          },
          colors: chartColours,
          shadowSize: 0,
          tooltip: true, //activate tooltip
          tooltipOpts: {
            content: "%s: %y.0",
            xDateFormat: "%d/%m",
            shifts: {
              x: -30,
              y: -50
            },
            defaultTheme: false
          },
          yaxis: {
            min: 0
          },
          xaxis: {
            mode: "time",
            minTickSize: tickSize,
            timeformat: tformat,
            min: chartMinDate,
            max: chartMaxDate
          }
        };
        var plot = $.plot($("#placeholder33x"), [{
          label: "Realisasi",
          data: d1,
          lines: {
            fillColor: "rgba(150, 202, 89, 0.12)"
          }, //#96CA59 rgba(150, 202, 89, 0.42)
          points: {
            fillColor: "#fff"
          }
        }], options);
      });
    </script>
    <!-- /Flot -->

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