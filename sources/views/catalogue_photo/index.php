<?php
<h1>Photos du groupe</h1>
<div>
    <?php foreach ($photos as $photo): ?>
        <img src="/uploads/<?= htmlspecialchars($photo['file_name']) ?>" alt="Photo" width="200">
    <?php endforeach; ?>
</div>
<a href="/groups">Retour aux groupes</a>
?>