@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('opr_user') ? ' has-error' : '' }}">
                            <label for="opr_user" class="col-md-4 control-label">Username</label>

                            <div class="col-md-6">
                                <input id="opr_user" type="text" class="form-control" name="opr_user" value="{{ old('opr_user') }}">

                                @if ($errors->has('opr_user'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('opr_user') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('opr_passwd') ? ' has-error' : '' }}">
                            <label for="opr_passwd" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="opr_passwd" type="password" class="form-control" name="opr_passwd">

                                @if ($errors->has('opr_passwd'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('opr_passwd') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div> -->

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>

                                <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
