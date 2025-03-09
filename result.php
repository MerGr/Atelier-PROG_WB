<?php 
    session_start();
    include 'CSS/style.css';
    if(isset($_SESSION['login'])){
        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['afficher'])){
            $etudiants=[];
            if(isset($_COOKIE['etudiants'])){
                $etudiants=unserialize($_COOKIE['etudiants']);
                $file = fopen('notes.csv','r');
                if($file){
                    while(($line = fgetcsv($file, 100, ';')) !== false){
                        $nom_etud_list[] = ["nom"=>$line[0],"math"=>$line[1],"info"=>$line[2]];
                    }
                    foreach($nom_etud_list as $csv_etudiant){
                        $etudiants[] = $csv_etudiant;
                    }
                    fclose($file);
                }
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
            <table>
                <tr id="toprow"><th>Nom complet</th><th>Moyenne</th><th>Observation</th><th colspan="2">Action</th></tr>
                <?php
                if($etudiants!=[]){
                    for($index=0;$index<count($etudiants);$index++){ {
                        $moy=($etudiant[$index]->info+$etudiant[$index]->math)/2;
                        $observation= $moy>=10 ? "<td id='V'>Votre admission a été retenue</td>" : "<td id='NV'>Votre admission n'a été retenue</td>" ;
                        echo "<tr>
                                <td>{$etudiant[$index]->nom}</td>
                                <td>$moy</td>
                                $observation
                                <td><button type='submit' name='delete' value='{$index}' class='button' onClick='return confirm('Etes vous sure ?')'>S</button></td>
                                <td>
                                    <form action='modify.php' method='POST'>
                                        <button type='submit' name='modify' value='{$index}' class='button'>M</button>
                                    </form>
                                </td>
                            </tr>";
                            }
                        }
                    }
                ?>
                
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

<?php
    }
    else{
        header("Location: index.php");
    }
?>