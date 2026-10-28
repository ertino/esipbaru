<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eSIP</title>

    <!-- Tabler CSS -->
    <link href="{{ asset('tabler/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('tabler/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>

    <!-- Tabler Icons -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet"/>

    <!-- Font -->
    <link href="https://rsms.me/inter/inter.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>

   <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
   
    <style>
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 6px;
            padding: 6px 10px;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 6px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 4px 10px;
            margin: 2px;
        }
        </style>

    @stack('css')
</head>

