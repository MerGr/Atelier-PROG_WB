<?php
require_once('Classes.php');
session_start();
if(!isset($_SESSION['id'])){
    header("location:index.php");
}

function  nouvel($nom,$math,$info){
    return new Etudiants($nom,$math,$info);
}
$etudiants= isset($_COOKIE['etudiants']) ? unserialize($_COOKIE['etudiants']) : [];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nom=$_POST['nom'];
    $notM=$_POST['maths'];
    $notInfo=$_POST['info'];
    $etudiants[]=nouvel($nom,$notM,$notInfo);
    setcookie('etudiants',serialize($etudiants),time()+86400,"/");
    
}

?>
<html>
    <head>
        <title>Atelier 0</title>
        <meta charset="utf-8" lang="fr-FR">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <img placeholder="LOGO" src="./assets/logo.png" id="logo-image"/>
        <div id="parent-box">
            <form method="POST" action="student.php">
                <div>
                    <label for="stdnt-name">Etudiant</label>
                    <input type="text" name="stdnt-name" required>
                </div><div>
                    <label for="maths">Maths</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="maths" required>
                </div><div>
                    <label for="info">Informatique</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="info" required>
                </div>
                <div class="buttons">
                    <input type="submit" value="Ajouter" name="ajouter" class="button">
                    <button type="reset" class="button">Annuler</button>
                </div>
            </form>
            <div class="buttons">
                <form action="result.php" method="POST">
                    <button type="submit" name="afficher" class="button">Afficher</button>
                </form>
                <form action="disconnect.php" method="POST">
                    <button type="submit" name="deconnexion" class="button">Deconnexion</button>
                </form>
            </div>  
        </div>
    </body>
    
    <footer>
        <p>University</p>
    </footer>
</html>
