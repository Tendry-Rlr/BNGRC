<?php
// layout.php - modern Bootstrap template
if (!isset($page_title)) {
  $page_title = 'TriHomme';
}
if (!isset($baseUrl)) {
  $baseUrl = Flight::get('flight.base_url') ?: '';
}
$assetBase = rtrim($baseUrl, '/');
$isLoggedIn = !empty($currentUser ?? false);
$isAdmin = !empty($isAdminUser ?? false);
?>
<!doctype html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($page_title) ?></title>
  <link href="<?= $assetBase ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $assetBase ?>/assets/bootstrap/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="<?= $baseUrl ?>"><?= htmlspecialchars($page_title) ?></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php if ($isLoggedIn): ?>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/logout">Déconnexion</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>">Connexion</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/register">Inscription</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <main class="container py-4">
    <?= $content ?? '' ?>
  </main>

  <footer class="bg-light text-center py-3">
    <small class="text-muted">© <?= date('Y') ?> BNGRC</small>
  </footer>

  <script src="<?= $assetBase ?>/assets/bootstrap/js/bootstrap.bundle.min.js" nonce="<?= Flight::get('csp_nonce') ?>"></script>
</body>

</html>