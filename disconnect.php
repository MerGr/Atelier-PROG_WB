<?php
require_once('Classes.php');
session_start();
session_unset();
session_destroy();
setcookie('etudiants', '', time() - 3600*24, "/");
header("location:index.php");
?>