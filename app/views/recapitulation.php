<?php
ob_start();
$page_title = 'BNGRC - Recapitulatifs';
$baseUrl = $baseUrl ?? '';
?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">Récapitulatifs</h4>
  <button id="btn-actualiser" class="btn btn-outline-secondary" onclick="actualiserDonnees()">
    <i class="bi bi-arrow-clockwise"></i> Actualiser
  </button>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6">
    <div class="card h-100 text-white bg-success">
      <div class="card-body d-flex align-items-center">
        <div class="flex-grow-1">
          <div class="card-subtitle mb-1">Montant besoins restants</div>
          <div class="h4 fw-bold" id="besoin-sum-restant"><?= number_format($besoinSumRestant['sum'] ?? 0, 2) ?> Ar</div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="card h-100 text-white bg-primary">
      <div class="card-body d-flex align-items-center">
        <div class="flex-grow-1">
          <div class="card-subtitle mb-1">Montant besoins totaux et satisfaits</div>
          <div class="h4 fw-bold" id="achat-sum-totaux"><?= number_format($achatSumTotaux[0]['sum'] ?? 0, 2) ?> Ar</div>
        </div>
      </div>
    </div>
  </div>
</div>


<p class="lead">
  Liste des besoins restants
</p>
<div class="row">
  <div class="col-12">
    <div class="card card-modern">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th><i class="bi bi-tag"></i> Catégorie</th>
                <th><i class="bi bi-box"></i> Besoin</th>
                <th><i class="bi bi-currency-dollar"></i> Prix unitaire</th>
                <th><i class="bi bi-hash"></i> Quantité</th>
                <th><i class="bi bi-cart"></i> Achat </th>
              </tr>
            </thead>
            <tbody id="tbody-besoin-restant">
              <?php foreach ($besoinRestant as $l) { ?>
                <tr>
                  <td><span class="badge bg-primary"><?= htmlspecialchars($l['categorie_libelle']) ?></span></td>
                  <td><strong><?= htmlspecialchars($l['nom_Besoin']) ?></strong></td>
                  <td><?= number_format($l['prix_Unitaire'], 2) ?> Ar</td>
                  <td><span class="badge bg-info"><?= htmlspecialchars($l['quantite']) ?></span></td>
                  <?php if ($l['nom_Besoin'] != "Argent") { ?>
                    <form action="">
                      <td><a href="<?= $baseUrl ?>/achat/<?= $l['id_Besoin'] ?>" class="btn btn-success">Acheter</a></td>
                    </form>
                  <?php } ?>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<p class="lead">
  Liste des achats totaux et satisfaits
</p>
<div class="row">
  <div class="col-12">
    <div class="card card-modern">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th><i class="bi bi-box"></i> montant</th>
                <th><i class="bi bi-currency-dollar"></i> categorie_libelle</th>
                <th><i class="bi bi-hash"></i> nom_besoin</th>
              </tr>
            </thead>
            <tbody id="tbody-achat-totaux">
              <?php foreach ($achatTotaux as $l) { ?>
                <tr>
                    <td><?= $l['montant']  ?></td>
                    <td><?= $l['categorie_libelle']  ?></td>
                    <td><?= $l['nom_Besoin']  ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const BASE_URL = '<?= $baseUrl ?>';

  function actualiserDonnees() {
    const btn = document.getElementById('btn-actualiser');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Chargement...';

    const xhr = new XMLHttpRequest();
    xhr.open('GET', BASE_URL + '/api/recapitulation', true);
    xhr.setRequestHeader('Accept', 'application/json');
    
    xhr.onerror = function() {
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Actualiser';
      alert('Erreur réseau lors de l\'actualisation.');
    };

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4) {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-arrow-clockwise"></i> Actualiser';

        if (xhr.status === 200) {
          const data = JSON.parse(xhr.responseText);

          document.getElementById('besoin-sum-restant').textContent = 
            (data.besoinSumRestant && data.besoinSumRestant.sum ? data.besoinSumRestant.sum : 0) + ' Ar';
          document.getElementById('achat-sum-totaux').textContent = 
            (data.achatSumTotaux && data.achatSumTotaux[0] && data.achatSumTotaux[0].sum ? data.achatSumTotaux[0].sum : 0) + ' Ar';

          const tbodyBesoin = document.getElementById('tbody-besoin-restant');
          tbodyBesoin.innerHTML = '';
          data.besoinRestant.forEach(function (l) {
            let achatBtn = '';
            if (l.nom_Besoin !== 'Argent') {
              achatBtn = '<td><a href="' + BASE_URL + '/achat/' + l.id_Besoin + '" class="btn btn-success">Acheter</a></td>';
            }
            tbodyBesoin.innerHTML +=
              '<tr>' +
                '<td><span class="badge bg-primary">' + escapeHtml(l.categorie_libelle) + '</span></td>' +
                '<td><strong>' + escapeHtml(l.nom_Besoin) + '</strong></td>' +
                '<td>' + parseFloat(l.prix_Unitaire).toFixed(2) + ' Ar</td>' +
                '<td><span class="badge bg-info">' + escapeHtml(String(l.quantite)) + '</span></td>' +
                achatBtn +
              '</tr>';
          });

          // Mettre à jour le tableau achats totaux
          const tbodyAchat = document.getElementById('tbody-achat-totaux');
          tbodyAchat.innerHTML = '';
          data.achatTotaux.forEach(function (l) {
            tbodyAchat.innerHTML +=
              '<tr>' +
                '<td>' + l.montant + '</td>' +
                '<td>' + l.categorie_libelle + '</td>' +
                '<td>' + l.nom_Besoin + '</td>' +
              '</tr>';
          });

        } else {
          alert('Erreur lors de l\'actualisation des données.');
        }
      }
    };

    xhr.send();
  }

  function escapeHtml(text) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(text));
    return div.innerHTML;
  }
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
