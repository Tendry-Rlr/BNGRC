<?php
ob_start();
$page_title = 'BNGRC - Formulaire de don';
$baseUrl = $baseUrl ?? '';
?>

<div class="d-flex justify-content-center py-5">
  <div class="card shadow-sm w-100" style="max-width:720px;">
    <div class="card-body">
      <h5 class="card-title mb-4">Faire un don</h5>

      <form method="post" action="" class="row g-3 align-items-center">
        <div class="col-auto flex-grow-1">
          <label for="dons-select" class="visually-hidden">Dons</label>
          <select class="form-select" name="dons" id="dons-select" required>
            <option value="">Donnez...</option>
            <option value="argent">Argent</option>
            <option value="nourriture">Nourriture</option>
          </select>
        </div>

        <div class="col-auto">
          <button class="btn btn-primary" type="submit">Valider</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="container mb-5" style="max-width:720px;">
  <h6 class="mt-3 mb-2">Liste des dons</h6>

  <?php if (empty($donList ?? [])): ?>
    <div class="alert alert-secondary" role="alert">Aucun don pour le moment.</div>
  <?php else: ?>
    <ul class="list-group">
      <?php foreach ($donList as $don): ?>
        <?php
          $label = $don['dons'] ?? $don['type'] ?? null;
          if (!$label) {
            // fall back to showing some fields if present
            $parts = [];
            foreach (['nom','name','id'] as $k) if (!empty($don[$k])) $parts[] = $don[$k];
            $label = $parts ? implode(' - ', $parts) : 'Don';
          }
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-start">
          <div>
            <div class="fw-semibold"><?= htmlspecialchars($label) ?></div>
            <?php if (!empty($don['info'])): ?><div class="text-muted small"><?= htmlspecialchars($don['info']) ?></div><?php endif; ?>
          </div>
          <?php if (!empty($don['created_at'])): ?><small class="text-muted"><?= htmlspecialchars($don['created_at']) ?></small><?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
