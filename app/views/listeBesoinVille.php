<?php
ob_start();
$page_title = 'BNGRC - Liste des besoins par ville';
$baseUrl = $baseUrl ?? '';
$success = $_GET['success'] ?? '';
?>

<div class="row">
  <div class="col-12 mb-4">
    <div class="card card-modern">
      <div class="card-body">
        <h4 class="card-title mb-2">
          <i class="bi bi-list-check text-primary"></i> Besoins et dons de la ville
        </h4>
        <h5 class="text-primary"><?= htmlspecialchars($details[0]['nom_Ville']) ?></h5>
      </div>
    </div>
  </div>
</div>

<?php if (!empty($success)): ?>
  <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="bi bi-check-circle-fill me-2"></i>
    <div><?= htmlspecialchars($success) ?></div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>


<p class="lead">
  Liste des besoins
</p>
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
                <th><i class="bi bi-cart"></i> Achat </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listeBesoin as $l) { ?>
                <tr>
                  <td><span class="badge bg-primary"><?= htmlspecialchars($l['categorie_libelle']) ?></span></td>
                  <td><strong><?= htmlspecialchars($l['nom_Besoin']) ?></strong></td>
                  <td><?= number_format($l['prix_Unitaire'], 2) ?> Ar</td>
                  <td><span class="badge bg-info"><?= htmlspecialchars($l['quantite']) ?></span></td>
                  <?php if ($l['nom_Besoin'] != "Argent") { ?>
                    <form action="">
                      <td><a href="<?= $baseUrl ?>/achat/<?= $l['id_Besoin'] ?>" class="btn btn-success">Acheter</a></td>
                    </form>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<p class="lead mt-5">
  Liste des dons
</p>
<div class="row">
  <div class="col-12">
    <div class="card card-modern">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th><i class="bi bi-tag"></i> nom_produit</th>
                <th><i class="bi bi-box"></i> quantite_don</th>
                <th><i class="bi bi-currency-dollar"></i> date_dispatch</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($listeDon as $l) { ?>
                <tr>
                  <td><span class="badge bg-primary"><?= $l['nom_produit'] ?></span></td>
                  <td><strong><?= htmlspecialchars($l['quantite_don']) ?></strong></td>
                  <td><span class="badge bg-info"><?= htmlspecialchars($l['date_dispatch']) ?></span></td>
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