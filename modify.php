<?php
require_once('Classes.php');
require_once('config.php');
session_start();
if(!isset($_SESSION['id']) || check_isDELETED($_GET['id'])){
    header('Location:index.php');
}

$default_img="assets/blank-pfp.png";
$uploadOk=false;
$target_dir = "uploads/";
$index=$_GET['id'];
$etudiants=isset($_COOKIE['etudiants'])?unserialize($_COOKIE['etudiants']):[];

if(isset($_POST['modifier'])){
    if(isset($_FILES["img"]) && $_FILES["img"]["error"] === UPLOAD_ERR_OK && !empty($_FILES["img"]["tmp_name"])) {
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if($check !== false){
            $uploadOk=true;
        } else {
            $uploadOk=false;
        }
    } else {
        $target_file =$default_img;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $uploadOk=true;
    }
    if($_FILES["img"]["size"] > 2000000){
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Désolé, l'image PNG doit être inférieure de 2 Mo.</h3>";
        $uploadOk=false;
    }

    if($imageFileType != "png") {
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Seuls les images de type PNG seront acceptés.</h3>";
        $uploadOk=false;
    }

    if(!$uploadOk){
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Désolé, votre fichier n'a pas été téléchargé.</h3>";
    } else {
        $newName=$target_dir . "img_" . time() . "_" . uniqid() . ".png";
        if(move_uploaded_file($_FILES["img"]["tmp_name"], $newName)){
            $target_file=$newName;
            #echo "<h3 style='color: white; padding: 1em; background-color: green; margin-top: 2em; border-radius: 5px;'>Le fichier ". htmlspecialchars( basename( $_FILES["img"]["name"])). " a été téléchargé.</h3>";
        } else {
            echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Désolé, une erreur s'est produite lors du téléchargement de votre fichier.</h3>";
        }
    }
}

if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['modifier']) && $uploadOk){
    $id=intval($index);
    $maths=$_POST['maths'];
    $info=$_POST['info'];
    $photo=$target_file;
    $conn=getConnection();
    $check_existing_image="SELECT Photo FROM Notes WHERE ID=?";
    $sql_nophoto="UPDATE Notes SET Maths=?, Informatique=? WHERE ID=?";
    $sql="UPDATE Notes SET Maths=?, Informatique=?, Photo=? WHERE ID=?";
    if($conn){
        $stmt=$conn->prepare($check_existing_image);
        $stmt->execute([$id]);
        $data=$stmt->fetch();
        if($photo !== $default_img) { 
            $stmt=$conn->prepare($sql);
            $stmt->execute([$maths,$info,$photo,$id]);
        
            if(file_exists($data['Photo']) && $data['Photo'] !== $default_img) {
                unlink($data['Photo']);
            }
        } else {
            $stmt=$conn->prepare($sql_nophoto);
            $stmt->execute([$maths,$info,$id]);
        }
        closeConnection($conn);
        header('Location:result.php');
        exit();
    } else {
        echo "<h3 style='color: white; padding: 1em; background-color: red; margin-top: 2em; border-radius: 5px;'>Oops! Un erreur est survenue. Merci du ressayer plus tard</h3>";
    }
    exit();

}

?>

<html>
    <head>
        <title>Atelier</title>
        <meta charset="utf-8" lang="fr-FR">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>

    <body>
        <img placeholder="LOGO" src="./assets/logo.png" id="logo-image"/>
        <div id="parent-box">
            <form method="POST" action="modify.php?id=<?=$index?>" enctype="multipart/form-data">
                <div style="display: none;">
                    <input type="text" name="index" value="<?php echo $index?>" required hidden>
                </div>
                <div>
                    <label for="nom">Etudiant</label>
                    <input type="text" name="nom" value="<?php echo getName($index)?>" required disabled>
                </div><div>
                    <label for="maths">Maths</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="maths" required>
                </div><div>
                    <label for="info">Informatique</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="info" required>
                </div>
                <div>
                    <label for="img">Photo</label>
                    <input type="file" name="img" id='file' accept="image/png">
                </div>
                <div class="buttons">
                    <input type="submit" value="Modifier" name="modifier" class="button">
                </div>
            </form>
            <div class="buttons">
                <a href="result.php">
                    <button name="afficher" class="button">Afficher</button>
                </a>
                <a href="disconnect.php">
                    <button name="deconnexion" class="button">Deconnexion</button>
                </a>
            </div>  
        </div>
    </body>
    
    <footer>
        <p>University</p>
    </footer>
</html>

