<?php
require_once('Classes.php');
require_once('config.php');
session_start();
if(!isset($_SESSION['id'])){
    header("location:index.php");
}
function import_note(){
    $conn=getConnection();
    $sql="SELECT * FROM Notes";
    $result=$conn->query($sql);
    $etudiants=[];
    if($result->rowCount()>0){
        while($row=$result->fetch()){
            $etudiants[]=new Etudiants($row['ID'],$row['Nom'],$row['Maths'],$row['Informatique']);
        }
    }
    closeConnection($conn);
    return $etudiants;
}
    $etudiants=import_note();

if($_SERVER['REQUEST_METHOD']=='POST'){
    $nom=$_POST['nom'];
    $notM=$_POST['maths'];
    $notInfo=$_POST['info'];
    $ID=count($etudiants)+1;
    $etudiants[]=new Etudiants($ID,$nom,$notM,$notInfo);
    $conn=getConnection();
    if($conn){
        $sql=$conn->prepare("INSERT INTO Notes VALUES(?,?,?,?)");
        $sql->execute([$ID,$nom,$notM,$notInfo]);
        closeConnection($conn);
        setcookie('etudiants',serialize($etudiants),time()+86400,"/");
    } else {
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Oops! Un erreur est survenue. Merci du ressayer plus tard</h3>";
    }   
}

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
            <form method="POST" action="student.php">
                <div>
                    <label for="nom">Etudiant</label>
                    <input type="text" name="nom" required>
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
                <a href="result.php">
                    <button name="afficher" class="button">Afficher</button>
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

