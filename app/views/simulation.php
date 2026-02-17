<?php
ob_start();
$page_title = 'BNGRC - Liste des besoins par ville';
$baseUrl = $baseUrl ?? '';
?>

<div class="row">
    <div class="col-12 mb-4">
        <div class="card card-modern">
            <div class="card-body">
                <h4 class="card-title mb-2">
                    <i class="bi bi-list-check text-primary"></i> Simulation d'achat
                </h4>
                <h5 class="text-primary">Simulation de l'achat des besoins</h5>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center mb-4">
    <div class="col-lg-8">
        <div class="card card-modern">
            <div class="card-body p-4">
                <h4 class="card-title mb-3">
                    <i class="bi bi-activity text-primary"></i> Simuler une attente
                </h4>

                <form method="post">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label for="attente" class="form-label fw-semibold">
                                <i class="bi bi-box-seam"></i> Attente d'achat
                            </label>
                            <select name="attente" id="attente" class="form-select form-select-lg" required>
                                <option value="">Sélectionnez une attente...</option>
                                <?php foreach ($achatAttente as $attente) { ?>
                                    <option value="<?= $attente['id_Achat_Attente'] ?>">
                                        Produit : <?= htmlspecialchars($attente['nom_produit']) ?> - Quantité :
                                        <?= htmlspecialchars($attente['quantite']) ?> - Prix :
                                        <?= htmlspecialchars($attente['prix_total']) ?> Ar
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" formaction="<?= $baseUrl ?>/simuler"
                                class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-activity"></i> Simuler
                            </button>
                            <button type="submit" formaction="<?= $baseUrl ?>/valider"
                                class="btn btn-secondary btn-lg w-100">
                                <i class="bi bi-currency-dollar"></i> Valider
                            </button>
                        </div>
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
                <h5 class="card-title mb-3">
                    <i class="bi bi-currency-dollar text-primary"></i> Résultats de la simulation
                </h5>
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Produit</th>
                                <th scope="col">Quantité initiale</th>
                                <th scope="col">Quantité simulée</th>
                                <th scope="col">Quantité restante</th>
                                <th scope="col">Prix unitaire</th>
                                <th scope="col">Prix total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($simulations ?? [])): ?>
                                <?php foreach ($simulations as $sim) { ?>
                                    <tr>
                                        <td><?= htmlspecialchars($sim['nom_Besoin']) ?></td>
                                        <td><?= htmlspecialchars($sim['quantite_actuelle']) ?></td>
                                        <td><?= htmlspecialchars($sim['simulate_qte']) ?></td>
                                        <td><?= htmlspecialchars($sim['quantite_apres']) ?></td>
                                        <td><?= htmlspecialchars($sim['prix_unitaire']) ?> Ar</td>
                                        <td><?= htmlspecialchars($sim['prix_total']) ?> Ar</td>
                                    </tr>
                                <?php } ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Aucune simulation effectuée. Veuillez sélectionner une attente et cliquer sur
                                        "Simuler".
                                    </td>
                                </tr>
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