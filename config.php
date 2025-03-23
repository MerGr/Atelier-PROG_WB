<?php

function getConnection() {
    $host='localhost';
    $dbname='GesNotes';
    $username='root';
    $password='';
    try{
        $conn=new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Error". $e->getMessage());
    }
}

function closeConnection($conn){
    $conn=null;
}
?>