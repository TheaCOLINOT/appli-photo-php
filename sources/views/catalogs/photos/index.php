<?php ob_start(); ?>

<h1>Photos du groupe</h1>
<div>
    <?php foreach ($photos as $photo): ?>
        <img src="/<?= htmlspecialchars($photo['path']) ?>" alt="Photo" width="200">
    <?php endforeach; ?>
</div>
<a href="/groups">Retour aux groupes</a>


<?php
$content = ob_get_clean();
require __DIR__ . '/../../layout.php';
?>