<?php
session_start();
if (isset($_SESSION['login'])) {
    $filename = 'notes.csv';

    if (isset($_POST['modify'])) {
        $nomToModify = $_POST['modify'];
    }

    if (isset($_POST['modifier'])) {
        $newNom = $nomToModify;
        $newMath = $_POST['maths'];
        $newInfo = $_POST['info'];

        if (!empty($newNom) && !empty($newMath) && !empty($newInfo)) {
            // Read file
            $lines = file($filename, FILE_IGNORE_NEW_LINES);
            $updatedLines = [];

            foreach ($lines as $line) {
                list($nom, $math, $info) = explode(';', $line);
                if ($nom === $nomToModify) {
                    // Modify this line
                    $updatedLines[] = "$newNom;$newMath;$newInfo";
                } else {
                    $updatedLines[] = $line;
                }
            }

            // Write back to file
            file_put_contents($filename, implode("\n", $updatedLines) . "\n");

            echo "Student record updated successfully!";
        } else {
            echo "Please fill in all fields.";
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
            <form method="POST" action="modify.php">
                <div>
                    <label for="stdnt-name">Etudiant</label>
                    <input type="text" name="stdnt-name" value="<?php echo $nomToModify?>" required disabled>
                </div><div>
                    <label for="maths">Maths</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="maths" required>
                </div><div>
                    <label for="info">Informatique</label>
                    <input type="number" step="0.01" min="0" max="20.00" name="info" required>
                </div>
                <div class="buttons">
                    <input type="submit" value="Modifier" name="modifier" class="button">
                </div>
            </form>
            <div class="buttons">
                <form action="result.php" method="POST">
                    <button type="submit" name="afficher" class="button">Afficher</button>
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
