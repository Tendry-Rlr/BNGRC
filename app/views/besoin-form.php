<?php
ob_start();
$page_title = 'BNGRC - Ajouter un besoin';
$baseUrl = $baseUrl ?? '';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card card-modern">
      <div class="card-body p-4">
        <h4 class="card-title mb-4">
          <i class="bi bi-plus-circle-fill text-primary"></i> Ajouter un nouveau besoin
        </h4>
        
        <form action="<?= $baseUrl ?>/insertBesoin" method="post">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="id_ville" class="form-label fw-semibold">
                <i class="bi bi-geo-alt"></i> Ville
              </label>
              <select name="id_ville" id="id_ville" class="form-select" required>
                <option value="">Sélectionnez une ville</option>
                <?php foreach ($villes as $v) { ?>
                  <option value="<?= $v['id_Ville'] ?>"><?= htmlspecialchars($v['nom_Ville']) ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="id_besoin_categorie" class="form-label fw-semibold">
                <i class="bi bi-tag"></i> Catégorie du besoin
              </label>
              <select name="id_besoin_categorie" id="id_besoin_categorie" class="form-select" required>
                <option value="">Sélectionnez une catégorie</option>
                <?php foreach ($besoinCategories as $c) { ?>
                  <option value="<?= $c['id_Besoin_Categorie'] ?>"><?= htmlspecialchars($c['libelle']) ?></option>
                <?php } ?>
              </select>
            </div>

            <div class="col-md-6">
              <label for="nomBesoin" class="form-label fw-semibold">
                <i class="bi bi-box"></i> Nom du besoin
              </label>
              <input type="text" name="nomBesoin" id="nomBesoin" class="form-control" placeholder="Ex: Riz, Eau potable..." required>
            </div>

            <div class="col-md-6">
              <label for="quantite" class="form-label fw-semibold">
                <i class="bi bi-hash"></i> Quantité
              </label>
              <input type="number" name="quantite" id="quantite" class="form-control" min="1" placeholder="Ex: 100" required>
            </div>

            <div class="col-12 mt-4">
              <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-check-circle"></i> Enregistrer le besoin
              </button>
              <a href="<?= $baseUrl ?>/" class="btn btn-secondary btn-lg ms-2">
                <i class="bi bi-x-circle"></i> Annuler
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>