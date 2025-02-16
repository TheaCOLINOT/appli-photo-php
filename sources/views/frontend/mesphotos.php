<?php ob_start(); ?>
<section>

            <h1>Mes Photos</h1>
            <p>Retrouvez toutes vos photos ici</p>
</section>

<?php
$content = ob_get_clean();
$title = 'Mes Photos';
require __DIR__ . '/../layout.php';
?>
