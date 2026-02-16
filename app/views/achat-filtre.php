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
                                    <?= htmlspecialchars($v['nom_Ville'] ?? $v['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <input type="submit" value="Filtrer">
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
                <h5 class="card-title mb-3"><i class="bi bi-list-ul text-primary"></i> Liste des dons</h5>
                <div class="table-responsive">
                    <table id="don-table" class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Ville</th>
                                <th>Région</th>
                                <th>Produit</th>
                                <th>Montant</th>
                                <th>Quantité</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($achats as $don):
                                $ville = htmlspecialchars($don['nom_Ville'] ?? $don['ville'] ?? '-');
                                $region = htmlspecialchars($don['nom_Region'] ?? $don['region'] ?? '-');
                                $produit = htmlspecialchars($don['nom_Besoin'] ?? $don['nom_produit'] ?? '-');
                                $montant = $don['montant'] ?? $don['prix'] ?? null;
                                $montant = is_null($montant) ? '-' : number_format((float)$montant, 2) . ' Ar';
                                $quantite = htmlspecialchars($don['quantite'] ?? $don['quantite_don'] ?? '-');
                                $date = htmlspecialchars($don['date_dispatch'] ?? $don['date'] ?? '-');
                                $idVille = htmlspecialchars($don['id_Ville'] ?? $don['ville_id'] ?? $don['id_Ville'] ?? '');
                                ?>
                                <tr data-ville="<?= $idVille ?>">
                                    <td><?= $ville ?></td>
                                    <td><?= $region ?></td>
                                    <td><?= $produit ?></td>
                                    <td><?= $montant ?></td>
                                    <td><?= $quantite ?></td>
                                    <td><?= $date ?></td>
                                </tr>
                            <?php endforeach; ?>
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