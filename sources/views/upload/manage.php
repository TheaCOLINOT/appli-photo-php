<?php ob_start(); ?>
<div class="container">
    <h1 class="title">Mes photos</h1>

    <!-- Zone de formulaire pour uploader une photo -->
    <div class="container">
        <form action="/upload" method="post" enctype="multipart/form-data" class="form">
            <label class="label">Choisissez une image :</label>
            <input type="file" name="photo" accept="image/*" class="input">
            <button type="submit" class="button button--primary button--lg">Ajouter une photo</button>
        </form>
    </div>

    <!-- Affichage des messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="flash <?php echo ($flash['type'] === 'success') ? 'flash--success' : 'flash--error'; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Galerie de photos -->
    <?php if (!empty($photos)): ?>
        <div class="group-gallery">
            <?php foreach ($photos as $photo): ?>
                <div class="group-gallery__item">
                    <img src="/<?= htmlspecialchars($photo['path']) ?>"
                        alt="Photo <?= htmlspecialchars($photo['id']) ?>"
                        onclick="openModal('<?= htmlspecialchars($photo['path']) ?>')">
                    <?php if (Session::get('user')['id'] == $photo['user_id'] || Session::get('user')['id'] == $group->owner_id): ?>
                        <div class="btn-group">
                            <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/delete" method="post" onsubmit="return confirm('Confirmer la suppression de cette photo ?');">
                                <button type="submit" class="delete-btn">Supprimer</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-photos">Aucune photo uploadée pour le moment.</p>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$title = 'Mes photos';
require __DIR__ . '/../layout.php';
?>