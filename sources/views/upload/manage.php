<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Mes photos</h1>

    <!-- Lien ou bouton pour ajouter une nouvelle photo -->
    <div class="mb-6">
        <form action="/upload" class="nav__item">
            <button class="button button--primary button--lg">Ajouter une photo</button>
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
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($photos as $photo): ?>
                <div class="relative border rounded overflow-hidden">
                    <img src="/<?= htmlspecialchars($photo['path']) ?>"
                        alt="Photo <?= htmlspecialchars($photo['id']) ?>"
                        class="object-cover w-full h-48 cursor-pointer"
                        onclick="openModal('<?= htmlspecialchars($photo['path']) ?>')">
                    <!-- Bouton de suppression visible si l'utilisateur est propriétaire de la photo -->
                    <?php if (Session::get('user')['id'] == $photo['user_id']): ?>
                        <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/delete" method="post" class="absolute top-2 right-2" onsubmit="return confirm('Confirmer la suppression de cette photo ?');">
                            <button type="submit" class="bg-red-500 text-white text-sm px-2 py-1 rounded hover:bg-red-600">
                                Supprimer
                            </button>
                        </form>
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