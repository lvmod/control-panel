<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/Ionicons/css/ionicons.min.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/jvectormap/jquery-jvectormap.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="/vendor/control-panel/plugins/iCheck/all.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="/vendor/control-panel/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/vendor/control-panel/bower_components/select2/dist/css/select2.min.css">

    <link rel="stylesheet" href="/vendor/control-panel/plugins/sweetalert/lib/sweet-alert.css">
    <link rel="stylesheet" href="/vendor/control-panel/plugins/toastr/build/toastr.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="/vendor/control-panel/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/vendor/control-panel/dist/css/skins/_all-skins.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="/vendor/control-panel/dist/css/custom.css">

    <!-- jQuery 3 -->
    <script src="/vendor/control-panel/bower_components/jquery/dist/jquery.min.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        });
    </script>

    <script src="/vendor/control-panel/plugins/jquery-tmpl/jquery.tmpl.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/plugins/jquery-loading-overlay/loadingoverlay.min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/plugins/fotorama/fotorama.js"></script>

    <!-- BACKBONE SCRIPTS -->
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/underscore/underscore-min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/JSON-js/json2.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/backbone/backbone-min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/components/backbone.bootstrap-modal/src/backbone.bootstrap-modal.js"></script>
    <!-- <script type="text/javascript" src="/vendor/control-panel/plugins/isotope/isotope.pkgd.min.js"></script>
        <script type="text/javascript" src="/vendor/control-panel/plugins/iCheck/icheck.min.js"></script> -->

    <!-- START APPLICATION SCRIPTS -->
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/Utils.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/UID.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/PluginsManager.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/helper/TemplateManager.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/model/FileModel.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/model/FilesModel.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/model/ArticleFilesModel.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/collection/FileCollection.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FileView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FilesView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/ArticleFilesView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/BasicImageView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/GalleryAppendView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FolderNameModal.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FileLinkModal.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FileManagerView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/FileManagerDialogView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/MaterialView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/MaterialsView.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/backbone/application/view/MaterialsDialogView.js"></script>

    <!-- END APPLICATION SCRIPTS -->
</head>
<!-- <body class="hold-transition skin-blue sidebar-mini"> -->

<body class="hold-transition skin-black-light sidebar-mini">
    <div class="wrapper">
        <header class="main-header">

            <!-- Logo -->
            <a href="/control" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>

            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Переключить навигацию</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="{{ route('logout') }}" class="left-topbar-item" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>

            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/vendor/control-panel/dist/img/empty.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p title="{{ Auth::user()->email }}">{{ Auth::user()->name }}</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- search form -->
                <!-- <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form> -->
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->

                <ul class="sidebar-menu" data-widget="tree">
                    @include('control::helpers.menu', ['items'=>app()->controlMenu->get()])

                    <!-- <li>
                            <a href="/vendor/control-panel/pages/widgets.html">
                                <i class="fa fa-th"></i> <span>Widgets</span>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-green">new</small>
                                </span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-pie-chart"></i>
                                <span>Charts</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/vendor/control-panel/pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
                                <li><a href="/vendor/control-panel/pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
                                <li><a href="/vendor/control-panel/pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
                                <li><a href="/vendor/control-panel/pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>UI Elements</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/vendor/control-panel/pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
                                <li><a href="/vendor/control-panel/pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
                                <li><a href="/vendor/control-panel/pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
                                <li><a href="/vendor/control-panel/pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
                                <li><a href="/vendor/control-panel/pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
                                <li><a href="/vendor/control-panel/pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-edit"></i> <span>Forms</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/vendor/control-panel/pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
                                <li><a href="/vendor/control-panel/pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
                                <li><a href="/vendor/control-panel/pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Tables</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/vendor/control-panel/pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
                                <li><a href="/vendor/control-panel/pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="/vendor/control-panel/pages/calendar.html">
                                <i class="fa fa-calendar"></i> <span>Calendar</span>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-red">3</small>
                                    <small class="label pull-right bg-blue">17</small>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="/vendor/control-panel/pages/mailbox/mailbox.html">
                                <i class="fa fa-envelope"></i> <span>Mailbox</span>
                                <span class="pull-right-container">
                                    <small class="label pull-right bg-yellow">12</small>
                                    <small class="label pull-right bg-green">16</small>
                                    <small class="label pull-right bg-red">5</small>
                                </span>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Examples</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="/vendor/control-panel/pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
                                <li><a href="/vendor/control-panel/pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-share"></i> <span>Multilevel</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                                <li class="treeview">
                                    <a href="#"><i class="fa fa-circle-o"></i> Level One
                                        <span class="pull-right-container">
                                            <i class="fa fa-angle-left pull-right"></i>
                                        </span>
                                    </a>
                                    <ul class="treeview-menu">
                                        <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                                        <li class="treeview">
                                            <a href="#"><i class="fa fa-circle-o"></i> Level Two
                                                <span class="pull-right-container">
                                                    <i class="fa fa-angle-left pull-right"></i>
                                                </span>
                                            </a>
                                            <ul class="treeview-menu">
                                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                                <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
                            </ul>
                        </li>
                        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
                        <li class="header">LABELS</li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
                        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li> -->
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 2.4.13
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Home tab content -->
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <h3 class="control-sidebar-heading">Recent Activity</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                    <p>Will be 23 on April 24th</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-user bg-yellow"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                                    <p>New phone +1(800)555-1234</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                                    <p>nora@example.com</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <i class="menu-icon fa fa-file-code-o bg-green"></i>

                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                                    <p>Execution time 5 seconds</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.control-sidebar-menu -->

                    <h3 class="control-sidebar-heading">Tasks Progress</h3>
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Custom Template Design
                                    <span class="label label-danger pull-right">70%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Update Resume
                                    <span class="label label-success pull-right">95%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-success" style="width: 95%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Laravel Integration
                                    <span class="label label-warning pull-right">50%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <h4 class="control-sidebar-subheading">
                                    Back End Framework
                                    <span class="label label-primary pull-right">68%</span>
                                </h4>

                                <div class="progress progress-xxs">
                                    <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.control-sidebar-menu -->

                </div>
                <!-- /.tab-pane -->

                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <form method="post">
                        <h3 class="control-sidebar-heading">General Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Report panel usage
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Some information about this general settings option
                            </p>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Allow mail redirect
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Other sets of options are available
                            </p>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Expose author name in posts
                                <input type="checkbox" class="pull-right" checked>
                            </label>

                            <p>
                                Allow the user to show his name in blog posts
                            </p>
                        </div>
                        <!-- /.form-group -->

                        <h3 class="control-sidebar-heading">Chat Settings</h3>

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Show me as online
                                <input type="checkbox" class="pull-right" checked>
                            </label>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Turn off notifications
                                <input type="checkbox" class="pull-right">
                            </label>
                        </div>
                        <!-- /.form-group -->

                        <div class="form-group">
                            <label class="control-sidebar-subheading">
                                Delete chat history
                                <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                            </label>
                        </div>
                        <!-- /.form-group -->
                    </form>
                </div>
                <!-- /.tab-pane -->
            </div>
        </aside>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>

    </div>
    <!-- ./wrapper -->

    <!-- Bootstrap 3.3.7 -->
    <script src="/vendor/control-panel/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Select2 -->
    <script src="/vendor/control-panel/bower_components/select2/dist/js/select2.full.min.js"></script>
    <!-- InputMask -->
    <script src="/vendor/control-panel/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="/vendor/control-panel/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="/vendor/control-panel/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- date-range-picker -->
    <script src="/vendor/control-panel/bower_components/moment/min/moment.min.js"></script>
    <script src="/vendor/control-panel/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="/vendor/control-panel/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="/vendor/control-panel/bower_components/bootstrap-datepicker/dist/locales/bootstrap-datepicker.ru.min.js"></script>
    <!-- bootstrap color picker -->
    <script src="/vendor/control-panel/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <!-- bootstrap time picker -->
    <script src="/vendor/control-panel/plugins/timepicker/bootstrap-timepicker.min.js"></script>
    <!-- SlimScroll -->
    <script src="/vendor/control-panel/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- iCheck 1.0.1 -->
    <script src="/vendor/control-panel/plugins/iCheck/icheck.min.js"></script>
    <!-- FastClick -->
    <script src="/vendor/control-panel/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="/vendor/control-panel/dist/js/adminlte.min.js"></script>
    <!-- Sparkline -->
    <script src="/vendor/control-panel/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    <!-- jvectormap  -->
    <script src="/vendor/control-panel/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="/vendor/control-panel/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- ChartJS -->
    <script src="/vendor/control-panel/bower_components/chart.js/Chart.js"></script>

    <script src="/vendor/control-panel/plugins/sweetalert/lib/sweet-alert.min.js"></script>
    <script src="/vendor/control-panel/plugins/toastr/build/toastr.min.js"></script>
    <script type="text/javascript" src="/vendor/control-panel/plugins/tinymce/tinymce.min.js"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('.daterangepicker-reservation').daterangepicker()
            //Date range picker with time picker
            $('.daterangepicker-reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('.daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Date picker
            $('.datepicker').datepicker({
                language: "ru",
                autoclose: true,
                todayHighlight: true,
                todayBtn: "linked",
            })

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass: 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })

            $('.sw-alert-delete').click(function(e) {
                e.preventDefault();
                var context = this;
                swal({
                        title: "Вы уверены?",
                        text: "После удаления отмена будет невозможна!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Да, удалить!",
                        cancelButtonText: "Отмена"
                    },
                    function() {
                        if (context && context.href) {
                            window.location = context.href;
                        }
                    });
                return false;
            });
            toastr.options = {
                "debug": false,
                "newestOnTop": false,
                "positionClass": "toast-top-center",
                "closeButton": true,
                "toastClass": "animated fadeInDown"
            };

            tinymce.init({
                selector: 'textarea',
                language: 'ru',
                plugins: 'filemanager, print preview fullpage importcss  searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                imagetools_cors_hosts: ['picsum.photos'],
                menubar: 'file edit view insert format tools table tc help',
                toolbar: 'undo redo | bold italic underline strikethrough | filemanager | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview print | insertfile image media template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
                imagetools_toolbar: " editimage imageoptions",
                image_advtab: true,
                automatic_uploads: true,
                remove_script_host: false,
                convert_urls: false,
                relative_urls: false,
                @if(isset($type) && $type && isset($id) && $id)
                images_upload_handler: function(blobInfo, success, failure) {
                    formData = new FormData();
                    formData.append('file', blobInfo.blob(), blobInfo.filename());
                    formData.append('type', '{{$type}}');
                    formData.append('id', '{{$id}}');
                    $.ajax({
                        url: '/control/files/upload-material',
                        data: formData,
                        processData: false,
                        contentType: false,
                        type: 'POST',
                        success: function(data) {
                            if (data && data.url) {
                                success(data.url);
                            } else {
                                var message = "Ошибка загрузки изображения";
                                if (data && data.error) {
                                    message = data.error;
                                }
                                failure(message);
                                var editor = tinymce.activeEditor;
                                editor.selection.collapse();
                                $(editor.dom.doc).find('img[src^="blob:"]').remove();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            failure("Ошибка загрузки изображения: " + textStatus);
                            var editor = tinymce.activeEditor;
                            editor.selection.collapse();
                            $(editor.dom.doc).find('img[src^="blob:"]').remove();
                        },
                    });
                },
                @endif

                content_css: [
                    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
                    '//www.tiny.cloud/css/codepen.min.css'
                ],
                content_style: '.mce-annotation { background: #fff0b7; } .tc-active-annotation {background: #ffe168; color: black; }',
                style_formats: [{
                        title: 'Отступ'
                    },
                    {
                        title: '10',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'text-indent': '10px' }
                    },
                    {
                        title: '20',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'text-indent': '20px' }
                    },
                    {
                        title: '30',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'text-indent': '30px' }
                    },
                    {
                        title: '40',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'text-indent': '40px' }
                    },
                    {
                        title: '50',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'text-indent': '50px' }
                    },
                    {
                        title: 'Интервал между абзацами'
                    },
                    {
                        title: 'Интервал 10',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'margin': '10px 0' }
                    },
                    {
                        title: 'Интервал 20',
                        selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table',
                        styles: { 'margin': '20px 0' }
                    },
                    {
                        title: 'Формат изображения'
                    },
                    {
                        title: 'Без оптекания',
                        selector: 'img',
                        styles: {
                            'float': 'none',
                        }
                    },
                    {
                        title: 'Текст справа',
                        selector: 'img',
                        styles: {
                            'float': 'left',
                            'margin': '0 10px 0 0'
                        }
                    },
                    {
                        title: 'Текст слева',
                        selector: 'img',
                        styles: {
                            'float': 'right',
                            'margin': '10px 0 0 0'
                        }
                    },

                ],
                image_class_list: [{
                        title: 'None',
                        value: ''
                    },
                    {
                        title: 'Some class',
                        value: 'class-name'
                    }
                ],
                importcss_append: true,
                height: 400,
                // file_picker_callback: function(callback, value, meta) {
                //     /* Provide file and text for the link dialog */
                //     if (meta.filetype === 'file') {
                //         callback('https://www.google.com/logos/google.jpg', {
                //             text: 'My text'
                //         });
                //     }

                //     /* Provide image and alt text for the image dialog */
                //     if (meta.filetype === 'image') {
                //         callback('https://www.google.com/logos/google.jpg', {
                //             alt: 'My alt text'
                //         });
                //     }

                //     /* Provide alternative source and posted for the media dialog */
                //     if (meta.filetype === 'media') {
                //         callback('movie.mp4', {
                //             source2: 'alt.ogg',
                //             poster: 'https://www.google.com/logos/google.jpg'
                //         });
                //     }
                // },
                templates: [{
                        title: 'New Table',
                        description: 'creates a new table',
                        content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
                    },
                    {
                        title: 'Starting my story',
                        description: 'A cure for writers block',
                        content: 'Once upon a time...'
                    },
                    {
                        title: 'New list with dates',
                        description: 'New List with dates',
                        content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
                    }
                ],
                template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
                template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
                height: 600,
                image_caption: true,
                quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
                noneditable_noneditable_class: "mceNonEditable",
                toolbar_drawer: 'sliding',
                contextmenu: "link image imagetools table",
            });
        })
    </script>
</body>

</html>