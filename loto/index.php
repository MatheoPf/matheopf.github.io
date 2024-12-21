<?php require_once "fonction.php";  $cheminOutput = "data.csv";?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Loto</title>
</head>
<body>
    <h1>Résultat de l'Euro Million depuis <?php echo htmlentities(extraireAnnee($cheminOutput)) ?></h1>
    <hr>
    <section>
        <article>
            <h3>Les 5 boules les + sorties</h3>
            <ul> <?php foreach (traiterDonnees5boules($cheminOutput) as $nb => $freq) { ?>
                <li><?php echo htmlentities($nb); ?></li>
            <?php } ?></ul>
        </article>
        <article>
            <h3>Les 2 boules chance les + sorties</h3>
            <ul> <?php foreach (traiterDonnees2boules($cheminOutput) as $nb => $freq) { ?>
                <li><?php echo htmlentities($nb); ?></li>
            <?php } ?></ul> 
        </article>
    </section>
    <a href="maj.php">Modifier la base de données</a>
</body>
</html>