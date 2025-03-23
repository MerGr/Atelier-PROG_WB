<?php
$env = parse_ini_file('.env');
header("Cache-Control: max-age=300, must-revalidate");

function getConnection() {
    global $env;
    $host=$env["HOST"];
    $dbname=$env["DBNAME"];
    $username=$env["USERNAME"];
    $password=$env["PASSWORD"];
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
