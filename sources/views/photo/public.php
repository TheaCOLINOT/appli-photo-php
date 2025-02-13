<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Photo partagée publiquement</h1>
    <img src="/<?= htmlspecialchars($photo['path']) ?>" alt="Photo partagée" class="max-w-full mx-auto">
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
