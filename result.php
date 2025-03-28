<?php
require_once('Classes.php');
require_once('config.php');
session_start();
if(!isset($_SESSION['id'])){
    header("Location:index.php");
}

$etudiants=import_note();
setcookie('etudiants',serialize($etudiants),time()+86400,"/");

?>

<html>
    <head>
        <title>Atelier</title>
        <meta charset="utf-8" lang="fr-FR">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <img placeholder="LOGO" src="./assets/logo.png" id="logo-image"/>
        <div id="parent-box">
            <table>
                <tr id="toprow"><th>Nom complet</th><th>Moyenne</th><th>Observation</th><th colspan="3">Action</th></tr>
                <?php foreach ($etudiants as $etudiant): ?>
                <tr>
                    <td><?= htmlspecialchars($etudiant->nom) ?></td>
                    <td><?= $etudiant->calculemoyenne() ?></td>
                    <td><?= $etudiant->remarque() ?></td>
                    <td class="buttoncell"><a href="modify.php?id=<?=$etudiant->ID ?>"><button id="mod">Modifier</button></a></td>
                    <td class="buttoncell"><a href="delete.php?id=<?=$etudiant->ID ?>"><button type="submit" name="delete" id="del">Supprimer</button></a></td>
                    <td class="buttoncell"><a href="print.php?id=<?=$etudiant->ID ?>"><button id="prt">Imprimer</button></a></td>
                </tr>
            <?php endforeach; ?>
                
            </table>
            <div class="buttons">
                <a href="student.php">
                    <button name="return" class="button">Ajouter</button>
                </a>
                <a href="disconnect.php">
                    <button name="deconnexion" class="button">Deconnexion</button>
                </a>
            </div>  
        </div>
    </body>
 
    <footer>
        <p>University</p>
    </footer>
</html>