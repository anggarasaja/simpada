@extends('layouts.layout')
@section('content')
<div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Form Penutupan WP/WR
      </div>

      <div class="title_right">
      </div>
    </div>
    <div class="clearfix"></div>

    <form action="{{url('daftar/proses_tutup_wpwr')}}" class="form-horizontal form-label-left" method="POST">
    <div class="row">
      <div class="col-md-12 col-xs-12">
        <!-- <div class="col-md-12 col-sm-12 col-xs-12"> -->
          <div class="x_panel">
            
            <div class="x_content">
              <br>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <!-- <input type="hidden" id="setorpajret_id_penetapan" name="setorpajret_id_penetapan" > -->
              @if (session()->has('flash_notification.message'))
                  <div class="alert alert-{{ session('flash_notification.level') }}">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                      {!! session('flash_notification.message') !!}
                  </div>
              @endif
              
                
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="tgl_entry">Tanggal Penutupan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                   <input data-provide="datepicker" data-inputmask="'mask': '99/99/9999'" data-date-format="dd/mm/yyyy" id="tgl_entry" name="tgl_entry" class="date-picker form-control col-md-7 col-xs-12 active tanggal" required="required" type="text" value="{{ (isset($id_spt)) ? date('d/m/Y', strtotime($spt->spt_tgl_entry)) : date('d/m/Y') }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="npwpd">NPWPD
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <div class="input-group">
                      <input type="text" id="npwpd" name="npwpd" onchange="getnpwpd()" data-inputmask="'mask': 'P.9.9999999.99.999'" required="required" class="npwpd form-control col-md-7 col-xs-12" placeholder="P._._______.__.___" value="{{ (isset($id_spt)) ? $wp_wr->npwprd : '' }}">
                      <span class="input-group-btn">
                        <button id="modal" class="btn btn-info" type="button" data-toggle="modal" data-target="#mdl1">...</button>
                      </span>
                    </div>
                  </div>
                </div>
                <input type="hidden" id="id_wpwr" name="id_wpwr" value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_id : '' }}">
                <div class="item form-group">
                  <label for="nama_wp" class="control-label col-md-3 col-sm-3 col-xs-12">Nama WP</label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="nama_wp" class="form-control col-md-7 col-xs-12" type="text" name="nama_wp" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_nama : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="alamat">Alamat 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="alamat" required="required" name="alamat" class="form-control col-md-7 col-xs-12" readonly>{{ (isset($id_spt)) ? $wp_wr->wp_wr_almt : '' }}</textarea>
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="lurah">Kelurahan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="lurah" type="text" name="lurah" class="optional form-control col-md-7 col-xs-12" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_lurah : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="camat">Kecamatan 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="camat" type="text" name="camat" class="optional form-control col-md-7 col-xs-12" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_camat : '' }}">
                  </div>
                </div>
                 <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="kota">Kabupaten/Kota 
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="kota" type="text" name="kota" class="optional form-control col-md-7 col-xs-12" readonly value="{{ (isset($id_spt)) ? $wp_wr->wp_wr_kabupaten : '' }}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="noberita">No. Berita Acara
                  </label>
                  <div class="col-md-2 col-sm-6 col-xs-12">
                      <input id="noberita" class="form-control col-md-7 col-xs-12" data-validate-length-range="6" data-validate-words="2" name="noberita" placeholder="" required="required" type="text" value="{{ (isset($id_spt)) ? $spt->spt_nomor : ''}}">
                  </div>
                </div>
                <div class="item form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12" for="berita">No. Berita Acara
                  </label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <textarea id="berita" required="required" name="berita" class="form-control col-md-7 col-xs-12">{{ (isset($id_spt)) ? $wp_wr->wp_wr_almt : '' }}</textarea>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
                      <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Proses</button>
                  </div>
                </div>
            </div>
          </div>
      </div>
    </div>
  </form>
  </div>

  <div id="mdl1" class="modal fade bs-example-modal-lg mdl1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
              </button>
              <h4 class="modal-title" id="myModalLabel">Tabel Referensi Wajib Pajak</h4>
            </div>
            <div class="modal-body" style="overflow-x: auto;white-space: nowrap;">
              <input type="hidden" id="a" onload="gettable()">
            <table id="table-npwpd" class="table table-striped table-bordered hover" >
              <thead>
                <tr>
                  <!-- <th>No</th> -->
                  <th>No. Pendaftaran</th>
                  <th>NPWP</th>
                  <th>No. Kartu WP/WR</th>
                  <th>Nama WP/WR</th>
                  <th>Alamat</th>
                  <th>Kelurahan</th>
                  <th>Kecamatan</th>
                  <th>Kabupaten</th>
                  <th></th>
                </tr>
              </thead>
              <tbody data-dismiss="modal"></tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>
    var oTable ;
    var status = '{{$status or ''}}';
      $(document).ready(function() {
        if(status=='1'){
          berhasil();
        }
        $(":input").inputmask();
        $('#example tbody')
        .on( 'mouseenter', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            $( table.cells().nodes() ).removeClass( 'highlight' );
            $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
        });
      });

      function berhasil(){
        new PNotify({
                title: 'BERHASIL',
                text: 'Penutupan data telah berhasil',
                type: 'success',
                styling: 'bootstrap3'
            });
      }

      $(document).on("click", "#modal", function () {
        oTable = $('#table-npwpd').DataTable();
           gettablenpwpd();
      });

      function getnpwpd(){
        var npwpd = $('#npwpd').val();
        $.ajax({
          type: "GET",
          url: "{{url('pendataan/getnpwpd')}}/"+npwpd,
          data: {}
        }).success(function(e){
          var obj = JSON.parse(e);
          var id_wpwr = obj[0].wp_wr_id;
          var nama_wp = obj[0].wp_wr_nama;
          var alamat = obj[0].wp_wr_almt;
          var lurah = obj[0].wp_wr_lurah;
          var camat = obj[0].wp_wr_camat;
          var kota = obj[0].wp_wr_kabupaten;
          var id = obj[0].wp_wr_id;

          $('#id_wpwr').val(id_wpwr);
          $('#nama_wp').val(nama_wp);
          $('#alamat').val(alamat);
          $('#lurah').val(lurah);
          $('#camat').val(camat);
          $('#kota').val(kota);

        });
      }

      function gettablenpwpd(){
        oTable.destroy();
         oTable = $('#table-npwpd').DataTable({
          processing: true,
          serverSide: true,    
          ajax: {
            url: "{{ URL::to('pendataan/getnpwpd/') }}",
            type: "GET",
            data: {  },
          },
          columns: [
              { data: 'no_reg', name: 'no_reg' },
              { data: 'npwprd', name: 'npwprd' },
              { data: 'wp_wr_no_kartu', name: 'wp_wr_no_kartu' },
              { data: 'wp_wr_nama', name: 'wp_wr_nama' },
              { data: 'wp_wr_almt', name: 'wp_wr_almt' },
              { data: 'wp_wr_lurah', name: 'wp_wr_lurah' },
              { data: 'wp_wr_camat', name: 'wp_wr_camat' },
              { data: 'wp_wr_kabupaten', name: 'wp_wr_kabupaten' },
              { data: 'wp_wr_id', visible:false, name: 'wp_wr_id' },
          ],
          order: [[ 0, "desc" ]]
        });
      }

      $('#table-npwpd tbody').on("click", "tr td", function () {
          var sData = oTable.row( this ).data();
          // console.log(sData );

          var npwpd = $(this).closest("tr").children("td").eq(1).html();
          var nama_wp = $(this).closest("tr").children("td").eq(3).html();
          var alamat = $(this).closest("tr").children("td").eq(4).html();
          var lurah = $(this).closest("tr").children("td").eq(5).html();
          var camat = $(this).closest("tr").children("td").eq(6).html();
          var kota = $(this).closest("tr").children("td").eq(7).html();

          var id = sData.wp_wr_id;

          $('#id_wpwr').val(id);
          $('#npwpd').val(npwpd);
          $('#nama_wp').val(nama_wp);
          $('#alamat').val(alamat);
          $('#lurah').val(lurah);
          $('#camat').val(camat);
          $('#kota').val(kota);
        } );


      function tanggal(){
        var awal = $('#pajak_awal').val();
        var value = awal.split('/');
        var tahun = value[2];
        var bulan = value[1];
        var tanggal = value[0];
        var akhir = new Date(tahun, bulan,  0, 23, 59, 59);
        var bulan_akhir = (akhir.getMonth() + 1);
        if (bulan_akhir < 10) {
          var bulan_akhir = '0'+bulan_akhir;
        };
        var tgl_akhir = akhir.getDate()+'/'+bulan_akhir+'/'+akhir.getFullYear();
        $('#pajak_akhir').val(tgl_akhir);
      }
    </script>
@endpush