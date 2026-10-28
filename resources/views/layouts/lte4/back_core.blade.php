<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="{{ asset('images/nakesico.png') }}" type="image/ico" />
  <title>APLIKASI SURAT IZIN PRAKTIK TENAGA MEDIS & KESEHATAN DIGITAL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 4 -->

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('minlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('lte4/dist/css/adminlte.min.css') }}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('minlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">



    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>

    
  <!-- stepper -->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css"/>

  <!-- fancy box-->
  <link href="{{ asset('minlte/plugins/fancybox/jquery.fancybox.min.css') }}" rel="stylesheet" type="text/css" />
  <!--calendar -->
  <link href="{{ asset('minlte/plugins/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('minlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}" rel='stylesheet' />
  <link href="{{ asset('minlte/plugins/fullcalendar/main.css') }}" rel='stylesheet' />
  <link href="{{ asset('minlte/plugins/chart.js/Chart.css') }}" rel='stylesheet' />

  <link href="{{ asset('minlte/plugins/sweetalert2/sweetalert2.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('minlte/plugins/select2/css/select2.min.css') }}" rel='stylesheet' />
  <link href="{{ asset('minlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel='stylesheet' />
  
  

  <!-- leaflet-->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

  <style>
    .color-palette {
      height: 35px;
      line-height: 35px;
      text-align: right;
      padding-right: .75rem;
    }
    
    .color-palette.disabled {
      text-align: center;
      padding-right: 0;
      display: block;
    }
    
    .color-palette-set {
      margin-bottom: 15px;
    }

    .color-palette span {
      display: none;
      font-size: 12px;
    }

    .color-palette:hover span {
      display: block;
    }

    .color-palette.disabled span {
      display: block;
      text-align: left;
      padding-left: .75rem;
    }

    .color-palette-box h4 {
      position: absolute;
      left: 1.25rem;
      margin-top: .75rem;
      color: rgba(255, 255, 255, 0.8);
      font-size: 12px;
      display: block;
      z-index: 7;
    }

    .blogade {

      flex-shrink: 0;
      margin-left: 10px;
      margin-right: 10px;
      overflow-y: auto;
      max-height: 450px;
      width: 30rem;
      
    }

    .kekanan {
      
      display: flex;
      overflow-x: auto;
     
      
      
    }

    #blockside {
      
      max-height: 600px;

    }


    .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      /*position the autocomplete items to be the same width as the container:*/
      top: 100%;
      left: 0;
      right: 0;
    }

    .autocomplete-items div {
      padding: 10px;
      cursor: pointer;
      background-color: #fff; 
      border-bottom: 1px solid #d4d4d4; 
    }

    /*when hovering an item:*/
    .autocomplete-items div:hover {
      background-color: #e9e9e9; 
    }

    /*when navigating through the items using the arrow keys:*/
    .autocomplete-active {
      background-color: DodgerBlue !important; 
      color: #ffffff; 
    }

    .hiddenopt {
      display: none;
    }

    .highlight-date {
      background-color: yellow;
      /* Add any additional styles for highlighting */
    }

    .bootstrap-datetimepicker-widget td.day.visitasi {
      /* Custom styling for enabled dates */
      background-color: yellow;
      color: #000000;
      /* Add any other desired styles */
    }

    .visitasi {
      background-color: yellow;
    }

    .highlight-today .datetimepicker-day .datetimepicker-today {
      background-color: yellow;
      /* Add any additional styles for highlighting today */
    }

    .bootstrap-datetimepicker-widget table td.day.enabled.custom-date-class {
      background-color: yellow;
      /* Add any additional styles for the specific date */
    }

    .custom-rounded {
        border-radius: 10px;
        overflow: hidden; /* To ensure the image stays within the rounded boundaries */
    }

    .circular-map-icon {
        width: 32px; /* Adjust the size as needed */
        height: 32px; /* Same as width */
        border-radius: 50%; /* Make it circular */
        background-color: red; /* Set the background color */
        /* Add other styling as needed */
    }

    .tooltip.color-change {
            animation: colorChange 3s infinite;
        }

        @keyframes colorChange {
            0% {
                background-color: #FF5733; /* Start with an initial color */
            }
            25% {
                background-color: #33FF57; /* Change to a different color at 25% */
            }
            50% {
                background-color: #5733FF; /* Change to another color at 50% */
            }
            75% {
                background-color: #FF5733; /* Change back to the first color at 75% */
            }
            100% {
                background-color: #33FF57; /* Repeat with a different color at 100% */
            }
        }


  </style>
  </head>
