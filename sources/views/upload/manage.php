<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Mes photos</h1>

    <!-- Lien ou bouton pour ajouter une nouvelle photo -->

    <div class="container mx-auto px-4 py-6 mb-8">
            <form action="/upload" method="post" enctype="multipart/form-data" class="form">
                <label class="block text-gray-700 mb-2">Choisissez une image :</label>
                <input type="file" name="photo" accept="image/*" class="input">

                <button type="submit" class="button button--primary button--lg">Ajouter une photo</button>
            </form>
        </div>
 

    <!-- Affichage des messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="mb-4 p-4 rounded <?php echo ($flash['type'] === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Affichage de la galerie de photos -->
    <?php if (!empty($photos)): ?>
        <div class="group-gallery">
            <?php foreach ($photos as $photo): ?>
                <div class="group-gallery__item">
                    <img src="/<?= htmlspecialchars($photo['path']) ?>"
                        alt="Photo <?= htmlspecialchars($photo['id']) ?>"
                        onclick="openModal('<?= htmlspecialchars($photo['path']) ?>')">

                    <?php if (Session::get('user')['id'] == $photo['user_id'] || Session::get('user')['id'] == $group->owner_id): ?>
                        <div class="btn-group">
                            <!-- Bouton de suppression -->
                            <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/delete" method="post"
                                onsubmit="return confirm('Confirmer la suppression de cette photo ?');">
                                <button type="submit" class="delete-btn">
                                    Supprimer
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>


                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-700">Aucune photo uploadée pour le moment.</p>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>