@extends('layouts.layout')

@section('content')
          <!-- top tiles -->
          <!-- <div class="row tile_count">
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> WP Pribadi</span>
              <div class="count green">{{$pribadi or ''}}</div>
              <span class="count_bottom"><i class="green">4% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> WR Pribadi</sian>
              <div class="count green">{{$pribadi or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> WP Badan Usaha</span>
              <div class="count green">{{$bu or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> WR Badan Usaha</span>
              <div class="count green">{{$bu or ''}}</div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> LHP</span>
                <div class="count">{{$lhp or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Penetapan</span>
                <div class="count">{{$spt or ''}}</div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
            </div>
          </div> -->
          <!-- /top tiles -->
          

            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ URL::to('/daftar-pribadi/create')}}" >
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-user"></i></div>
                    <div class="count">{{$pribadi or '0'}}</div>
                      <h3>Pendaftaran</h3>
                    <p>WP/WR Pribadi</p>
                  </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ URL::to('/daftar-bu/create')}}">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-users"></i></div>
                    <div class="count">{{$bu or '0'}}</div>
                      <h3>Pendaftaran</h3>
                    <p>WP/WR Badan Usaha</p>
                  </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ URL::to('/pendataan/rekam_data')}}">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-list-alt"></i></div>
                    <div class="count">{{$spt or '0'}}</div>
                      <h3>Pendataan</h3>
                    <p>SPT</p>
                  </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="#">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-check-square-o"></i></div>
                    <div class="count">{{$lhp or '0'}}</div>
                      <h3>LHP</h3>
                    <p>Laporan Hasil Pemeriksaan</p>
                  </div>
                </a>
              </div>
            </div>

            <div class="row top_tiles">
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{ URL::to('penetapan/table') }}">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-file-text"></i></div>
                    <div class="count"><br></div>
                    <h3>Penetapan</h3>
                    <p>Pajak/Retribusi</p>
                  </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="#">
                  <div class="tile-stats">
                    <div class="icon"><i class="fa fa-file-text-o"></i></div>
                    <div class="count"><br></div>
                      <h3>Penetapan</h3>
                    <p>STPD/STRP</p>
                  </div>
                </a>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="{{URL::to('penyetoran')}}">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-money"></i></div>
                  <div class="count"><br></div>
                    <h3>Penerimaan</h3>
                  <p>Setoran</p>
                </div>
              </div>
              <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a href="#">
                <div class="tile-stats">
                  <div class="icon"><i class="fa fa-bank"></i></div>
                  <div class="count"><br></div>
                    <h3>Setoran</h3>
                  <p>Bank</p>
                </div>
                </a>
              </div>
            </div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_content">
                    <div id="mainb" style="height:350px;"></div>
                  </div>
                </div>
              </div>
          </div>

          <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Jatuh Tempo</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    @foreach($getnetapajrek as $key)
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="day">{{ date('d',strtotime($key->netapajrek_tgl_jatuh_tempo)) }}</p>
                        <p class="month">{{ date('M Y',strtotime($key->netapajrek_tgl_jatuh_tempo)) }}</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">({{ $key->npwprd }}) {{ $key->wp_wr_nama }}</a>
                        <p>{{ $key->cnaskah }}</p>
                        <p>{{ $key->clokasi }}</p>
                      </div>
                    </article>
                    @endforeach
                    <div class="pull-right">
                      <button class="btn btn-md btn-primary">See more...</button>
                    </div>
                  </div>
                </div>
              </div>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>3 Bulan Transaksi Terakhir</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    @foreach($getnetapajrek as $key)
                    <article class="media event">
                      <a class="pull-left date">
                        <p class="day">{{ date('d',strtotime($key->netapajrek_tgl_jatuh_tempo)) }}</p>
                        <p class="month">{{ date('M Y',strtotime($key->netapajrek_tgl_jatuh_tempo)) }}</p>
                      </a>
                      <div class="media-body">
                        <a class="title" href="#">({{ $key->npwprd }}) {{ $key->wp_wr_nama }}</a>
                        <p>{{ $key->cnaskah }}</p>
                        <p>{{ $key->clokasi }}</p>
                      </div>
                    </article>
                    @endforeach
                    <div class="pull-right">
                      <button class="btn btn-md btn-primary">See more...</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>

@endsection

@push('scripts')

    <!-- Chart.js -->
    <script src="{{ asset('vendors/Chart.js/dist/Chart.min.js') }}"></script>
    <!-- ECharts -->
    <script src="{{ asset('vendors/echarts/dist/echarts.min.js') }}"></script>
    <script src="{{ asset('vendors/echarts/map/js/world.js') }}"></script>
    <script>
      $(document).ready(function() {
        var theme = {
          color: [
              '#26B99A', '#34495E', '#BDC3C7', '#3498DB',
              '#9B59B6', '#8abb6f', '#759c6a', '#bfd3b7'
          ],

          title: {
              itemGap: 8,
              textStyle: {
                  fontWeight: 'normal',
                  color: '#408829'
              }
          },

          dataRange: {
              color: ['#1f610a', '#97b58d']
          },

          toolbox: {
              color: ['#408829', '#408829', '#408829', '#408829']
          },

          tooltip: {
              backgroundColor: 'rgba(0,0,0,0.5)',
              axisPointer: {
                  type: 'line',
                  lineStyle: {
                      color: '#408829',
                      type: 'dashed'
                  },
                  crossStyle: {
                      color: '#408829'
                  },
                  shadowStyle: {
                      color: 'rgba(200,200,200,0.3)'
                  }
              }
          },

          dataZoom: {
              dataBackgroundColor: '#eee',
              fillerColor: 'rgba(64,136,41,0.2)',
              handleColor: '#408829'
          },
          grid: {
              borderWidth: 0
          },

          categoryAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },

          valueAxis: {
              axisLine: {
                  lineStyle: {
                      color: '#408829'
                  }
              },
              splitArea: {
                  show: true,
                  areaStyle: {
                      color: ['rgba(250,250,250,0.1)', 'rgba(200,200,200,0.1)']
                  }
              },
              splitLine: {
                  lineStyle: {
                      color: ['#eee']
                  }
              }
          },
          timeline: {
              lineStyle: {
                  color: '#408829'
              },
              controlStyle: {
                  normal: {color: '#408829'},
                  emphasis: {color: '#408829'}
              }
          },

          k: {
              itemStyle: {
                  normal: {
                      color: '#68a54a',
                      color0: '#a9cba2',
                      lineStyle: {
                          width: 1,
                          color: '#408829',
                          color0: '#86b379'
                      }
                  }
              }
          },
          map: {
              itemStyle: {
                  normal: {
                      areaStyle: {
                          color: '#ddd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  },
                  emphasis: {
                      areaStyle: {
                          color: '#99d2dd'
                      },
                      label: {
                          textStyle: {
                              color: '#c12e34'
                          }
                      }
                  }
              }
          },
          force: {
              itemStyle: {
                  normal: {
                      linkStyle: {
                          strokeColor: '#408829'
                      }
                  }
              }
          },
          chord: {
              padding: 4,
              itemStyle: {
                  normal: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  },
                  emphasis: {
                      lineStyle: {
                          width: 1,
                          color: 'rgba(128, 128, 128, 0.5)'
                      },
                      chordStyle: {
                          lineStyle: {
                              width: 1,
                              color: 'rgba(128, 128, 128, 0.5)'
                          }
                      }
                  }
              }
          },
          gauge: {
              startAngle: 225,
              endAngle: -45,
              axisLine: {
                  show: true,
                  lineStyle: {
                      color: [[0.2, '#86b379'], [0.8, '#68a54a'], [1, '#408829']],
                      width: 8
                  }
              },
              axisTick: {
                  splitNumber: 10,
                  length: 12,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              axisLabel: {
                  textStyle: {
                      color: 'auto'
                  }
              },
              splitLine: {
                  length: 18,
                  lineStyle: {
                      color: 'auto'
                  }
              },
              pointer: {
                  length: '90%',
                  color: 'auto'
              },
              title: {
                  textStyle: {
                      color: '#333'
                  }
              },
              detail: {
                  textStyle: {
                      color: 'auto'
                  }
              }
          },
          textStyle: {
              fontFamily: 'Arial, Verdana, sans-serif'
          }
      };

        var echartBar = echarts.init(document.getElementById('mainb'), theme);

        echartBar.setOption({
          title: {
            text: 'Anggaran vs Realisasi',
            subtext: 'Objek Pajak'
          },
          tooltip: {
            trigger: 'axis'
          },
          legend: {
            data: ['Anggaran', 'Realisasi']
          },
          toolbox: {
            show: false
          },
          calculable: false,
          xAxis: [{
            type: 'category',
            data: ['Hotel', 'Restoran', 'Hiburan', 'Reklame', 'PPJ', 'Mineral','Parkir', 'Air Tanah', 'Sarang', 'Retribusi']
          }],
          yAxis: [{
            type: 'value'
          }],
          series: [{
            name: 'Anggaran',
            type: 'bar',
            data: [200000.0, 400000.9, 700000.0, 2300000.2, 2500000.6, 7600000.7, 13500000.6, 16200000.2, 3200000.6, 2000000.0,],
            markPoint: {
              data: [{
                type: 'max',
                name: '???'
              }, {
                type: 'min',
                name: '???'
              }]
            },
            markLine: {
              data: [{
                type: 'average',
                name: '???'
              }]
            }
          }, {
            name: 'Realisasi',
            type: 'bar',
            data: [200000.6, 500000.9, 900000.0, 2600000.4, 2800000.7, 7000000.7, 17500000.6, 18200000.2, 4800000.7, 1800000.8,],
            markPoint: {
              data: [{
                name: 'Anggaran',
                value: 182.2,
                xAxis: 7,
                yAxis: 183,
              }, {
                name: 'Realisasi',
                value: 2.3,
                xAxis: 11,
                yAxis: 3
              }]
            },
            markLine: {
              data: [{
                type: 'average',
                name: '???'
              }]
            }
          }]
        });
      });
    </script>
    <!-- /Doughnut Chart -->
@endpush