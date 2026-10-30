@php
    /*
     |--------------------------------------------------------------------------
     | Scripts (AdminLTE 4)
     |--------------------------------------------------------------------------
     |
     | Load order matters:
     |   jQuery -> Bootstrap 5 -> AdminLTE 4 -> bootstrap4-bridge -> plugins
     |
     | The bridge restores the jQuery plugin calls ($.fn.modal / $.fn.tooltip)
     | that the shared footer and the migrated views still use, so it has to be
     | loaded right after bootstrap.bundle.
     |
     */
    $local = function (string $path) {
        return file_exists(public_path($path)) ? asset($path) : null;
    };
@endphp
    <!-- jQuery -->
    <script src="{{ $local('vendor/jquery/jquery.min.js') ?? 'https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js' }}"></script>

    <!-- Bootstrap 5 bundle (AdminLTE 4 widget API lives on window.bootstrap) -->
    <script src="{{ $local('vendor/bootstrap5/js/bootstrap.bundle.min.js') ?? 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js' }}"></script>

    <!-- AdminLTE 4 -->
    <script src="{{ $local('vendor/adminlte4/js/adminlte.min.js') ?? 'https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/js/adminlte.min.js' }}"></script>

    <!-- Bootstrap 4 -> 5 bridge for the legacy jQuery calls -->
    <script src="{{ asset('js/bootstrap4-bridge.js') }}"></script>

    <!-- QR scanner -->
    <script src="{{ $local('js/html5-qrcode.min.js') ?? 'https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js' }}"></script>

    <!-- Dates -->
    <script src="{{ $local('vendor/moment/moment.min.js') ?? 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js' }}"></script>
    <script src="{{ $local('vendor/daterangepicker/daterangepicker.js') ?? 'https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.js' }}"></script>
    <script src="{{ $local('vendor/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') ?? 'https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/js/tempusdominus-bootstrap-4.min.js' }}"></script>

    <!-- Charts -->
    <script src="{{ $local('vendor/chart.js/Chart.min.js') ?? 'https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js' }}"></script>

    <!-- Alerts -->
    <script src="{{ $local('vendor/sweetalert2/sweetalert2.min.js') ?? 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js' }}"></script>
    <script src="{{ $local('vendor/toastr/toastr.min.js') ?? 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js' }}"></script>

    <!-- Selects and galleries -->
    <script src="{{ $local('vendor/select2/select2.full.min.js') ?? 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js' }}"></script>
    <script src="{{ $local('vendor/fancybox/jquery.fancybox.min.js') ?? 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js' }}"></script>
    <script src="{{ $local('vendor/overlayScrollbars/jquery.overlayScrollbars.min.js') ?? 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js' }}"></script>

    <!-- DataTables + Buttons (CSV/Excel/PDF export) -->
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <!-- Stepper -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>

    <!-- Leaflet (map pages): vendored copy first, CDN fallback -->
    @if ($local('vendor/leaflet/leaflet.js'))
        <script src="{{ $local('vendor/leaflet/leaflet.js') }}"></script>
    @else
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha512-BwHfrr4c9kmRkLw6iXFdzcdWV/PGkVgiIyIWLLlTSXzWQzxuSg4DiQUCpauz/EWjgk5TYQqX/kvn9pG1NpYfqg=="
                crossorigin=""></script>
    @endif
