<?php
require_once "fonction.php";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Loto</title>
</head>
<body> <?php if (!isset($_FILES["resultat"])) { ?>
    <h1>Mettre à jour les données</h1>
    <hr>
    <form action="#" method="post" enctype="multipart/form-data">
        <article>
            <label for="resultat">Insérer la liste des résultats du loto </label>
            <input type="file" name="resultat" id="resultat">
        </article>
        <article>
            <label for="annee">A partir de quelle année faut-il traiter : </label>
            <input type="number" name="annee" id="annee">
        </article>
        <input type="submit" value="Traiter les données" id="envoyer">
        <a href="index.php">Retourner à l'accueil</a>
    </form> 
    <?php } else {
        $cheminInput = $_FILES["resultat"]["tmp_name"];
        $cheminOutput = "data.csv";
        $annee = $_POST["annee"]?? null;

        if ($_FILES["resultat"]["error"] === UPLOAD_ERR_OK) {
            // Lire le contenu du fichier
            selectionDonnees($cheminInput, $cheminOutput, $annee);
        } else {
            echo "Erreur lors du téléchargement du fichier.";
        } ?>
        <a href="index.php">Retourner à l'accueil</a>
    <?php } ?>
</body>
</html>