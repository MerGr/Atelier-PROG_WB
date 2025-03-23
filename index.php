<?php
require_once('Classes.php');
require_once('config.php'); 
session_start();
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $user = $_POST['uname'];
    $pwd = $_POST['pwd'];
    $conn=getConnection();
    if($conn){
        $sql= 'SELECT Password FROM Credentials WHERE Login=$user';
        if(md5($pwd)==$sql){
            $_SESSION['id']=$user;
            header('Location: student.php');
        } else {
            echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Le mot de passe ou l'identifiant est incorrect</h3>";
        }
        closeConnection($conn);
    }
    else{
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
            <form method="POST" action="index.php">
                <div>
                    <label for="uname">Identifiant</label>
                    <input type="text" id="uname" name="uname" required>
                </div><div>
                    <label for="pwd">Mot de Passe</label>
                    <input type="password" id="pwd" name="pwd" required>
                </div>
                <input type="submit" value="Valider" class="button">
            </form>
        </div>
    </body>
    
    <footer>
        <p>University</p>
    </footer>
</html>