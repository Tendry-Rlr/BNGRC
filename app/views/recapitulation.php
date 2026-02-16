<?php
ob_start();
$page_title = 'BNGRC - Recapitulatifs';
$baseUrl = $baseUrl ?? '';
?>



<?php
$content = ob_get_clean();
include __DIR__ . '/layout.php';
?>
