@extends('layouts.layout')
@section('content')
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Pilihan Pajak</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="x_panel">
          <!-- <div class="x_title">
            <h2>Daftar Wajib Pajak</h2>
            <ul class="nav navbar-right panel_toolbox">
              <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
              </li>
            </ul>
            <div class="clearfix"></div>
          </div> -->
          <div class="x_content">
                <table id="datatable" class="table table-striped table-bordered bulk_action">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Pilihan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $x = 1;?>
                    @foreach($getpajak as $key)
                    <tr>
                      <td>{{ $x }}</td>
                      <td><a href="{{ url('pendataan/sptpd/'.$key->ref_jenparet_id) }}"> {{ $key->ref_jenparet_ket }}</a></td>
                    </tr>
                    <?php $x++; ?>
                    @endforeach
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
        // var $datatable = $('#datatable');

        // $datatable.dataTable({
        //   'order': [[ 0, 'asc' ]],

        // });
      });
    </script>
@endpush