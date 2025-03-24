<?php
require_once('Classes.php');
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

function import_note(){
    $conn=getConnection();
    $sql="SELECT * FROM Notes";
    $result=$conn->query($sql);
    $etudiants=[];
    if($result->rowCount()>0){
        while(($row = $result->fetch()) !== false && $row['isDELETED'] == false){
            $etudiants[]=new Etudiants($row['ID'],$row['Nom'],$row['Maths'],$row['Informatique'], $row['Photo']);
        }
    }
    closeConnection($conn);
    return $etudiants;
}

function check_isDELETED($index){
    $conn=getConnection();
    $sql="SELECT isDELETED FROM Notes WHERE ID=?";
    $stmt=$conn->prepare($sql);
    $stmt->execute([$index]);
    $data=$stmt->fetch();
    closeConnection($conn);
    return $data['isDELETED'];
}
?>