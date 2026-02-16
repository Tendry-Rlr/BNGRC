<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'achat</title>
</head>

<body>
    <h2>Information sur le besoin</h2>
    <p>Nom : <?= $besoin['nom_Besoin'] ?>
        Categorie : <?= $besoin['categorie_libelle'] ?>
        Prix Unitaire : <?= $besoin['prix_Unitaire'] ?>
        Quantite : <?= $besoin['quantite'] ?>
    </p>

    <form action="/insertAchat" method="post">
        <p>Entrez quantite :
            <input type="number" name="quantite" min="0">
            <input type="hidden" name="id_besoin" value="<?= $besoin['id_Besoin'] ?>">
            <input type="hidden" name="id_besoin_categorie" value="<?= $besoin['id_Besoin_Categorie'] ?>">
        </p>
        <input type="submit" value="Soumettre">
    </form>
</body>

</html>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>