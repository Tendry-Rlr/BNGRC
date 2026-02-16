<?php
ob_start();
$page_title = 'BNGRC - Formulaire de don';
$baseUrl = $baseUrl ?? '';
?>

<div class="row justify-content-center mb-4">
  <div class="col-lg-10 col-xl-8">
    <div class="card card-modern">
      <div class="card-body">
        <h4 class="card-title mb-3">
          <i class="bi bi-gift-fill text-primary"></i> Faire un don
        </h4>
        <p class="text-muted">Sélectionnez le produit et la quantité que vous souhaitez donner</p>

        <?php
          // build categories list: prefer $listeCategorie if provided, otherwise extract from $listeBesoin
          $categories = [];
          if (!empty($listeCategorie)) {
            foreach ($listeCategorie as $c) {
              $cid = $c['id_Besoin_Categorie'] ?? $c['id'] ?? null;
              $cl = $c['libelle'] ?? $c['categorie_libelle'] ?? $c['nom'] ?? '';
              if ($cid !== null) $categories[$cid] = $cl;
            }
          } else {
            foreach (($listeBesoin ?? []) as $b) {
              $cid = $b['id_Besoin_Categorie'] ?? $b['id_BesoinCategorie'] ?? null;
              $cl = $b['categorie_libelle'] ?? $b['libelle'] ?? null;
              if ($cid !== null && $cl !== null) $categories[$cid] = $cl;
            }
          }
        ?>

        <form method="post" action="<?= $baseUrl ?>/donner">
          <div class="row g-3 align-items-end">
            <div class="col-md-5">
              <label for="dons-select" class="form-label fw-semibold">
                <i class="bi bi-box-seam"></i> Produit
              </label>
              <select class="form-select form-select-lg" name="dons" id="dons-select" required>
                <option value="">Choisir un produit...</option>
                <?php foreach ($listeBesoin as $besoin): ?>
                  <option value="<?= $besoin['id_Besoin_Fille'] ?>"><?= htmlspecialchars($besoin['nom_Besoin']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-3">
              <label for="quantite" class="form-label fw-semibold">
                <i class="bi bi-hash"></i> Quantité
              </label>
              <input id="quantite" name="quantite" type="number" min="1" value="1" class="form-control form-control-lg" required>
            </div>

            <div class="col-md-4">
              <button class="btn btn-primary btn-lg w-100" type="submit">
                <i class="bi bi-check-circle"></i> Valider le don
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card card-modern">
      <div class="card-body">
        <h5 class="card-title mb-3">
          <i class="bi bi-list-ul text-primary"></i> Liste des dons effectués
        </h5>

        <?php if (empty($listeDon ?? [])): ?>
          <div class="alert alert-info d-flex align-items-center" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            <div>Aucun don n'a encore été effectué.</div>
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table id="don-table" class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th><i class="bi bi-building"></i> Villes</th>
                  <th><i class="bi bi-map"></i> Régions</th>
                  <th><i class="bi bi-box"></i> Nom du produit</th>
                  <th><i class="bi bi-hash"></i> Quantité</th>
                  <th><i class="bi bi-calendar-event"></i> Date du don</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($listeDon as $don){
                    $ville = $don['nom_Ville'] ?? $don['nomVille'] ?? $don['ville'] ?? '-';
                    $region = $don['nom_Region'] ?? $don['nomRegion'] ?? $don['region'] ?? '-';
                    $produit = $don['nom_produit'] ?? $don['nom_Besoin'] ?? $don['nom'] ?? $don['nom_Don'] ?? '-';
                    $quantite = $don['quantite_don'] ?? $don['quantite'] ?? '-';
                    $date = $don['date_dispatch'] ?? $don['date_Dispatch'] ?? $don['created_at'] ?? $don['date'] ?? '-';
                    $catId = $don['id_Besoin_Categorie'] ?? $don['id_BesoinCategorie'] ?? $don['categorie_id'] ?? $don['id_categorie'] ?? '';
                ?>
                <tr data-cat="<?= htmlspecialchars($catId) ?>">
                  <td><?= htmlspecialchars($ville) ?></td>
                  <td><?= htmlspecialchars($region) ?></td>
                  <td><strong><?= htmlspecialchars($produit) ?></strong></td>
                  <td><span class="badge bg-success"><?= htmlspecialchars($quantite) ?></span></td>
                  <td><?= htmlspecialchars($date) ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div id="noResults" class="alert alert-warning mt-3 d-none">Aucun don pour cette catégorie.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script nonce="<?= Flight::get('csp_nonce') ?>">
  (function(){
    var catSelect = document.getElementById('categorie-select');
    var table = document.getElementById('don-table');
    var noResults = document.getElementById('noResults');
    if(!catSelect || !table) return;
    var rows = Array.from(table.querySelectorAll('tbody tr'));

    function filterRows(){
      var val = catSelect.value;
      var visible = 0;
      rows.forEach(function(r){
        var rc = r.getAttribute('data-cat') || '';
        if(val === '' || String(rc) === String(val)){
          r.style.display = '';
          visible++;
        } else {
          r.style.display = 'none';
        }
      });
      if(noResults) noResults.classList.toggle('d-none', visible > 0);
    }

    catSelect.addEventListener('change', filterRows);
    filterRows();
  })();
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>