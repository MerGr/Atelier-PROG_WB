<?php
session_start();
if(isset($_SESSION['login'])){
    $etudiants=[];
    if(isset($_COOKIE['etudiants'])){
        $etudiants=unserialize($_COOKIE['etudiants']);
        $file = fopen('notes.csv','a');
        if($file){
            while(($line = fgetcsv($file, 100, ';')) !== false){
                $nom_etud_list[] = $line[0];
            }
            foreach($etudiants as $etudiant){
                $new = true;
                foreach($nom_etud_list as $check_existing){
                    if($etudiant['nom'] == $check_existing){
                        $new = false;
                        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>L'etudiant ".$etudiant['nom']." existe deja</h3>";
                        break;
                    }
                }
                if($new) fputcsv($file, $etudiant, ';');
            }
            fclose($file);
        }
        setcookie('etudiants',serialize($etudiants), time() +(3600*24),'/');
    }
    if(isset($_POST['ajouter'])){ 
        $nom=$_POST['stdnt-name'];
        $math=$_POST['maths'];
        $info=$_POST['info'];
        if(!empty($nom) && !empty($math) && !empty($info)){
            $etudiants[]=["nom"=>$nom,"math"=>$math,"info"=>$info];
            setcookie("etudiants",serialize($etudiants),time()
                +(3600*24),'/');
        }
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
            <form method="POST" action="student.php">
                <div>
                    <label for="stdnt-name">Etudiant</label>
                    <input type="text" name="stdnt-name" required>
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
<?php
}
else{
    header("Location: index.php");
}
?>
