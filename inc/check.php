<?php
session_start();
$userId = isset($_SESSION['userId']) ? $_SESSION['userId'] : null;
$currentPage= explode('/', substr($_SERVER['SCRIPT_NAME'], 1));
$currentPageName = end($currentPage);
if(!empty($userId) && $currentPageName == "login.php") {
    // CHECK VALIDE userId
    // REDIRECT APP
    header('Location: index.php');
    exit();
} elseif(empty($userId) && $currentPageName != "login.php") {
    // CHECK VALIDE userId
    // REDIRECT LOGIN
    header('Location: login.php');
    exit();
}
$errors = [];
?>