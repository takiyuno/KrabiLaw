<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Chookiat Law</title>
  <link rel="icon" href="{{ asset('dist/img/LAW.png') }}" type="image/ico" />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
   <!--Button Export Datatable-->
   <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css"> 
   <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

  <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('plugins/input-mask/jquery.inputmask.js') }}"></script>
  <script src="{{ asset('plugins/ekko-lightbox/ekko-lightbox.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  
  <script src="{{ asset('js/sweetAlert.js') }}"></script>
  <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
  <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
  <script src="{{ asset('plugins/filterizr/jquery.filterizr.min.js') }}"></script>
  <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}" wfd-invisible="true"></script>
    <!--Button Export Datatable-->
    <script src="//cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

  <!-- Scrollbar -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

  <!-- {{-- frame Upload image --}} -->
  <link type="text/css" rel="stylesheet" href="{{ asset('css/magiczoomplus.css') }}"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
  <script type="text/javascript" src="{{ asset('js/magiczoomplus.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/js/fileinput.js" type="text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.7/themes/fa/theme.js" type="text/javascript"></script>
  
  <!-- {{-- Date Rang --}} -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

  <!-- Validate Form -->
  <script src="{{asset('plugins/jquery-validation/jquery.validate.min.js')}}"></script>

  <!-- {{-- Graph on Homepage --}} -->
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

  {{-- font --}}
  <script src="https://kit.fontawesome.com/7eaf125d1a.js" crossorigin="anonymous"></script>

  <!-- {{-- fonts --}} -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Prompt:wght@300&display=swap');
  </style>

  <!-- Plugin -->
  <link rel="stylesheet" href="{{ asset('css/pluginLegislations.css') }}">
  <script src="{{asset('js/pluginLegislations.js')}}"></script>
  
  <style>
    body::-webkit-scrollbar {
      display: none;
    }
    body {
      -ms-overflow-style: none;
    }
  </style>

  <style>
      #button {
      display: inline-block;
      background-color: #FF9800;
      width: 50px;
      height: 50px;
      text-align: center;
      border-radius: 4px;
      position: fixed;
      bottom: 30px;
      right: 30px;
      transition: background-color .3s, 
          opacity .5s, visibility .5s;
      opacity: 0;
      visibility: hidden;
      z-index: 1000;
      }
      #button::after {
      content: "\f077";
      font-family: FontAwesome;
      font-weight: normal;
      font-style: normal;
      font-size: 2em;
      line-height: 50px;
      color: #fff;
      }
      #button:hover {
      cursor: pointer;
      background-color: #333;
      }
      #button:active {
      background-color: #555;
      }
      #button.show {
      opacity: 1;
      visibility: visible;
      }

      /* Styles for the content section */
     
   
  </style>
  
  <script>
    $.widget.bridge('uibutton', $.ui.button);

   
  </script>

</head>

<body  class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse" style="height: auto;">
  <!-- Site wrapper -->
  <div class="wrapper">

    <!-- =============================================== -->

    @include('layouts.header')
    @include('layouts.sidebar')

    <!-- =============================================== -->

    <div class="content-wrapper">
      @yield('content')
    </div>

    <div class="control-sidebar-bg"></div>

  </div>

</body>
</html>
