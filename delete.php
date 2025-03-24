<?php
require_once('config.php');
session_start();

if(!isset($_SESSION['id']) || check_isDELETED($_GET['id'])){
    header('Location:index.php');
}

$index=$_GET['id'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];
    $conn=getConnection();
    if($conn){
        $sql="UPDATE Notes SET isDELETED=1 WHERE ID=?";
        $stmt=$conn->prepare($sql);
        $stmt->execute([$index]);
        closeConnection($conn);
        header('location: result.php');
        exit();
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
            <p>Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
            <form method="POST">
                <div class="buttons">
                    <button type="submit" name="delete" class="button">Oui</button>
                    <a href="result.php"><button type="button" class="button">Non</button></a>
                </div>
            </form>
        </div>
    </body>
 
    <footer>
        <p>University</p>
    </footer>
</html>