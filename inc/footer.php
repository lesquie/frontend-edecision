  </main>

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>MyApplication</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      Développé par <a href="#">CascaYol Agency</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- JS PERSO -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <!-- Error messages -->
  <script>
  toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "30000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

  <?php 
  if(isset($_SESSION['errors'])){
    foreach($_SESSION['errors'] as $oneError) { 
  ?>
      toastr.error(`<?php print($oneError); ?>`, "Information");
  <?php 
    }
  }
  ?>

  <?php 
  if(isset($_SESSION['success'])){
    foreach($_SESSION['success'] as $onesuccess) { 
  ?>
      toastr.success(`<?php print($onesuccess); ?>`, "Information");
  <?php 
    }
  }
  ?>
  </script>

  <?php
  // UNSET MESSAGES
  unset($_SESSION["errors"]);
  unset($_SESSION["success"]);
  ?>