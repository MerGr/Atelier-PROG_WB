<?php
require_once('Classes.php');
require_once('config.php');
session_start();
if(!isset($_SESSION['id'])){
    header("Location:index.php");
}
function import_note(){
    $conn=getConnection();
    $sql="SELECT * FROM Notes";
    $result=$conn->query($sql);
    $etudiants=[];
    if($result->rowCount()>0){
        while($row=$result->fetch()){
            $etudiants[]=new Etudiants($row['Nom'],$row['Maths'],$row['Informatique']);
        }
    }
    closeConnection($conn);
    return $etudiants;
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
                <?php for($c=0;$c<count($etudiants);$c++){?>
                        <tr>
                            <td><?= htmlspecialchars($etudiants[$c]->nom) ?></td>
                            <td><?=$etudiants[$c]->calculemoyenne()?></td>
                            <td><?=$etudiants[$c]->remarque()?></td>
                            <td class="buttoncell"><a href="modify.php?id=<?=$c?>"><button id="mod">Modifier</button></a></td>
                            <td class="buttoncell"><a href="delete.php?id=<?=$c?>"><button id="del">Supprimer</button></a></td>
                            <td class="buttoncell"><a href="print.php?id=<?=$c?>"><button id="prt">Imprimer</button></a></td>
                        </tr>
                    <?php };?>
                
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