<?php
ob_start();
$page_title = 'BNGRC - Formulaire d\'achat';
$baseUrl = $baseUrl ?? '';
$error = $_GET['error'] ?? '';
?>

<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card card-modern">
      <div class="card-body p-4">
        <h4 class="card-title mb-4">
          <i class="bi bi-cart-fill text-primary"></i> Formulaire d'achat
        </h4>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <div><?= htmlspecialchars($error) ?></div>
          </div>
        <?php endif; ?>

        <div class="card bg-light mb-4">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <i class="bi bi-info-circle text-primary"></i> Information sur le besoin
            </h5>
            <div class="row g-3">
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="bi bi-box-seam text-muted me-2"></i>
                  <div>
                    <small class="text-muted">Nom</small>
                    <div class="fw-bold"><?= htmlspecialchars($besoin['nom_Besoin']) ?></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="bi bi-tag text-muted me-2"></i>
                  <div>
                    <small class="text-muted">Catégorie</small>
                    <div class="fw-bold"><?= htmlspecialchars($besoin['categorie_libelle']) ?></div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="bi bi-currency-dollar text-muted me-2"></i>
                  <div>
                    <small class="text-muted">Prix unitaire</small>
                    <div class="fw-bold text-success"><?= number_format($besoin['prix_Unitaire'], 2) ?> Ar</div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center">
                  <i class="bi bi-hash text-muted me-2"></i>
                  <div>
                    <small class="text-muted">Quantité disponible</small>
                    <div class="fw-bold text-info"><?= htmlspecialchars($besoin['quantite']) ?></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <form action="<?= $baseUrl ?>/insertAchat" method="post">
          <div class="mb-4">
            <label for="quantite" class="form-label fw-semibold">
              <i class="bi bi-hash"></i> Quantité à acheter
            </label>
            <input type="number" 
                   class="form-control form-control-lg" 
                   id="quantite" 
                   name="quantite" 
                   min="1" 
                   max="<?= $besoin['quantite'] ?>"
                   placeholder="Entrez la quantité" 
                   required>
            <div class="form-text">
              <i class="bi bi-info-circle"></i> Maximum: <?= htmlspecialchars($besoin['quantite']) ?> unités
            </div>
          </div>

          <input type="hidden" name="id_besoin" value="<?= $besoin['id_Besoin'] ?>">
          <input type="hidden" name="id_besoin_categorie" value="<?= $besoin['id_Besoin_Categorie'] ?>">
          <input type="hidden" name="id_ville" value="<?= $besoin['id_Ville'] ?>">
          <input type="hidden" name="pU" value="<?= $besoin['prix_Unitaire'] ?>">
          <input type="hidden" name="quantite_besoin" value="<?= $besoin['quantite'] ?>">

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="bi bi-cart-check"></i> Confirmer l'achat
            </button>
            <a href="<?= $baseUrl ?>/besoinville/<?= $besoin['id_Ville'] ?>" class="btn btn-secondary btn-lg">
              <i class="bi bi-x-circle"></i> Annuler
            </a>
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