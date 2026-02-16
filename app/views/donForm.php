<?php
ob_start();
$page_title = 'BNGRC - Formulaire de don';
$baseUrl = $baseUrl ?? '';
?>

<div class="d-flex justify-content-center py-5">
  <div class="card shadow-sm w-100" style="max-width:720px;">
    <div class="card-body">
      <h5 class="card-title mb-4">Faire un don</h5>

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

      <form method="post" action="<?= $baseUrl ?>/donner" class="row g-3 align-items-center">

        <div class="col-md-5">
          <label for="dons-select" class="form-label">Produit</label>
          <select class="form-select" name="dons" id="dons-select" required>
            <?php foreach ($listeBesoin as $besoin): ?>
              <option value="<?= $besoin['id_Besoin_Fille'] ?>"><?= htmlspecialchars($besoin['nom_Besoin']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-2">
          <label for="quantite" class="form-label">Quantité</label>
          <input id="quantite" name="quantite" type="number" min="1" value="1" class="form-control" required>
        </div>

        <div class="col-md-4 d-flex align-items-end">
          <button class="btn btn-primary w-100" type="submit">Valider</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container mb-5" style="max-width:920px;">
  <h6 class="mt-3 mb-3">Liste des dons</h6>

  <?php if (empty($listeDon ?? [])): ?>
    <div class="alert alert-secondary" role="alert">Aucun don pour le moment.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table id="don-table" class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>Villes</th>
            <th>Régions</th>
            <th>Nom du produit</th>
            <th>Quantité</th>
            <th>Date du don</th>
          </tr>
        </thead>
        <tbody>
                <?php foreach ($listeDon as $don){ ?>
                <tr>
                    <td><?= $don['nom_Ville']  ?></td>
                    <td><?= $don['nom_Region']  ?></td>
                    <td><?= $don['nom_produit']  ?></td>
                    <td><?= $don['quantite_don']  ?></td>
                    <td><?= $don['date_dispatch']  ?></td>
                </tr>
                <?php } ?>
        </tbody>
      </table>
    </div>
    <div id="noResults" class="alert alert-warning mt-3 d-none">Aucun don pour cette catégorie.</div>
  <?php endif; ?>
</div>

<script>
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
    // initial filter on load
    filterRows();
  })();
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
