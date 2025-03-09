<?php

function append_to_db(){
    $etudiants=unserialize($_COOKIE['etudiants']);
    $file = fopen('notes.csv','a');
    if($file){
        while(($line = fgetcsv($file, 100, ';')) !== false){
            $nom_etud_list[] = $line[0];
        }
        foreach($etudiants as $etudiant){
            foreach($nom_etud_list as $check_existing){
                if($etudiant['nom'] == $check_existing){
                    continue;
                }
            }
            fputcsv($file, $etudiant, ';');
        }
        fclose($file);
    }
}
?>