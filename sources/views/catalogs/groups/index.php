<?php ob_start(); ?>

<h1>Mes Groupes</h1>
<ul>
    <?php foreach ($groups as $group): ?>
        <li>
            <a href="/group/<?= $group['id'] ?>/photos"><?= htmlspecialchars($group['name']) ?></a>
        </li>
    <?php endforeach; ?>
</ul>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
