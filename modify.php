<?php
require_once('Classes.php');
require_once('config.php');
session_start();
if(!isset($_SESSION['id'])){
    header('Location:index.php');
}

$index=$_GET['id'];
$etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];


if($_SERVER['REQUEST_METHOD']=='POST'){
    $id=intval($index)+1;
    $maths=$_POST['maths'];
    $info=$_POST['info'];
    $conn=getConnection();
    $sql="UPDATE Notes SET Maths=?, Informatique=? WHERE ID=?";
    if($conn){
        $stmt=$conn->prepare($sql);
        $stmt->execute([$maths,$info, $id]);
        closeConnection($conn);
        header('Location:result.php');
        exit();
    } else {
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Oops! Un erreur est survenue. Merci du ressayer plus tard</h3>";
    }
    exit();

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
            <form method="POST" action="modify.php?id=<?=$index?>"">
                <div style="display: none;">
                    <input type="text" name="index" value="<?php echo $index?>" required hidden>
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

