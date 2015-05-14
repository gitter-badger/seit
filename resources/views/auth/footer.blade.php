    <!-- jQuery 2.1.3 -->
    <script src="{{ URL::asset('plugins/jQuery/jQuery-2.1.3.min.js') }}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ URL::asset('app/js/bootstrap.js') }}" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="{{ URL::asset('plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
