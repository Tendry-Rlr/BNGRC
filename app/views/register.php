<?php
if (!isset($baseUrl)) { $baseUrl = Flight::get('flight.base_url'); }
if (!isset($page_title)) { $page_title = 'Inscription - BNGRC'; }
ob_start();
?>
<div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
    <div class="card card-modern">
      <div class="card-body p-4">
        <div class="text-center mb-4">
          <div class="bg-primary bg-opacity-10 d-inline-flex p-3 rounded-circle mb-3">
            <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
          </div>
          <h3 class="mb-2">Créer votre compte</h3>
          <p class="text-muted mb-0">Rejoignez la plateforme BNGRC</p>
        </div>

        <?php if (!empty($success)): ?>
          <div class="alert alert-success d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2"></i>
            <div>Inscription réussie ! Bienvenue sur BNGRC.</div>
          </div>
        <?php endif; ?>
        
        <form id="registerForm" action="<?= $baseUrl ?>/register" method="post" data-validate="true" data-validate-url="<?= $baseUrl ?>/validate-register">
          <div class="row g-3">
            <div class="col-12">
              <label for="nom" class="form-label fw-semibold">
                <i class="bi bi-person"></i> Nom complet
              </label>
              <input type="text" class="form-control form-control-lg" id="nom" name="nom" 
                     placeholder="Jean Dupont" value="<?= htmlspecialchars($values['nom']) ?>">
              <?php if (!empty($errors['nom'])): ?>
                <div class="text-danger mt-2"><small><?= $errors['nom'] ?></small></div>
              <?php endif; ?>
            </div>
            
            <div class="col-12">
              <label for="email" class="form-label fw-semibold">
                <i class="bi bi-envelope"></i> Adresse email
              </label>
              <input type="email" class="form-control form-control-lg" id="email" name="email" 
                     placeholder="jean@example.com" value="<?= htmlspecialchars($values['email']) ?>">
              <?php if (!empty($errors['email'])): ?>
                <div class="text-danger mt-2"><small><?= $errors['email'] ?></small></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6">
              <label for="password" class="form-label fw-semibold">
                <i class="bi bi-lock"></i> Mot de passe
              </label>
              <input type="password" class="form-control form-control-lg" id="password" name="password" 
                     placeholder="••••••••">
              <?php if (!empty($errors['password'])): ?>
                <div class="text-danger mt-2"><small><?= $errors['password'] ?></small></div>
              <?php endif; ?>
            </div>
            
            <div class="col-md-6">
              <label for="confirm_password" class="form-label fw-semibold">
                <i class="bi bi-lock-fill"></i> Confirmer
              </label>
              <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" 
                     placeholder="••••••••">
              <?php if (!empty($errors['confirm_password'])): ?>
                <div class="text-danger mt-2"><small><?= $errors['confirm_password'] ?></small></div>
              <?php endif; ?>
            </div>
          </div>
          
          <div class="d-grid gap-3 mt-4">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="bi bi-person-plus"></i> Créer mon compte
            </button>
            
            <div class="text-center">
              <span class="text-muted">Déjà inscrit ?</span>
              <a href="<?= $baseUrl ?>/" class="text-primary text-decoration-none fw-semibold ms-1">
                Se connecter
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
