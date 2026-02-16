<?php
ob_start();
$page_title = 'Formulaire de don - Produits';
$baseUrl = $baseUrl ?? '';
?>

<div class="d-flex justify-content-center py-5">
  <div class="card shadow-sm w-100" style="max-width:820px;">
    <div class="card-body">
      <h5 class="card-title mb-4">Don - Sélectionnez le produit</h5>

      <form method="post" action="" class="row g-3">
        <div class="col-md-4">
          <label for="categorie-select" class="form-label">Catégorie</label>
          <select id="categorie-select" class="form-select" required>
            <option value="">Choisir une catégorie...</option>
            <?php foreach (($categories ?? []) as $cat):
              $cid = $cat['id_Besoin_Categorie'] ?? $cat['id'] ?? $cat['id_BesoinCategorie'] ?? null;
              $cl = $cat['categorie_libelle'] ?? $cat['libelle'] ?? $cat['nom'] ?? '';
              if ($cid === null) continue;
            ?>
              <option value="<?= htmlspecialchars($cid) ?>"><?= htmlspecialchars($cl) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-5">
          <label for="produit-select" class="form-label">Produit</label>
          <select id="produit-select" name="produit" class="form-select" required>
            <option value="">Choisir un produit...</option>
            <?php foreach (($products ?? []) as $p):
              // try flexible keys
              $pid = $p['id_Besoin'] ?? $p['id'] ?? $p['id_Besoin_Fille'] ?? null;
              $label = $p['nom_Besoin'] ?? $p['nom'] ?? $p['name'] ?? '';
              $catId = $p['id_Besoin_Categorie'] ?? $p['id_BesoinCategorie'] ?? $p['categorie_id'] ?? '';
              $available = $p['quantite'] ?? $p['available'] ?? $p['stock'] ?? '';
              if ($pid === null) continue;
            ?>
              <option value="<?= htmlspecialchars($pid) ?>" data-cat="<?= htmlspecialchars($catId) ?>" data-available="<?= htmlspecialchars($available) ?>">
                <?= htmlspecialchars($label) ?><?php if ($available !== ''): ?> (disponible: <?= htmlspecialchars($available) ?>)<?php endif; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-3">
          <label for="quantite" class="form-label">Quantité</label>
          <input id="quantite" name="quantite" type="number" class="form-control" min="1" value="1" required>
          <div class="form-text" id="availableText"></div>
        </div>

        <div class="col-12 text-end">
          <button class="btn btn-primary" type="submit">Donner</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  (function(){
    var catSelect = document.getElementById('categorie-select');
    var prodSelect = document.getElementById('produit-select');
    var qtyInput = document.getElementById('quantite');
    var availText = document.getElementById('availableText');

    function filterProducts(){
      var cat = catSelect.value;
      Array.from(prodSelect.options).forEach(function(opt){
        var optCat = opt.getAttribute('data-cat') || '';
        if(!opt.value) return; // keep placeholder
        opt.style.display = (cat === '' || String(optCat) === String(cat)) ? '' : 'none';
      });
      // reset selection
      prodSelect.value = '';
      qtyInput.value = 1;
      qtyInput.removeAttribute('max');
      availText.textContent = '';
    }

    function updateAvailable(){
      var opt = prodSelect.selectedOptions[0];
      if(!opt || !opt.value){ qtyInput.removeAttribute('max'); availText.textContent=''; return; }
      var available = opt.getAttribute('data-available');
      if(available !== null && available !== ''){
        qtyInput.max = available;
        availText.textContent = 'Disponible: ' + available;
        if(Number(qtyInput.value) > Number(available)) qtyInput.value = available;
      } else {
        qtyInput.removeAttribute('max');
        availText.textContent = '';
      }
    }

    if(catSelect) catSelect.addEventListener('change', filterProducts);
    if(prodSelect) prodSelect.addEventListener('change', updateAvailable);
  })();
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
