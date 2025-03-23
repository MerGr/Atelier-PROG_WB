<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['id'])) {
    header('location: index.php');
    exit;
}

$index=$_GET['id'];

if($_SERVER['REQUEST_METHOD']=='POST'){
    $etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];
    $conn=getConnection();
    if($conn){
        $sql="DELETE FROM Notes WHERE ID=?";
        $stmt=$conn->prepare($sql);
        $stmt->execute([$index]);
        closeConnection($conn);
    } else {
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Oops! Un erreur est survenue. Merci du ressayer plus tard</h3>";
    }
}

header('location: result.php');
?>

<html>
    <head>
        <title>Atelier</title>
        <meta charset="utf-8" lang="fr-FR">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <div class="popup">
            <div class="popup-content">
                <p>Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
                <form method="POST">
                    <button type="submit" name="delete" class="button">Oui</button>
                    <a href="result.php"><button type="button" class="button">Non</button></a>
                </form>
            </div>
        </div>
    </body>
 
    <footer>
        <p>University</p>
    </footer>
</html>