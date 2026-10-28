  <!--   Core JS Files   -->
  <script src="{{ asset('templet/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('templet/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('templet/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('templet/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('templet/js/plugins/chartjs.min.js') }}"></script>
  <script src="{{ asset('dashbor/vendors/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('js/fullcalendar5//lib/main.js') }}"></script>
  
  

  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('templet/js/material-dashboard.min.js?v=3.0.0 ') }}"></script>
</body>