<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Simpatda </title>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('faviconSIMPADA.ico')); ?>">

    <?php echo Html::style('vendors/bootstrap/dist/css/bootstrap.min.css');; ?>

    <?php echo Html::style('vendors/font-awesome/css/font-awesome.min.css');; ?>

    <?php echo Html::style('vendors/nprogress/nprogress.css');; ?>

    <?php echo Html::style('vendors/iCheck/skins/flat/green.css');; ?>

    <?php echo Html::style('css/datepicker/bootstrap-datepicker.min.css');; ?>

    <?php echo Html::style('vendor/datatables/DataTables-1.10.12/css/jquery.dataTables.min.css');; ?>

    <?php echo Html::style('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css');; ?>

    <?php echo Html::style('vendors/pnotify/dist/pnotify.css');; ?>

    <?php echo Html::style('vendors/pnotify/dist/pnotify.buttons.css');; ?>

    <?php echo Html::style('vendors/pnotify/dist/pnotify.nonblock.css');; ?>

    <?php echo Html::style('vendors/Hover-master/css/hover-min.css');; ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
    <?php echo Html::style('build/css/custom.css');; ?>


    <!-- Datatables -->
    <link href="<?php echo e(asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')); ?>" rel="stylesheet">

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col menu_fixed">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo e(URL::to('/')); ?>" class="site_title"><i class="fa fa-plus-circle"></i> <span>SIMPADA-PLUS</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile">
              <div class="profile_pic">
                <img src="<?php echo e(URL::asset('images/img.jpg')); ?>" alt="profile" class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Admin</span>
                <h2>BPK</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <!-- sidebar menu -->
            <?php echo $__env->make('includes.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <!-- /sidebar menu -->

          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo e(URL::asset('images/img.jpg')); ?>" alt="">BPK
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;"> Profil</a></li>
                    <li>
                      <a href="javascript:;">
                        <span>Ganti Password</span>
                      </a>
                    </li>
                    <!-- <li><a href="javascript:;">Help</a></li> -->
                    <li><a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-sign-out pull-right"></i> Keluar</a></li>
                  </ul>
                </li>

                <!-- <li role="presentation" class="dropdown">
                  <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green">6</span>
                  </a>
                  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <a>
                        <span class="image"><img src="images/img.jpg" alt="Profile Image" /></span>
                        <span>
                          <span>John Smith</span>
                          <span class="time">3 mins ago</span>
                        </span>
                        <span class="message">
                          Film festivals used to be do-or-die moments for movie makers. They were where...
                        </span>
                      </a>
                    </li>
                    <li>
                      <div class="text-center">
                        <a>
                          <strong>See All Alerts</strong>
                          <i class="fa fa-angle-right"></i>
                        </a>
                      </div>
                    </li>
                  </ul>
                </li> -->
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
        <?php echo $__env->yieldContent('content'); ?>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
         <!--  <div class="pull-right">
            Gentelella - Bootstrap Admin Template by <a href="https://colorlib.com">Colorlib</a>
          </div> -->
           <div class="pull-right">
            Simpatda-Plus Kota Pekalongan
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

        <!-- jQuery -->
    <script src="<?php echo e(URL::asset('vendors/jquery/dist/jquery.min.js')); ?>"></script>

        <!-- bootstrap-daterangepicker -->
    <script src="<?php echo e(URL::asset('js/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('js/datepicker/bootstrap-datepicker.min.js')); ?>"></script>
    <!-- <script src="js/datepicker/daterangepicker.js"></script> -->
     <!-- Bootstrap -->
    <script src="<?php echo e(URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo e(URL::asset('vendors/fastclick/lib/fastclick.js')); ?>"></script>
    <!-- NProgress -->
    <script src="<?php echo e(URL::asset('vendors/nprogress/nprogress.js')); ?>"></script>
<<<<<<< HEAD
    <script src="<?php echo e(URL::asset('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>
=======
    <!-- iCheck -->
    <script src="<?php echo e(asset('vendors/iCheck/icheck.min.js')); ?>"></script>

    <!-- Datatables -->
    <script src="<?php echo e(asset('vendors/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-buttons/js/buttons.flash.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-buttons/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-buttons/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/datatables.net-scroller/js/datatables.scroller.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/jszip/dist/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/pdfmake/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('vendors/pdfmake/build/vfs_fonts.js')); ?>"></script>
    
>>>>>>> 6ec6ee61e942687e18887813e5d87b28c81a14c5
    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo e(URL::asset('build/js/custom.js')); ?>"></script>
    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    </script>
    <?php echo Html::script('vendors/pnotify/dist/pnotify.js');; ?>

    <?php echo Html::script('vendors/pnotify/dist/pnotify.buttons.js');; ?>

    <?php echo Html::script('vendors/pnotify/dist/pnotify.nonblock.js');; ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
  </body>
</html>
