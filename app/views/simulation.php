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

    <div class="row">
        <div class="col-12 mb-4">
            <div class="card card-modern">
                <div class="card-body">

                    <form method="post">
                        <select name="attente" id="attente">
                            <?php foreach($achatAttente as $attente){ ?>
                                <option value="<?= $attente['id_Achat_Attente'] ?>">
                                    Produit : <?= $attente['nom_produit'] ?> - Quantité : <?= $attente['quantite'] ?> - Prix : <?= $attente['prix_total'] ?> Ar
                                </option>
                            <?php } ?>
                        </select>
                        <button type="submit" formaction="<?= $baseUrl ?>/simuler" class="btn btn-warning">Simuler</button>
                        <button type="submit" formaction="<?= $baseUrl ?>/valider" class="btn btn-success">Valider</button>
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
                    <table class="table table-striped">
                        <thead>
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
                                <?php foreach ($simulations as $sim){ ?>
                                    <tr>
                                        <td><?= $sim['nom_Besoin']?></td>
                                        <td><?= $sim['quantite_actuelle']?></td>
                                        <td><?= $sim['simulate_qte']?></td>
                                        <td><?= $sim['quantite_apres']?></td>
                                        <td><?= $sim['prix_unitaire']?> Ar</td>
                                        <td><?= $sim['prix_total']?> Ar</td>
                                    </tr>
                                <?php } ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Aucune simulation effectuée. Veuillez sélectionner une attente et cliquer sur "Simuler".
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
