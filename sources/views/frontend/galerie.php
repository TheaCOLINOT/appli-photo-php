<?php ob_start(); ?>
<?php echo 'Galerie'; ?>
<?php
$content = ob_get_clean();
$title = 'Galerie';
require __DIR__ . '/../layout.php';
?>
