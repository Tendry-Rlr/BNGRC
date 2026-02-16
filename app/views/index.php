<?php
ob_start();
$page_title = 'BNGRC - Accueil';
$baseUrl = $baseUrl ?? '';
?>

<div class="row">
  <div class="col-12 mb-4">
    <div class="card card-modern">
      <div class="card-body">
        <h4 class="card-title mb-3">
          <i class="bi bi-geo-alt-fill text-primary"></i> Régions de Madagascar
        </h4>
        <p class="text-muted">Sélectionnez une région pour voir les villes et leurs besoins</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <?php foreach($listeRegion as $l){ ?>
    <div class="col-md-6 col-lg-4">
      <a href="<?= $baseUrl ?>/ville/<?= $l['id_Region'] ?>" class="text-decoration-none">
        <div class="card card-modern h-100">
          <div class="card-body d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <div class="bg-primary bg-opacity-10 p-3 rounded">
                <i class="bi bi-map fs-3 text-primary"></i>
              </div>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-0"><?= htmlspecialchars($l['nom_Region']) ?></h5>
              <small class="text-muted">Voir les villes</small>
            </div>
            <div class="flex-shrink-0">
              <i class="bi bi-chevron-right text-muted"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  <?php } ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
