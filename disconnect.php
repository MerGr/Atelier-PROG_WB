<?php
session_start();
if(isset($_SESSION['login']))
{
    session_start();
    session_destroy();
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
        unset($_COOKIE['etudiants']);
        setcookie('etudiants', '', time()-3600);
    }
    header("Location: index.php");
}
?>
