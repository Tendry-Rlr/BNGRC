<?php
ob_start();
$page_title = 'BNGRC - Don';
$baseUrl = $baseUrl ?? '';
?>

<a href=""></a>

<form action="">
    
    <p>
        <select class="form-select w-50 " name="dons" id="dons-select">
            <option value="">Donnez...</option>
            <option value="argent">Argent</option>
            <option value="nourriture">Nourriture</option>
        </select>

        <button type="submit" class="btn btn-success mt-3">Faire un don</button>

    </p>
    
    <table>
        <tr>
            <th>Dons</th>
            <th>Prix Uniitaire</th>
            <th>Quantite</th>
        </tr>
    </table>

</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
