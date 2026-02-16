<?php
ob_start();
$page_title = 'BNGRC - Liste des besoins par ville';
$baseUrl = $baseUrl ?? '';
?>


<table class="table table-striped">
  <tr>
    <th>Categorie</th>
    <th>Besoin</th>
    <th>Prix par unite</th>
    <th>Quantite</th>
  </tr>
  <?php 
  foreach($listeBesoin as $l){ ?>
  <tr>
    <td><?= $l['categorie_libelle'] ?></td>
    <td><?= $l['nom_Besoin'] ?></td>
    <td><?= $l['prix_Unitaire'] ?></td>
    <td><?= $l['quantite'] ?></td>
  </tr>
  <?php }
  ?>
</table>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
