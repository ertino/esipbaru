    {{--
        jQuery stays a hard requirement for the DataTables driven dashboards.
        Bootstrap 5 / AdminLTE 4 come from the Vite bundle (or the CDN fallback
        in back_core), so the legacy Bootstrap 4 bundle is deliberately not
        loaded here.
    --}}
    <script src="{{ asset('minlte/plugins/jquery/jquery.min.js') }}"></script>

    <!-- DataTables + Buttons (CSV/Excel/PDF export) -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('minlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
