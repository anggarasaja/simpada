<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Simpada </title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Bootstrap -->
    <link href="{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- Animate.css -->
    <!-- <link href="../vendors/animate.css/animate.min.css" rel="stylesheet"> -->

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }}" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
              {{ csrf_field() }}
              <h1>Login Form</h1>
              <div class="form-group{{ $errors->has('opr_user') ? ' has-error' : '' }}">
                <input id="opr_user" type="text" class="form-control" name="opr_user" value="{{ old('opr_user') }}" placeholder="Username">

                @if ($errors->has('opr_user'))
                    <span class="help-block">
                        <strong>{{ $errors->first('opr_user') }}</strong>
                    </span>
                @endif
              </div>
              <div class="form-group{{ $errors->has('opr_passwd') ? ' has-error' : '' }}">
                <input id="opr_passwd" type="password" class="form-control" name="opr_passwd" placeholder="Password">

                @if ($errors->has('opr_passwd'))
                    <span class="help-block">
                        <strong>{{ $errors->first('opr_passwd') }}</strong>
                    </span>
                @endif
              </div>
              <div>
                <!-- <div class="form-group">
                          <div class="col-md-6 col-md-offset-4">
                              <div class="checkbox">
                                  <label>
                                      <input type="checkbox" name="remember"> Remember Me
                                  </label>
                              </div>
                          </div>
                      </div> -->

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-btn fa-sign-in"></i> Login
                </button>

                <!-- <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a> -->

              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><img src="{{ URL::asset('images/img.jpg') }}" class="img-circle" alt="LOGO" style="width:10%;height:10%"> SIMPADA</h1>
                  <p>©2016 All Rights Reserved</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
