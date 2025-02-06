<?php require 'views/layout/header.php'; ?>

<h2>Photos du Groupe</h2>

<?php if (empty($photos)): ?>
    <p>Aucune photo disponible pour ce groupe.</p>
<?php else: ?>
    <div class="photo-grid">
        <?php foreach ($photos as $photo): ?>
            <div class="photo-item">
                <img src="/uploads/<?= htmlspecialchars($photo['filename']) ?>" alt="Photo">
                <p>Ajouté par : <?= htmlspecialchars($photo['user_id']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require 'views/layout/footer.php'; ?>
