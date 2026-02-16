<?php
$page_title = 'BNGRC - Ensemble, faisons la différence';
$baseUrl = $baseUrl ?? '';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?></title>
  <link href="<?= $baseUrl ?>/assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= $baseUrl ?>/assets/bootstrap/bootstrap-icons/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    :root {
      --primary: #e63946;
      --primary-dark: #c1121f;
      --secondary: #457b9d;
      --accent: #f4a261;
      --light: #f1faee;
      --dark: #1d3557;
      --success: #2a9d8f;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      color: var(--dark);
      overflow-x: hidden;
    }

    /* ==================== NAVBAR ==================== */
    .navbar-donation {
      background: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 20px rgba(0,0,0,0.1);
      padding: 1rem 0;
      transition: all 0.3s ease;
    }

    .navbar-donation.scrolled {
      padding: 0.5rem 0;
      background: white;
    }

    .navbar-brand {
      font-weight: 800;
      font-size: 1.8rem;
      color: var(--primary) !important;
    }

    .navbar-brand span {
      color: var(--dark);
    }

    .nav-link {
      font-weight: 500;
      color: var(--dark) !important;
      margin: 0 0.5rem;
      position: relative;
      transition: color 0.3s ease;
    }

    .nav-link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--primary);
      transition: all 0.3s ease;
      transform: translateX(-50%);
    }

    .nav-link:hover::after {
      width: 100%;
    }

    .nav-link:hover {
      color: var(--primary) !important;
    }

    .btn-donate-nav {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white !important;
      padding: 0.6rem 1.5rem;
      border-radius: 50px;
      font-weight: 600;
      transition: all 0.3s ease;
      border: none;
    }

    .btn-donate-nav:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 30px rgba(230, 57, 70, 0.4);
    }

    /* ==================== HERO SECTION ==================== */
    .hero-section {
      min-height: 100vh;
      background: linear-gradient(135deg, rgba(29, 53, 87, 0.9), rgba(69, 123, 157, 0.8)), 
                  url('https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .hero-section::before {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 150px;
      background: linear-gradient(to top, white, transparent);
    }

    .hero-content {
      position: relative;
      z-index: 2;
    }

    .hero-title {
      font-size: 3.5rem;
      font-weight: 800;
      color: white;
      line-height: 1.2;
      margin-bottom: 1.5rem;
    }

    .hero-title span {
      color: var(--accent);
    }

    .hero-subtitle {
      font-size: 1.3rem;
      color: rgba(255,255,255,0.9);
      margin-bottom: 2rem;
      line-height: 1.8;
    }

    .btn-hero {
      padding: 1rem 2.5rem;
      font-size: 1.1rem;
      font-weight: 600;
      border-radius: 50px;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .btn-hero-primary {
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      box-shadow: 0 10px 40px rgba(230, 57, 70, 0.4);
    }

    .btn-hero-primary:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 50px rgba(230, 57, 70, 0.5);
      color: white;
    }

    .btn-hero-secondary {
      background: transparent;
      color: white;
      border: 2px solid white;
    }

    .btn-hero-secondary:hover {
      background: white;
      color: var(--dark);
    }

    .hero-stats {
      display: flex;
      gap: 3rem;
      margin-top: 3rem;
    }

    .stat-item {
      text-align: center;
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      color: var(--accent);
      display: block;
    }

    .stat-label {
      color: rgba(255,255,255,0.8);
      font-size: 0.9rem;
    }

    /* ==================== IMPACT SECTION ==================== */
    .impact-section {
      padding: 6rem 0;
      background: white;
    }

    .section-title {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 1rem;
    }

    .section-subtitle {
      color: #666;
      font-size: 1.1rem;
      margin-bottom: 3rem;
    }

    .impact-card {
      background: white;
      border-radius: 20px;
      padding: 2.5rem;
      text-align: center;
      transition: all 0.4s ease;
      border: 1px solid #eee;
      height: 100%;
    }

    .impact-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 60px rgba(0,0,0,0.1);
      border-color: var(--primary);
    }

    .impact-icon {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, var(--primary), var(--accent));
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2rem;
      color: white;
    }

    .impact-card h4 {
      font-weight: 700;
      margin-bottom: 1rem;
      color: var(--dark);
    }

    .impact-card p {
      color: #666;
      line-height: 1.7;
    }

    /* ==================== CAUSES SECTION ==================== */
    .causes-section {
      padding: 6rem 0;
      background: var(--light);
    }

    .cause-card {
      background: white;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 10px 40px rgba(0,0,0,0.08);
      transition: all 0.4s ease;
      height: 100%;
    }

    .cause-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }

    .cause-image {
      height: 200px;
      background-size: cover;
      background-position: center;
      position: relative;
    }

    .cause-category {
      position: absolute;
      top: 1rem;
      left: 1rem;
      background: var(--primary);
      color: white;
      padding: 0.4rem 1rem;
      border-radius: 50px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .cause-content {
      padding: 1.5rem;
    }

    .cause-title {
      font-weight: 700;
      font-size: 1.2rem;
      margin-bottom: 0.8rem;
      color: var(--dark);
    }

    .cause-description {
      color: #666;
      font-size: 0.95rem;
      margin-bottom: 1.5rem;
      line-height: 1.6;
    }

    .progress-wrapper {
      margin-bottom: 1rem;
    }

    .progress {
      height: 10px;
      border-radius: 10px;
      background: #eee;
      overflow: hidden;
    }

    .progress-bar {
      background: linear-gradient(135deg, var(--primary), var(--accent));
      border-radius: 10px;
    }

    .progress-info {
      display: flex;
      justify-content: space-between;
      font-size: 0.85rem;
      margin-top: 0.5rem;
    }

    .raised-amount {
      font-weight: 700;
      color: var(--primary);
    }

    .goal-amount {
      color: #999;
    }

    .btn-donate {
      width: 100%;
      padding: 0.8rem;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-donate:hover {
      box-shadow: 0 10px 30px rgba(230, 57, 70, 0.4);
      color: white;
    }

    /* ==================== HOW IT WORKS ==================== */
    .how-section {
      padding: 6rem 0;
      background: white;
    }

    .step-card {
      text-align: center;
      padding: 2rem;
      position: relative;
    }

    .step-number {
      width: 60px;
      height: 60px;
      background: linear-gradient(135deg, var(--secondary), var(--dark));
      color: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0 auto 1.5rem;
    }

    .step-card h4 {
      font-weight: 700;
      margin-bottom: 1rem;
      color: var(--dark);
    }

    .step-card p {
      color: #666;
    }

    .step-connector {
      position: absolute;
      top: 50px;
      right: -50%;
      width: 100%;
      height: 2px;
      background: linear-gradient(90deg, var(--secondary), var(--primary));
      z-index: 0;
    }

    /* ==================== TESTIMONIALS ==================== */
    .testimonials-section {
      padding: 6rem 0;
      background: linear-gradient(135deg, var(--dark), var(--secondary));
    }

    .testimonial-card {
      background: white;
      border-radius: 20px;
      padding: 2rem;
      margin: 1rem;
      box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }

    .testimonial-text {
      font-style: italic;
      color: #555;
      line-height: 1.8;
      margin-bottom: 1.5rem;
    }

    .testimonial-author {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .author-avatar {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      object-fit: cover;
    }

    .author-name {
      font-weight: 700;
      color: var(--dark);
      margin-bottom: 0.2rem;
    }

    .author-role {
      color: #999;
      font-size: 0.85rem;
    }

    /* ==================== URGENT APPEAL ==================== */
    .urgent-section {
      padding: 6rem 0;
      background: linear-gradient(135deg, var(--primary), var(--primary-dark));
      color: white;
      text-align: center;
    }

    .urgent-section h2 {
      font-size: 2.5rem;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }

    .urgent-section p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 2rem;
      max-width: 600px;
      margin-left: auto;
      margin-right: auto;
    }

    .btn-urgent {
      background: white;
      color: var(--primary);
      padding: 1rem 3rem;
      font-size: 1.1rem;
      font-weight: 700;
      border-radius: 50px;
      border: none;
      transition: all 0.3s ease;
    }

    .btn-urgent:hover {
      transform: translateY(-3px);
      box-shadow: 0 15px 40px rgba(0,0,0,0.3);
      color: var(--primary-dark);
    }

    /* ==================== NEWSLETTER ==================== */
    .newsletter-section {
      padding: 4rem 0;
      background: white;
    }

    .newsletter-form {
      max-width: 500px;
      margin: 0 auto;
    }

    .newsletter-input {
      border-radius: 50px 0 0 50px;
      border: 2px solid #eee;
      padding: 1rem 1.5rem;
      border-right: none;
    }

    .newsletter-input:focus {
      border-color: var(--primary);
      box-shadow: none;
    }

    .newsletter-btn {
      border-radius: 0 50px 50px 0;
      background: var(--primary);
      border: none;
      padding: 1rem 2rem;
      color: white;
      font-weight: 600;
    }

    .newsletter-btn:hover {
      background: var(--primary-dark);
      color: white;
    }

    /* ==================== FOOTER ==================== */
    .footer {
      background: var(--dark);
      color: white;
      padding: 4rem 0 2rem;
    }

    .footer-brand {
      font-size: 1.8rem;
      font-weight: 800;
      color: white;
      margin-bottom: 1rem;
    }

    .footer-brand span {
      color: var(--accent);
    }

    .footer-description {
      color: rgba(255,255,255,0.7);
      line-height: 1.8;
      margin-bottom: 1.5rem;
    }

    .footer-title {
      font-weight: 700;
      margin-bottom: 1.5rem;
      color: white;
    }

    .footer-links {
      list-style: none;
      padding: 0;
    }

    .footer-links li {
      margin-bottom: 0.8rem;
    }

    .footer-links a {
      color: rgba(255,255,255,0.7);
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .footer-links a:hover {
      color: var(--accent);
      padding-left: 5px;
    }

    .footer-contact li {
      display: flex;
      align-items: center;
      gap: 1rem;
      margin-bottom: 1rem;
      color: rgba(255,255,255,0.7);
    }

    .footer-contact i {
      color: var(--accent);
      width: 20px;
    }

    .social-links {
      display: flex;
      gap: 1rem;
      margin-top: 1.5rem;
    }

    .social-link {
      width: 45px;
      height: 45px;
      background: rgba(255,255,255,0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      transition: all 0.3s ease;
    }

    .social-link:hover {
      background: var(--primary);
      color: white;
      transform: translateY(-3px);
    }

    .footer-bottom {
      border-top: 1px solid rgba(255,255,255,0.1);
      margin-top: 3rem;
      padding-top: 2rem;
      text-align: center;
      color: rgba(255,255,255,0.5);
    }

    /* ==================== ANIMATIONS ==================== */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fadeInUp {
      animation: fadeInUp 0.6s ease forwards;
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
      .hero-title {
        font-size: 2.2rem;
      }

      .hero-stats {
        flex-direction: column;
        gap: 1.5rem;
      }

      .section-title {
        font-size: 1.8rem;
      }

      .step-connector {
        display: none;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-donation fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <i class="bi bi-heart-fill me-2"></i>BNGRC<span>help</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a class="nav-link" href="#accueil">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#causes">Nos Causes</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#impact">Notre Impact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#comment">Comment Aider</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#contact">Contact</a>
          </li>
        </ul>
        <a href="#donner" class="btn btn-donate-nav">
          <i class="bi bi-heart-fill me-2"></i>Faire un Don
        </a>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="hero-section" id="accueil">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 hero-content">
          <h1 class="hero-title animate-fadeInUp">
            Ensemble, nous pouvons<br>
            <span>changer des vies</span>
          </h1>
          <p class="hero-subtitle animate-fadeInUp" style="animation-delay: 0.2s">
            Chaque don compte. Rejoignez notre communauté de donateurs engagés 
            et aidez-nous à apporter espoir et soutien à ceux qui en ont le plus besoin.
          </p>
          <div class="d-flex gap-3 flex-wrap animate-fadeInUp" style="animation-delay: 0.4s">
            <a href="#donner" class="btn btn-hero btn-hero-primary">
              <i class="bi bi-heart-fill"></i> Faire un Don
            </a>
            <a href="#causes" class="btn btn-hero btn-hero-secondary">
              <i class="bi bi-play-circle-fill"></i> Découvrir nos causes
            </a>
          </div>
          <div class="hero-stats animate-fadeInUp" style="animation-delay: 0.6s">
            <div class="stat-item">
              <span class="stat-number">15K+</span>
              <span class="stat-label">Donateurs</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">250M Ar</span>
              <span class="stat-label">Collectés</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">50+</span>
              <span class="stat-label">Projets réalisés</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Impact Section -->
  <section class="impact-section" id="impact">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Notre Impact</h2>
        <p class="section-subtitle">Découvrez comment vos dons transforment des vies chaque jour</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-3 col-md-6">
          <div class="impact-card">
            <div class="impact-icon">
              <i class="bi bi-cup-hot-fill"></i>
            </div>
            <h4>Aide Alimentaire</h4>
            <p>Plus de 10 000 repas distribués chaque mois aux familles dans le besoin</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="impact-card">
            <div class="impact-icon">
              <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h4>Éducation</h4>
            <p>500 enfants scolarisés et accompagnés dans leur parcours éducatif</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="impact-card">
            <div class="impact-icon">
              <i class="bi bi-heart-pulse-fill"></i>
            </div>
            <h4>Santé</h4>
            <p>Accès aux soins médicaux pour 2 000 personnes chaque année</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="impact-card">
            <div class="impact-icon">
              <i class="bi bi-house-fill"></i>
            </div>
            <h4>Logement</h4>
            <p>100 familles relogées dans des conditions décentes et sécurisées</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Causes Section -->
  <section class="causes-section" id="causes">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Causes Urgentes</h2>
        <p class="section-subtitle">Ces projets ont besoin de votre soutien immédiat</p>
      </div>
      <div class="row g-4">
        <div class="col-lg-4 col-md-6">
          <div class="cause-card">
            <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
              <span class="cause-category">Urgence</span>
            </div>
            <div class="cause-content">
              <h5 class="cause-title">Aide aux victimes de cyclone</h5>
              <p class="cause-description">Fournir abri, nourriture et soins médicaux aux familles sinistrées du sud-est.</p>
              <div class="progress-wrapper">
                <div class="progress">
                  <div class="progress-bar" style="width: 75%"></div>
                </div>
                <div class="progress-info">
                  <span class="raised-amount">75 000 000 Ar</span>
                  <span class="goal-amount">/ 100 000 000 Ar</span>
                </div>
              </div>
              <button class="btn btn-donate">Donner Maintenant</button>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="cause-card">
            <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1497486751825-1233686d5d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
              <span class="cause-category">Éducation</span>
            </div>
            <div class="cause-content">
              <h5 class="cause-title">Construction d'une école</h5>
              <p class="cause-description">Construire une école pour 200 enfants dans un village rural isolé.</p>
              <div class="progress-wrapper">
                <div class="progress">
                  <div class="progress-bar" style="width: 45%"></div>
                </div>
                <div class="progress-info">
                  <span class="raised-amount">45 000 000 Ar</span>
                  <span class="goal-amount">/ 100 000 000 Ar</span>
                </div>
              </div>
              <button class="btn btn-donate">Donner Maintenant</button>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="cause-card">
            <div class="cause-image" style="background-image: url('https://images.unsplash.com/photo-1584515933487-779824d29309?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')">
              <span class="cause-category">Santé</span>
            </div>
            <div class="cause-content">
              <h5 class="cause-title">Équipement médical</h5>
              <p class="cause-description">Équiper un centre de santé avec du matériel médical essentiel.</p>
              <div class="progress-wrapper">
                <div class="progress">
                  <div class="progress-bar" style="width: 60%"></div>
                </div>
                <div class="progress-info">
                  <span class="raised-amount">30 000 000 Ar</span>
                  <span class="goal-amount">/ 50 000 000 Ar</span>
                </div>
              </div>
              <button class="btn btn-donate">Donner Maintenant</button>
            </div>
          </div>
        </div>
      </div>
      <div class="text-center mt-5">
        <a href="#" class="btn btn-outline-primary btn-lg rounded-pill px-5">
          Voir toutes les causes <i class="bi bi-arrow-right ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- How It Works -->
  <section class="how-section" id="comment">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title">Comment Ça Marche ?</h2>
        <p class="section-subtitle">Faire un don n'a jamais été aussi simple</p>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6">
          <div class="step-card">
            <div class="step-connector d-none d-lg-block"></div>
            <div class="step-number">1</div>
            <h4>Choisissez une cause</h4>
            <p>Parcourez nos projets et trouvez celui qui vous tient à cœur</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="step-card">
            <div class="step-connector d-none d-lg-block"></div>
            <div class="step-number">2</div>
            <h4>Définissez le montant</h4>
            <p>Chaque contribution compte, même la plus petite</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="step-card">
            <div class="step-connector d-none d-lg-block"></div>
            <div class="step-number">3</div>
            <h4>Effectuez le paiement</h4>
            <p>Paiement sécurisé par Mobile Money ou carte bancaire</p>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="step-card">
            <div class="step-number">4</div>
            <h4>Suivez l'impact</h4>
            <p>Recevez des mises à jour sur l'utilisation de vos dons</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials-section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section-title text-white">Ce Qu'ils Disent</h2>
        <p class="section-subtitle text-white-50">Témoignages de nos donateurs et bénéficiaires</p>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="testimonial-card">
            <p class="testimonial-text">
              "Grâce à BNGRC, j'ai pu contribuer à la reconstruction après le cyclone. 
              La transparence et le suivi m'ont vraiment convaincu."
            </p>
            <div class="testimonial-author">
              <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Avatar" class="author-avatar">
              <div>
                <div class="author-name">Marie Rasoarilala</div>
                <div class="author-role">Donatrice régulière</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="testimonial-card">
            <p class="testimonial-text">
              "Mon fils peut maintenant aller à l'école grâce à votre programme de bourses. 
              Vous avez changé notre vie. Merci infiniment."
            </p>
            <div class="testimonial-author">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Avatar" class="author-avatar">
              <div>
                <div class="author-name">Jean Rakoto</div>
                <div class="author-role">Bénéficiaire</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="testimonial-card">
            <p class="testimonial-text">
              "En tant qu'entreprise, nous sommes fiers de soutenir BNGRC. 
              Leur engagement envers la communauté est exemplaire."
            </p>
            <div class="testimonial-author">
              <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="Avatar" class="author-avatar">
              <div>
                <div class="author-name">Hery Andrianarisoa</div>
                <div class="author-role">Directeur - Entreprise XYZ</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Urgent Appeal -->
  <section class="urgent-section" id="donner">
    <div class="container">
      <h2><i class="bi bi-exclamation-circle-fill me-3"></i>Appel Urgent</h2>
      <p>
        Des milliers de familles attendent votre aide. Chaque don, aussi petit soit-il, 
        peut faire une différence significative dans leur vie.
      </p>
      <a href="#" class="btn btn-urgent">
        <i class="bi bi-heart-fill me-2"></i>Faire un Don Maintenant
      </a>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="newsletter-section">
    <div class="container">
      <div class="text-center mb-4">
        <h3 class="section-title">Restez Informé</h3>
        <p class="text-muted">Inscrivez-vous pour recevoir nos actualités et l'impact de vos dons</p>
      </div>
      <form class="newsletter-form">
        <div class="input-group">
          <input type="email" class="form-control newsletter-input" placeholder="Votre adresse email">
          <button class="btn newsletter-btn" type="submit">S'inscrire</button>
        </div>
      </form>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer" id="contact">
    <div class="container">
      <div class="row g-4">
        <div class="col-lg-4">
          <div class="footer-brand">
            <i class="bi bi-heart-fill me-2"></i>BNGRC<span>help</span>
          </div>
          <p class="footer-description">
            Bureau National de Gestion des Risques et des Catastrophes. 
            Ensemble, construisons un avenir meilleur pour Madagascar.
          </p>
          <div class="social-links">
            <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
            <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
            <a href="#" class="social-link"><i class="bi bi-instagram"></i></a>
            <a href="#" class="social-link"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
        <div class="col-lg-2 col-md-6">
          <h5 class="footer-title">Liens Rapides</h5>
          <ul class="footer-links">
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Nos Causes</a></li>
            <li><a href="#">Comment Aider</a></li>
            <li><a href="#">Notre Équipe</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </div>
        <div class="col-lg-2 col-md-6">
          <h5 class="footer-title">Causes</h5>
          <ul class="footer-links">
            <li><a href="#">Aide d'urgence</a></li>
            <li><a href="#">Éducation</a></li>
            <li><a href="#">Santé</a></li>
            <li><a href="#">Environnement</a></li>
            <li><a href="#">Logement</a></li>
          </ul>
        </div>
        <div class="col-lg-4 col-md-6">
          <h5 class="footer-title">Contact</h5>
          <ul class="footer-contact list-unstyled">
            <li>
              <i class="bi bi-geo-alt-fill"></i>
              <span>Antananarivo, Madagascar</span>
            </li>
            <li>
              <i class="bi bi-telephone-fill"></i>
              <span>+261 34 00 000 00</span>
            </li>
            <li>
              <i class="bi bi-envelope-fill"></i>
              <span>contact@bngrc.mg</span>
            </li>
            <li>
              <i class="bi bi-clock-fill"></i>
              <span>Lun - Ven: 8h00 - 17h00</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2026 BNGRChelp. Tous droits réservés. | Fait avec <i class="bi bi-heart-fill text-danger"></i> pour Madagascar</p>
      </div>
    </div>
  </footer>

  <script src="<?= $baseUrl ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar-donation');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // Animation on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
        }
      });
    }, observerOptions);

    document.querySelectorAll('.impact-card, .cause-card, .step-card, .testimonial-card').forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(30px)';
      el.style.transition = 'all 0.6s ease';
      observer.observe(el);
    });
  </script>
</body>
</html>
