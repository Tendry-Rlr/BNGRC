<?php
ob_start();
$page_title = 'BNGRC - Liste des besoins par ville';
$baseUrl = $baseUrl ?? '';
?>

<div class="row">
  <div class="col-12 mb-4">
    <div class="card card-modern">
      <div class="card-body">
        <h4 class="card-title mb-2">
          <i class="bi bi-list-check text-primary"></i> Besoins de la ville
        </h4>
        <h5 class="text-primary"><?= htmlspecialchars($details[0]['nom_Ville']) ?></h5>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card card-modern">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th><i class="bi bi-tag"></i> Catégorie</th>
                <th><i class="bi bi-box"></i> Besoin</th>
                <th><i class="bi bi-currency-dollar"></i> Prix unitaire</th>
                <th><i class="bi bi-hash"></i> Quantité</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($listeBesoin as $l){ ?>
              <tr>
                <td><span class="badge bg-primary"><?= htmlspecialchars($l['categorie_libelle']) ?></span></td>
                <td><strong><?= htmlspecialchars($l['nom_Besoin']) ?></strong></td>
                <td><?= number_format($l['prix_Unitaire'], 2) ?> Ar</td>
                <td><span class="badge bg-info"><?= htmlspecialchars($l['quantite']) ?></span></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
