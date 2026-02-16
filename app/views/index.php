<?php
ob_start();
$page_title = 'BNGRC - Accueil';
$baseUrl = $baseUrl ?? '';
?>

<a href="<?= $baseUrl ?>/don">Faire un don</a>

<div class="list-group">
  <a href="#" class="list-group-item active">Liste des Regions</a>
  <?php foreach($listeRegion as $l){ ?>
    <a href="<?= $baseUrl ?>/ville/<?= $l['id_Region'] ?>" class="list-group-item list-group-item-action"><?= $l['nom_Region'] ?></a>
  <?php } ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
