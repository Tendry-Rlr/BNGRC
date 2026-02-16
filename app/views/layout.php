<?php
// layout.php - modern Bootstrap template with sidebar
if (!isset($page_title)) {
  $page_title = 'BNGRC';
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
  <style>
    :root {
      --sidebar-width: 300px;
      --sidebar-bg: #1a1d29;
      --sidebar-hover: #2a2d3d;
      --sidebar-active: #3a3d4d;
      --primary-color: #4a90e2;
      --primary-hover: #357abd;
    }

    body {
      min-height: 100vh;
      background: #f8f9fa;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: var(--sidebar-width);
      background: var(--sidebar-bg);
      padding: 0;
      z-index: 1000;
      transition: transform 0.3s ease-in-out;
      overflow-y: auto;
    }

    .sidebar-header {
      padding: 1.5rem 1.25rem;
      background: rgba(0, 0, 0, 0.2);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar-brand {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
    }

    .sidebar-brand i {
      font-size: 1.75rem;
      color: var(--primary-color);
    }

    .sidebar-menu {
      padding: 1rem 0;
    }

    .sidebar-menu-item {
      padding: 0.75rem 1.25rem;
      color: rgba(255, 255, 255, 0.8);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.75rem;
      transition: all 0.2s;
      border-left: 3px solid transparent;
    }

    .sidebar-menu-item:hover {
      background: var(--sidebar-hover);
      color: #fff;
      border-left-color: var(--primary-color);
    }

    .sidebar-menu-item.active {
      background: var(--sidebar-active);
      color: #fff;
      border-left-color: var(--primary-color);
    }

    .sidebar-menu-item i {
      font-size: 1.25rem;
      width: 24px;
      text-align: center;
    }

    .main-content {
      margin-left: var(--sidebar-width);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .top-bar {
      background: #fff;
      padding: 1rem 2rem;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .content-area {
      flex: 1;
      padding: 2rem;
    }

    .footer {
      background: #fff;
      padding: 1.5rem 2rem;
      text-align: center;
      border-top: 1px solid #e9ecef;
      margin-top: auto;
    }

    .card-modern {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .card-modern:hover {
      transform: translateY(-2px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .btn-primary {
      background: var(--primary-color);
      border-color: var(--primary-color);
    }

    .btn-primary:hover {
      background: var(--primary-hover);
      border-color: var(--primary-hover);
    }

    .sidebar-divider {
      height: 1px;
      background: rgba(255, 255, 255, 0.1);
      margin: 0.5rem 1.25rem;
    }

    .sidebar-section-title {
      padding: 0.5rem 1.25rem;
      font-size: 0.75rem;
      font-weight: 600;
      color: rgba(255, 255, 255, 0.5);
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-top: 1rem;
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .main-content {
        margin-left: 0;
      }

      .mobile-menu-toggle {
        display: block !important;
      }
    }

    .mobile-menu-toggle {
      display: none;
      background: var(--primary-color);
      border: none;
      color: #fff;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <!-- Sidebar -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <a href="<?= $baseUrl ?>/" class="sidebar-brand">
        <i class="bi bi-shield-fill-check"></i>
        <span>BNGRC</span>
      </a>
    </div>

    <nav class="sidebar-menu">
      <a href="<?= $baseUrl ?>/" class="sidebar-menu-item">
        <i class="bi bi-house-door"></i>
        <span>Accueil</span>
      </a>

      <div class="sidebar-divider"></div>

      <div class="sidebar-section-title">Actions</div>

      <a href="<?= $baseUrl ?>/don" class="sidebar-menu-item">
        <i class="bi bi-gift"></i>
        <span>Faire un don</span>
      </a>

      <a href="<?= $baseUrl ?>/addbesoin" class="sidebar-menu-item">
        <i class="bi bi-plus-circle"></i>
        <span>Ajouter un besoin</span>
      </a>

      <a href="<?= $baseUrl ?>/simulation" class="sidebar-menu-item">
        <i class="bi bi-currency-dollar"></i>
        <span>Simulation d'achat</span>
      </a>

      <a href="<?= $baseUrl ?>/recapitulation" class="sidebar-menu-item">
        <i class="bi bi-activity"></i>
        <span>Recapitulation</span>
      </a>

      <div class="sidebar-divider"></div>

    </nav>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="top-bar">
      <button class="mobile-menu-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i> Menu
      </button>
      <div></div>
      <div>
        <?php if ($isLoggedIn): ?>
          <span class="text-muted">
            <i class="bi bi-person-circle"></i> 
            <?= htmlspecialchars($currentUser['nom'] ?? 'Utilisateur') ?>
          </span>
        <?php endif; ?>
      </div>
    </div>

    <div class="content-area">
      <?= $content ?? '' ?>
    </div>

    <footer class="footer">
      <small class="text-muted">© <?= date('Y') ?> BNGRC - ETU004029 - ETU004176 - ETU004344</small>
    </footer>
  </div>

  <script src="<?= $assetBase ?>/assets/bootstrap/js/bootstrap.bundle.min.js" nonce="<?= Flight::get('csp_nonce') ?>"></script>
  <script nonce="<?= Flight::get('csp_nonce') ?>">
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('show');
    }

    // Highlight active menu item based on current URL
    document.addEventListener('DOMContentLoaded', function() {
      const currentPath = window.location.pathname;
      const menuItems = document.querySelectorAll('.sidebar-menu-item');
      
      menuItems.forEach(item => {
        if (item.getAttribute('href') === currentPath || 
            (currentPath.includes(item.getAttribute('href')) && item.getAttribute('href') !== '<?= $baseUrl ?>/')) {
          item.classList.add('active');
        }
      });
    });
  </script>
</body>

</html>