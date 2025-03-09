<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

if(isset($_GET['id'])){
    $index=$_GET['id'];
    $etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];
    if(isset($etudiants[$index])){
        array_splice($etudiants,$index,1);
        setcookie('etudiants',serialize($etudiants),time()+86400,'/');
    }
}

header('location: result.php');
?>
