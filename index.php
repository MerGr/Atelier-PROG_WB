<?php
require_once('Classes.php'); 
session_start();
if($_SERVER['REQUEST_METHOD']=='POST')
{
    $file = fopen('credentials.csv','r');
    if($file){
        $uname=$_POST['uname'];
        $pwd=$_POST['pwd'];
        while(($key = fgetcsv($file, 100, ";")) !== false){
            if($key[0]==$uname && $key[1]==$pwd)
            {
                $_SESSION['id']=$uname;
                header('Location: student.php');
            }
        }
        
        fclose($file);

        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Le mot de passe ou l'identifiant est incorrect</h3>";
    }
    else{
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Oops! Un erreur est survenue. Merci du ressayer plus tard</h3>";
    }
}

$etudiants=[];
function import_note(){
    $file=fopen("notes.csv","r");
    $etudiants=[];
    if($file){
        while(($line=fgetcsv($file,100,";"))!==false){
            $etudiants[]=new Etudiants($line[0],$line[1],$line[2]);
        }
    }
    return $etudiants;
}
    $etudiants=import_note();
    setcookie('etudiants',serialize($etudiants),time()+86400,"/");

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