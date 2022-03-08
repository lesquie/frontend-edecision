<?php include_once('inc/check.php'); ?>
<?php
set_error_handler(
    function ($severity, $message, $file, $line) {
        throw new ErrorException($message, $severity, $severity, $file, $line);
    }
);

// VOTE ACTION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // VOTE YES
    if( isset($_POST["voteYes"]) ){
        try {
            $proposalId = $_POST["voteYes"];
            $request = file_get_contents("http://host.docker.internal:4000/proposal/$proposalId/$userId/yes");
            $_SESSION["success"][] = "La vote a été soumis avec succès";
            header('Location: index.php');
            exit();
        } catch (Exception $e) {
            $_SESSION["errors"][] = "Un problème est survenu, réessayez";
            header('Location: index.php');
            exit();
        }
    }
    // UNVOTE
    if( isset($_POST["unvote"]) ){
        try {
            $proposalId = $_POST["unvote"];
            $request = file_get_contents("http://host.docker.internal:4000/proposal/$proposalId/$userId/undetermined");
            $_SESSION["success"][] = "La vote a été soumis avec succès";
            header('Location: index.php');
            exit();
        } catch (Exception $e) {
            $_SESSION["errors"][] = "Un problème est survenu, réessayez";
            header('Location: index.php');
            exit();
        }
    }
    // VOTE NO
    if( isset($_POST["voteNo"]) ){
        try {
            $proposalId = $_POST["voteNo"];
            $request = file_get_contents("http://host.docker.internal:4000/proposal/$proposalId/$userId/no");
            $_SESSION["success"][] = "La vote a été soumis avec succès";
            header('Location: index.php');
            exit();
        } catch (Exception $e) {
            $_SESSION["errors"][] = "Un problème est survenu, réessayez";
            header('Location: index.php');
            exit();
        }
    }
}

// GET PROPOSALS
try {
    $request = file_get_contents('http://host.docker.internal:4000/proposals');
    $jsonProposals = json_decode($request);
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
<div class="pagetitle">
    <h1>Propositions</h1>
    <nav>
    <!-- <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Accueil</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
    </ol> -->
    </nav>
</div>

<section class="section dashboard">
    <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-12">
            <div class="row">

                <!-- Recent Sales -->
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">

                        <div class="filter">
                            <a href="create_prop.php" class="btn btn-success btn-sm" style="margin-right:2em;">Créer une proposition</a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Liste des propositions</h5>

                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Titre</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Niveau</th>
                                    <th scope="col">Vote</th>
                                    <th scope="col">Participants</th>
                                    <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    <?php 
                                    foreach( $jsonProposals as $value ){
                                        // Proposal
                                        $proposal = $value->proposal;
                                        // TotalVote count
                                        if(intval($value->totalVotes) > 0) {
                                            $classvote = "success";
                                        } elseif (intval($value->totalVotes) == 0) {
                                            $classvote = "warning";
                                        } else {
                                            $classvote = "danger";
                                        }
                                        // alreadyVote ?
                                        $alreadyVote = null;
                                        foreach($value->votes as $oneVote) {
                                            if(empty($alreadyVote)){
                                                if($oneVote->user->userId == $userId){
                                                    if($oneVote->voteType != "UNDETERMINED"){
                                                        $alreadyVote = $oneVote->voteType;
                                                    }
                                                }
                                            }
                                        }
                                        ?>

                                        <tr>
                                            <th scope="row"><?php print($proposal->proposalId) ?></th>
                                            <td class=""><?php print($proposal->title) ?></td>
                                            <td class="" style="width: 100%;"><?php print($proposal->description) ?></td>
                                            <td class=""><?php print($proposal->publicationLevel) ?></td>
                                            <td>
                                                <span class="badge bg-<?php print($classvote); ?>">
                                                    <?php print($value->totalVotes) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <ul>
                                                    <?php
                                                    foreach ($proposal->owners as $oneUser) {
                                                        print("<li>");
                                                        print($oneUser->username);
                                                        print("</li>");
                                                    }
                                                    ?>
                                                </ul>
                                            </td>
                                            <td>
                                                <form class="d-flex" action="#" method="post">
                                                    <button type="submit" name="voteYes" value="<?php print($proposal->proposalId); ?>" class="btn btn-sm btn-success" <?php if(!empty($alreadyVote) && $alreadyVote == "YES") { print('disabled'); } ?>><i class="bi bi-emoji-smile"></i></button>
                                                    <button type="submit" name="unvote" value="<?php print($proposal->proposalId); ?>" class="btn btn-sm btn-warning" <?php if(empty($alreadyVote)) { print('disabled'); } ?> style="margin-left:1em;"><i class="bi bi-emoji-neutral"></i></button>
                                                    <button type="submit" name="voteNo" value="<?php print($proposal->proposalId); ?>" class="btn btn-sm btn-danger" <?php if(!empty($alreadyVote) && $alreadyVote == "NO") { print('disabled'); } ?> style="margin-left:1em;"><i class="bi bi-emoji-frown"></i></button>
                                                </form>
                                            </td>
                                        </tr>

                                    <?php } ?>
                                    
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<?php include_once('inc/footer.php'); ?>
<!-- JS PERSO -->
<!-- <script src="" type="text/javascript"></script> -->
<?php include_once('inc/foot.php'); ?>