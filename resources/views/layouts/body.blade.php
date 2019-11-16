<body class="hold-transition skin-blue sidebar-mini">
<!-- toastr js-->
<script src="{{asset("plugins/toastr/jquery.min.js")}}"></script>
<script src="{{asset("plugins/toastr/toastr.min.js")}}"></script>
{!! Toastr::message() !!}

<!-- datatables js-->
<script src="{{asset("plugins/dataTables/jquery.dataTables.min.js")}}"></script>


    <div class="wrapper">
        @include('layouts.nav')

        @include('layouts.menu')
        <div class="content-wrapper">
             <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                @yield('titulo')
                </h1>
            </section>
            <section class="content">
                @yield('contenido')
            </section>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
              <b>Version</b> 2.4.18
            </div>
            <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
            reserved.
        </footer>


    </div>
    @yield('js')
<!-- jQuery 3 -->
<script src="{{asset("bootstrapTemplates/bower_components/jquery/dist/jquery.min.js")}}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset("bootstrapTemplates/bower_components/bootstrap/dist/js/bootstrap.min.js")}}"></script>
<!-- FastClick -->
<script src="{{asset("bootstrapTemplates/bower_components/fastclick/lib/fastclick.js")}}"></script>
<!-- AdminLTE App -->
<script src="{{asset("bootstrapTemplates/dist/js/adminlte.min.js")}}"></script>
<!-- Sparkline -->
<script src="{{asset("bootstrapTemplates/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js")}}"></script>
<!-- jvectormap  -->
<script src="{{asset("bootstrapTemplates/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js")}}"></script>
<script src="{{asset("bootstrapTemplates/plugins/jvectormap/jquery-jvectormap-world-mill-en.js")}}"></script>
<!-- SlimScroll -->
<script src="{{asset("bootstrapTemplates/bower_components/jquery-slimscroll/jquery.slimscroll.min.js")}}"></script>
<!-- ChartJS -->
<script src="{{asset("bootstrapTemplates/bower_components/chart.js/Chart.js")}}"></script>
<!-- CK editor -->
<script src="{{asset("bootstrapTemplates/bower_components/ckeditor/ckeditor.js")}}"></script>
<!-- Toggle booton -->
<script src="{{asset("plugins/toggleButton/bootstrap-toggle.min.js")}}"></script>
</body>
