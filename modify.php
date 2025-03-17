<?php
require_once('Classes.php');
session_start();
if(!isset($_SESSION['id'])){
    header('Location:index.php');
}

$index=$_GET['id'];
$etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];


if($_SERVER['REQUEST_METHOD']=='POST'){
    $etudiants[$index]->noteM=$_POST['maths'];
    $etudiants[$index]->noteInfo=$_POST['info'];
    setcookie('etudiants',serialize($etudiants),time()+86400,'/');
    header('Location:result.php');
    exit();

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
            <form method="POST">
                <div style="display: none;">
                    <input type="text" name="index" value="<?php echo $index?>" required disabled hidden>
                </div>
                <div>
                    <label for="nom">Etudiant</label>
                    <input type="text" name="nom" value="<?php echo $etudiants[$index]->nom?>" required disabled>
                </div><div>
                    <label for="maths">Maths</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="maths" required>
                </div><div>
                    <label for="info">Informatique</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="info" required>
                </div>
                <div class="buttons">
                    <input type="submit" value="Modifier" name="modifier" class="button">
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
