<?php
ob_start();
$page_title = 'BNGRC - Liste des villes';
$baseUrl = $baseUrl ?? '';
?>

<div class="list-group">
  <a href="#" class="list-group-item active">Liste des Villes</a>
  <?php foreach($listeVille as $l){ ?>
    <a href="<?= $baseUrl ?>/besoinville/<?= $l['id_Ville'] ?>" class="list-group-item list-group-item-action"><?= $l['nom_Ville'] ?></a>
  <?php } ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
