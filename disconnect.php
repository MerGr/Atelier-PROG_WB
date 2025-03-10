<?php
require_once('Classes.php');
session_start();
session_unset();
session_destroy();

function enregistrer($tab){
    $file=fopen("notes.csv","w");
        if($file){
            foreach($tab as $tab){
                fputcsv($file,$tab->toArray(),";");
            } 
        }
    fclose($file);
}
if(isset($_COOKIE['etudiants'])){
    $etudiants= isset($_COOKIE['etudiants']) ? unserialize($_COOKIE['etudiants']) : [];
    enregistrer($etudiants);
}
setcookie('etudiants', '', time() - 3600, "/");
header("location:index.php");
?>