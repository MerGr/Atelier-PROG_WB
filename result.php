<?php
require_once('Classes.php');
session_start();
if(!isset($_SESSION['id'])){
    header("Location:index.php");
}
$etudiants= isset($_COOKIE['etudiants']) ? unserialize($_COOKIE['etudiants']) : [];


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
            <table>
                <tr id="toprow"><th>Nom complet</th><th>Moyenne</th><th>Observation</th><th colspan="2">Action</th></tr>
                <?php for($c=0;$c<count($etudiants);$c++){?>
                        <tr>
                            <td><?= htmlspecialchars($etudiants[$c]->nom) ?></td>
                            <td><?=$etudiants[$c]->calculemoyenne()?></td>
                            <?= htmlspecialchars($etudiants[$c]->remarque()) ?>
                            <td><a href="modify.php?id=<?=$c?>"><button style="background-color: #ffc107; color: white;">Modifier</button></a></td>
                            <td><a href="delete.php?id=<?=$c?>"><button style="background-color: #dc3545; color: white;">Supprimer</button></a></td>
                        </tr>
                    <?php };?>
                
            </table>
            <div class="buttons">
                <form action="student.php" method="POST">
                    <button type="submit" name="return" class="button">Retourner</button>
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