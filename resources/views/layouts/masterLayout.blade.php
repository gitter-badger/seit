<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
@if (trim($__env->yieldContent('html_title')))
    <title>@yield('html_title') | SeIT</title>
@else
    <title>SeIT</title>
@endif
    <meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ URL::asset('app/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="//code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- bootstrap slider -->
    <link href="{{ URL::asset('plugins/bootstrap-slider/slider.css') }}" rel="stylesheet" type="text/css" />
    <!-- jstree -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('plugins/jstree/jqtree.css') }}"/>
    <!-- bootstrap touchspin -->
    <link href="{{ URL::asset('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.css') }}" rel="stylesheet" type="text/css" />
    <!-- select2 style -->
    <link href="{{ URL::asset('plugins/select2/select2.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('plugins/select2/select2-bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="{{ URL::asset('plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <!-- offline.js Styles -->
    <link href="{{ URL::asset('plugins/offline/offline-theme-chrome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('plugins/offline/offline-language-english.css') }}" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="{{ URL::asset('app/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    </head>
    <body class="skin-black fixed">
        <div class="wrapper">
        @include('layouts.component.header')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            @include('layouts.component.sidebar')
            <!-- /.sidebar -->
        </aside>

      <!-- Right side column. Contains the navbar and content of the page -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
          @if (trim($__env->yieldContent('html_title')))
              @yield('html_title')
          @endif
          </h1>
        </section>


        <!-- Main content -->
        <section class="content"> 
            <!-- flash messages -->
            @include('layouts.component.flash')
            <!-- sub view contect -->
            @yield('page_content')
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      {{--<footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.0
        </div>
        <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
      </footer>--}}

    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="{{ URL::asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ URL::asset('app/js/bootstrap.js') }}" type="text/javascript"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('plugins/fastclick/fastclick.min.js') }}"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{ URL::asset('plugins/slimScroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <!-- DATA TABLES SCRIPT -->
    <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>        
    <!-- Bootstrap Slider -->
    <script src="{{ URL::asset('plugins/bootstrap-slider/bootstrap-slider.js') }}" type="text/javascript"></script>
    <!-- Bootstrap touchspin -->
    <script src="{{ URL::asset('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}" type="text/javascript"></script>
    <!-- select2 -->
    <script src="{{ URL::asset('plugins/select2/select2.min.js') }}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ URL::asset('app/js/app.js') }}" type="text/javascript"></script>
    <!-- offline.js -->
    <script src="{{ URL::asset('plugins/offline/offline.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      // Periodically check the top status bar for queue related information
      (function worker() {
        $.ajax({
          type: "get",
          url: "{!! URL::action('AjaxController@getQueueInformation') !!}",
          success: function(data) {
            $("span#count_queued").text(data.count_queued);
            $("span#count_done").text(data.count_done);
            $("span#count_working").text(data.count_working);
            $("span#count_error").text(data.count_error);
          },
          complete: function() {
            // Schedule the next request when the current one's complete
            setTimeout(worker, 60000); // 60 Seconds
          }
        });
      })();

      /* offline detection */
      Offline.options = {
        checks: { xhr: {url: '/favicon.ico'} },
        reconnect: {
          // How many seconds should we wait before rechecking.
          initialDelay: 3,
          // How long should we wait between retries.
          delay: 30,
        },
      };
    </script>

    <!-- view specific js -->
    @yield('javascript')
  </body>
</html>
