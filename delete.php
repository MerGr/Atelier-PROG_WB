<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('location: index.php');
    exit;
}

$csvFile = 'notes.csv';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    $nomToDelete = $_POST['delete'];

    $tempFile = 'temp.csv';
    $file = fopen($csvFile, 'r');
    $temp = fopen($tempFile, 'w');

    if ($file && $temp) {
        while (($line = fgetcsv($file, 1000, ';')) !== false) {
            if ($line[0] !== $nomToDelete) {
                fputcsv($temp, $line, ';');
            }
        }
        fclose($file);
        fclose($temp);

        
        if (!rename($tempFile, $csvFile)) {
            die("Error updating the file!");
        }
    } else {
        die("File error!");
    }

    
    if (isset($_COOKIE['etudiants'])) {
        $etudiants = unserialize($_COOKIE['etudiants']);
        foreach ($etudiants as $key => $etudiant) {
            if ($etudiant['nom'] === $nomToDelete) {
                unset($etudiants[$key]);
                break;
            }
        }
        setcookie('etudiants', serialize($etudiants), time() + (3600 * 24), '/');
    }
}

header('location: result.php');
?>
