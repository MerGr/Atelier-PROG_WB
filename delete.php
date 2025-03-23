<?php
require_once('config.php');
session_start();

if (!isset($_SESSION['id'])) {
    header('location: index.php');
    exit;
}

if(isset($_GET['id'])){
    $index=$_GET['id'];
    $etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];
    $conn=getConnection();
    if($conn){
        $sql="DELETE FROM Notes WHERE ID=?";
        $stmt=$conn->prepare($sql);
        $stmt->execute([$index+1]);
        closeConnection($conn);
    } else {
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Oops! Un erreur est survenue. Merci du ressayer plus tard</h3>";
    }
}

header('location: result.php');
?>
