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
      $url = 'http://192.168.43.65:4000/addProposal';
      $data = array(
          'title' => htmlentities($_POST["titre"]), 
          'description' => htmlentities($_POST["description"]),
          'closingDate' => $_POST["date_limite"],
          'publicationLevel' => $_POST["level"]
        );

      $options = array(
          'http' => array(
              'header'  => "Content-type: application/json",
              'method'  => 'POST',
              'content' => json_encode($data)
          )
      );
      $context  = stream_context_create($options);
      $result = file_get_contents($url, false, $context);

        $_SESSION["success"][] = "La proposition a été créée avec succès";
        header('Location: index.php');
        exit();

    } catch (Exception $e) {
        $_SESSION["errors"][] = "Un problème est survenu, réessayez";
        header('Location: create_prop.php');
        exit();
  }
}

// GET USERS
try {
    $request = file_get_contents('http://192.168.43.65:4000/users');
    $jsonUsers = json_decode($request);
} catch (Exception $e) {
    // echo $e->getMessage();
    print("Une erreur serveur est survenu, merci d'actualiser la page");
    die();
}

restore_error_handler();
?>

<?php include_once('inc/head.php'); ?>
<!-- CSS PERSO -->
<!-- <link href="" rel="stylesheet" type="text/css" /> -->
<?php include_once('inc/header.php'); ?>

<!-- MAIN -->
<div class="card">
    <div class="card-body">
        <h5 class="card-title">Créer une proposition</h5>

        <!-- General Form Elements -->
        <form class="needs-validation" action="#" method="POST" novalidate>

            <div class="row mb-3">
                <label for="inputText" class="col-sm-2 col-form-label"><span class="text-danger small pt-1 fw-bold">*</span>Titre</label>
                <div class="col-sm-10">
                <div class="input-group has-validation">
                    <input type="text" name="titre" class="form-control" required>
                    <div class="invalid-feedback">Le titre est obligatoire</div>
                </div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="text-danger small pt-1 fw-bold">*</span>Description</label>
                <div class="col-sm-10">
                <textarea class="form-control" name="description" style="height: 100px" required></textarea>
                <div class="invalid-feedback">La description est obligatoire</div>
                </div>
            </div>

            <div class="row mb-3">
                <label for="inputPassword" class="col-sm-2 col-form-label"><span class="text-danger small pt-1 fw-bold">*</span>Date limite</label>
                <div class="col-sm-10">
                <input type="date" name="date_limite" class="form-control" required>
                <div class="invalid-feedback">La date limite est obligatoire</div>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><span class="text-danger small pt-1 fw-bold">*</span>Niveau</label>
                <div class="col-sm-10">
                <select class="form-select" name="level" required>
                    <option value="" selected="">Choisissez une option...</option>
                    <option value="TEAM">Équipe</option>
                    <option value="PROJECT">Projet</option>
                    <option value="COMMUNITY">Communauté</option>
                </select>
                <div class="invalid-feedback">Le niveau est obligatoire</div>
                </div>
            </div>

            <!-- <div class="row mb-3">
                <label class="col-sm-2 col-form-label"><span class="text-danger small pt-1 fw-bold">*</span>Participants</label>
                <div class="col-sm-10">
                <select class="form-select" multiple="" name="owners[]" required>
                    <?php
                    // foreach ($jsonUsers as $oneUser) {
                    //     $idUser = $oneUser->userId;
                    //     $usernameUser = $oneUser->username;
                    //     $userEncoded = json_encode($oneUser);
                    //     print("<option value='$idUser'>$usernameUser</option>");
                    // }
                    ?>

                </select>
                <div class="invalid-feedback">Les participants sont obligatoires</div>
                </div>
            </div> -->

            <div class="row mb-3">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                <button type="submit" class="btn btn-success">Enregistrer</button>
                </div>
            </div>

        </form>

    </div>
    </div>

<?php include_once('inc/footer.php'); ?>
<!-- JS PERSO -->
<!-- <script src="" type="text/javascript"></script> -->
<?php include_once('inc/foot.php'); ?>