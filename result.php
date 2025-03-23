<?php
require_once('Classes.php');
require_once('config.php');
session_start();

if (!isset($_SESSION['id'])) {
    header("Location:index.php");
    exit();
}

function import_note() {
    $conn = getConnection();
    $sql = "SELECT * FROM Notes";
    $result = $conn->query($sql);
    $etudiants = [];

    if ($result->rowCount() > 0) {
        while ($row = $result->fetch()) {
            $etudiants[] = new Etudiants($row['ID'], $row['Nom'], $row['Maths'], $row['Informatique']);
        }
    }

    closeConnection($conn);
    return $etudiants;
}

$etudiants = import_note();
setcookie('etudiants', serialize($etudiants), time() + 86400, "/");

// Store delete request in session
if (isset($_POST['delete'])) {
    $_SESSION['delete_id'] = $_POST['delete_id'];
    header("Location: result.php"); // Reload to persist data
    exit();
}

// If user confirms deletion, redirect to delete.php
if (isset($_POST['confirm_delete'])) {
    $delete_id = $_SESSION['delete_id'];
    unset($_SESSION['delete_id']); // Clear session variable
    header("Location: delete.php?id=$delete_id");
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
        <table>
            <tr id="toprow"><th>Nom complet</th><th>Moyenne</th><th>Observation</th><th colspan="3">Action</th></tr>
            <?php foreach ($etudiants as $etudiant): ?>
            <tr>
                <td><?= htmlspecialchars($etudiant->nom) ?></td>
                <td><?= $etudiant->calculemoyenne() ?></td>
                <td><?= $etudiant->remarque() ?></td>
                <td class="buttoncell"><a href="modify.php?id=<?= $etudiant->ID ?>"><button id="mod">Modifier</button></a></td>
                <td class="buttoncell">
                    <form method="POST">
                        <input type="hidden" name="delete_id" value="<?= $etudiant->ID ?>">
                        <button type="submit" name="delete">Supprimer</button>
                    </form>
                </td>
                <td class="buttoncell"><a href="print.php?id=<?= $etudiant->ID ?>"><button id="prt">Imprimer</button></a></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <div class="buttons">
            <a href="student.php"><button name="return" class="button">Ajouter</button></a>
            <a href="disconnect.php"><button name="deconnexion" class="button">Deconnexion</button></a>
        </div>
    </div>

    <?php if (isset($_SESSION['delete_id'])): ?>
        <div class="popup">
            <div class="popup-content">
                <p>Êtes-vous sûr de vouloir supprimer cet étudiant ?</p>
                <form method="POST">
                    <button type="submit" name="confirm_delete" class="button">Oui</button>
                    <a href="result.php"><button type="button" class="button">Non</button></a>
                </form>
            </div>
        </div>
    <?php endif; ?>

</body> 
<footer>
    <p>University</p>
</footer>
</html>
