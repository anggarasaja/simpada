 @extends('layouts.layout')
@section('content')
  <div class="row">

        <div class="x_panel">
        <h2> Operator Baru</h2>
        <hr>
        @if (session()->has('flash_notification.message'))
              <div class="alert alert-{{ session('flash_notification.level') }}">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                  {!! session('flash_notification.message') !!}
              </div>
          @endif
        <div class="x_title">
          <h2>Form Rekam</h2>
          <ul class="nav navbar-right panel_toolbox">
            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </li>
          </ul>
          <div class="clearfix"></div>
        </div>
        
        <div class="x_content">
          {{ Form::open(['url' => 'user']) }}
          {{ Form::token() }}
          <div class="item form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nama">Nama
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="nama"  class="form-control col-md-7 col-xs-12" type="text" name="nama" value="">
             @if ($errors->has('nama'))
                  <span class="help-block">
                      <strong>{{ $errors->first('nama') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="item form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="username">Username
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="username"  class="form-control col-md-7 col-xs-12" type="text" name="username" value="">
             @if ($errors->has('username'))
                  <span class="help-block">
                      <strong>{{ $errors->first('username') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="item form-group{{ $errors->has('pass1') ? ' has-error' : '' }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pass1">Password
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="pass1"  class="form-control col-md-7 col-xs-12" type="text" name="pass1" value="">
             @if ($errors->has('pass1'))
                  <span class="help-block">
                      <strong>{{ $errors->first('pass1') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="item form-group{{ $errors->has('pass2') ? ' has-error' : '' }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pass2">Confirm Password
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="pass2"  class="form-control col-md-7 col-xs-12" type="text" name="pass2" value="">
             @if ($errors->has('pass2'))
                  <span class="help-block">
                      <strong>{{ $errors->first('pass2') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          <div class="item form-group{{ $errors->has('jabatan') ? ' has-error' : '' }}">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="jabatan">Jabatan
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input id="jabatan"  class="form-control col-md-7 col-xs-12" type="text" name="jabatan" value="">
             @if ($errors->has('jabatan'))
                  <span class="help-block">
                      <strong>{{ $errors->first('jabatan') }}</strong>
                  </span>
              @endif
            </div>
          </div>
          {{ Form::close() }}
          </div>
          </div>
        
  
  </div>
@stop

 @push('scripts')
 {!! Html::script('vendor/datatables/DataTables-1.10.12/js/jquery.dataTables.min.js'); !!}
    <script>

      $(document).ready(function() {
        $('.dataTable th').addClass('bg-green');
        rmlTable = $('#table1').DataTable({
            "language": {
                "decimal": ",",
                "thousands": "."
            },
            processing: true,
            serverSide: true,
            ajax: "{{ URL::to('getdatauser') }}",
            columns: [
                { data: 'opr_nama', name: 'opr_nama' },
                { data: 'opr_user', name: 'opr_user' },
                { data: 'opr_nip', name: 'opr_nip' },
                { data: 'opr_level', name: 'opr_level' },
                { data: 'opr_status', name: 'opr_status' },
                { data: 'aksi', name: 'aksi' },
            ]
        });
        rmlTable.on( 'draw.dt', function () {
        });
      });

      $(document).on("click", ".btn-delete", function (e){
        e.preventDefault();
        var self = $(this);
        swal({
          title: "Apakah Anda Yakin?",
          text: "Anda akan menghapus salah satu data Operator!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Ya, Hapuskan!",
          cancelButtonText: "Tidak, Batalkan!",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm){
          if (isConfirm) {
             // $(this).parents("form").submit();
             swal("Deleted!", "Data Operator Berhasil Dihapus", "success");
             setTimeout(function() {
                    self.parents("form").submit();
                }, 2000);
          } else {
            swal("Batal", "Proses Telah Dibatalkan", "error");
          }
        });
      });
    </script>
@endpush