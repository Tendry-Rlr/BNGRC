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
        <div class="col-12">
            <div class="card card-modern">
                <div class="card-body">
                    <form action="">

                        <p>Ville
                            <select name="ville" id="ville">
                                <option value="">Sélectionnez une ville</option>
                                <option value="1">Ville 1</option>
                                <option value="2">Ville 2</option>
                            </select>
                        </p>

                        <p>
                            Produit
                            <select name="produit" id="produit">
                                <option value="">Sélectionnez un produit</option>
                                <option value="1">Produit 1</option>
                                <option value="2">Produit 2</option>    
                            </select>
                        </p>

                        <p>
                            Quantité
                            <input type="number" name="quantite" id="quantite" min="1" value="1">
                        </p>

                        <button class="btn btn-warning">Simuler</button>
                        <button class="btn btn-success">Valider</button>

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
                </div>
            </div>
        </div>
    </div>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
