<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ajouter un besoin</h1>

    <form action="<?= $baseUrl ?>/insertBesoin" method="post">
        <p> Ville
            <select name="id_ville">
                <?php foreach ($villes as $v) { ?>
                    <option value="<?= $v['id_Ville'] ?>"><?= $v['nom_Ville'] ?></option>
                <?php } ?>
            </select>

            Categorie du besoin
            <select name="id_besoin_categorie">
                <?php foreach ($besoinCategories as $c) { ?>
                    <option value="<?= $c['id_Besoin_Categorie'] ?>"><?= $c['libelle'] ?></option>
                <?php } ?>
            </select>

            Nom <input type="text" name="nomBesoin">
            Quantite <input type="number" name="quantite" min="0">

            <input type="submit" value="Inserer">
        </p>
    </form>
</body>

</html>