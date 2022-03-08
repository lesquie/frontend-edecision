<?php include_once('inc/check.php'); ?>
<?php 
set_error_handler(
  function ($severity, $message, $file, $line) {
      throw new ErrorException($message, $severity, $severity, $file, $line);
  }
);

// TRAITEMENT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
      $url = 'http://host.docker.internal:4000/login';
      $data = array('password' => $_POST["password"], 'username' => $_POST["username"]);
      $options = array(
          'http' => array(
              'header'  => "Content-type: application/json",
              'method'  => 'POST',
              'content' => json_encode($data)
          )
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);

      $_SESSION['userId'] = json_decode($result)->userId;
      $_SESSION['username'] = json_decode($result)->username;
      header('Location: index.php');
      exit();

    } catch (Exception $e) {
      $_SESSION["errors"][] = "Identifiants incorrects";
      header('Location: login.php');
      exit();
  }
}

restore_error_handler();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MyApplication</title>
  <!-- <meta content="" name="description"> -->
  <!-- <meta content="" name="keywords"> -->

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

  <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">MyApplication</span>
                </a>
              </div>

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Connectez-vous</h5>
                    <p class="text-center small">Nous sommes heureux de vous revoir</p>
                  </div>

                  <form class="row g-3 needs-validation" action="#" method="post" novalidate>

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Nom d'utilisateur</label>
                      <div class="input-group has-validation">
                        <input type="text" name="username" class="form-control" required>
                        <div class="invalid-feedback">Entrez votre nom d'utilisateur</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Mot de passe</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Entrez votre mot de passe</div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Connexion</button>
                    </div>
                    <!-- <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an account</a></p>
                    </div> -->
                  </form>

                </div>
              </div>

              <div class="credits">
                Développé par <a href="#">CascaYol Agency</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

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
        
  </script>

</body>

</html>