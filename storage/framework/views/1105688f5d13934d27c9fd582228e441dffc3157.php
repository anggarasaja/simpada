<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentellela Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?php echo e(URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo e(URL::asset('vendors/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo e(URL::asset('vendors/nprogress/nprogress.css')); ?>" rel="stylesheet">
    <!-- Animate.css -->
    <!-- <link href="../vendors/animate.css/animate.min.css" rel="stylesheet"> -->

    <!-- Custom Theme Style -->
    <link href="<?php echo e(URL::asset('build/css/custom.min.css')); ?>" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
              <?php echo e(csrf_field()); ?>

              <h1>Login Form</h1>
              <div class="form-group<?php echo e($errors->has('opr_user') ? ' has-error' : ''); ?>">
                <input id="opr_user" type="text" class="form-control" name="opr_user" value="<?php echo e(old('opr_user')); ?>" placeholder="Username">

                <?php if($errors->has('opr_user')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('opr_user')); ?></strong>
                    </span>
                <?php endif; ?>
              </div>
              <div class="form-group<?php echo e($errors->has('opr_passwd') ? ' has-error' : ''); ?>">
                <input id="opr_passwd" type="password" class="form-control" name="opr_passwd" placeholder="Password">

                <?php if($errors->has('opr_passwd')): ?>
                    <span class="help-block">
                        <strong><?php echo e($errors->first('opr_passwd')); ?></strong>
                    </span>
                <?php endif; ?>
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

                <!-- <a class="btn btn-link" href="<?php echo e(url('/password/reset')); ?>">Forgot Your Password?</a> -->

              </div>

              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-plus-circle"></i> SIMPATDA - PLUS</h1>
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
