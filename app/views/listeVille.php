<?php
ob_start();
$page_title = 'BNGRC - Liste des villes';
$baseUrl = $baseUrl ?? '';
?>

<div class="row">
  <div class="col-12 mb-4">
    <div class="card card-modern">
      <div class="card-body">
        <h4 class="card-title mb-3">
          <i class="bi bi-building text-primary"></i> Villes de la région
        </h4>
        <p class="text-muted">Sélectionnez une ville pour voir ses besoins</p>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <?php foreach($listeVille as $l){ ?>
    <div class="col-md-6 col-lg-4">
      <a href="<?= $baseUrl ?>/besoinville/<?= $l['id_Ville'] ?>" class="text-decoration-none">
        <div class="card card-modern h-100">
          <div class="card-body d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
              <div class="bg-success bg-opacity-10 p-3 rounded">
                <i class="bi bi-pin-map-fill fs-3 text-success"></i>
              </div>
            </div>
            <div class="flex-grow-1">
              <h5 class="mb-0"><?= htmlspecialchars($l['nom_Ville']) ?></h5>
              <small class="text-muted">Voir les besoins</small>
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
