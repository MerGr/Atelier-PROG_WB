<?php
if(isset($_SESSION['login']))
{
    session_start();
    session_unset();
    session_destroy();
    if(isset($_COOKIE['etudiants'])){
        append_to_db();
        unset($_COOKIE['etudiants']);
        setcookie('etudiants', '', time()-3600);
    }
    header("Location: index.php");
}
?>
