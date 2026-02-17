<?php
ob_start();
$page_title = 'BNGRC - Filtrer les dons par ville';
$baseUrl = $baseUrl ?? '';
$villes = $villes ?? [];
$achats = $achats ?? [];
?>

<div class="row justify-content-center mb-4">
    <div class="col-lg-10 col-xl-8">
        <div class="card card-modern">
            <div class="card-body">
                <h4 class="card-title mb-3">
                    <i class="bi bi-filter-circle-fill text-primary"></i> Filtrer les dons par ville
                </h4>

                <form id="filterForm" action="<?= $baseUrl ?>/filtreAchat" method="post"
                    class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="ville-select" class="form-label fw-semibold">Ville</label>
                        <select id="ville-select" class="form-select" name="id_ville">
                            <option value="">Toutes les villes</option>
                            <?php foreach ($villes as $v): ?>
                                <option value="<?= htmlspecialchars($v['id_Ville'] ?? $v['id']) ?>">
                                    <?= htmlspecialchars($v['nom_Ville'] ?? $v['nom']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-lg w-100">
                            Filtrer
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card card-modern">
            <div class="card-body">
                <h5 class="card-title mb-3"><i class="bi bi-list-ul text-primary"></i> Liste des achats validés</h5>
                <div class="table-responsive">
                    <table id="don-table" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ville</th>
                                <th>Région</th>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Montant</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($achats)): ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Aucun achat validé.</td>
                                </tr>
                            <?php else: ?>
                            <?php foreach ($achats as $achat):
                                $ville = htmlspecialchars($achat['nom_Ville'] ?? '-');
                                $region = htmlspecialchars($achat['nom_Region'] ?? '-');
                                $produit = htmlspecialchars($achat['nom_Besoin'] ?? '-');
                                $quantite = htmlspecialchars($achat['quantite'] ?? '-');
                                $montant = isset($achat['montant']) ? number_format((float) $achat['montant'], 2) . ' Ar' : '-';
                                $date = htmlspecialchars($achat['date'] ?? '-');
                                $idVille = htmlspecialchars($achat['id_Ville'] ?? '');
                                ?>
                                <tr data-ville="<?= $idVille ?>">
                                    <td><?= $ville ?></td>
                                    <td><?= $region ?></td>
                                    <td><?= $produit ?></td>
                                    <td><?= $quantite ?></td>
                                    <td><?= $montant ?></td>
                                    <td><?= $date ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>