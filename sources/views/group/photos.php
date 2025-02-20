<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Photos du groupe : <?= htmlspecialchars($group->name) ?></h1>

<!-- Menu interne -->

<?php include_once __DIR__ . '/../layout/nav_group.php' ?>



    <!-- Messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="mb-4 p-4 rounded <?= ($flash['type'] === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'upload affiché uniquement si l'utilisateur peut uploader -->
    <?php if ($canUpload): ?>
        <div class="container mx-auto px-4 py-6 mb-8">
            <h1 class="text-3xl font-bold mb-6">Uploader une photo</h1>

            <form action="/group/<?= htmlspecialchars($group->name) ?>/upload" method="post" enctype="multipart/form-data" class="bg-gray-50 p-4 border rounded">
                <label class="block text-gray-700 mb-2">Choisissez une image :</label>
                <input type="file" name="photo" accept="image/*" class="input">

                <button type="submit" class="button button--primary button--lg">Uploader</button>
            </form>
        </div>
    <?php endif; ?>


    <!-- Galerie des photos -->
    <?php if (!empty($photos)): ?>
        <div class="group-gallery">
            <?php foreach ($photos as $photo): ?>
                <div class="group-gallery__item">
                    <img src="/<?= htmlspecialchars($photo['path']) ?>"
                        alt="Photo <?= htmlspecialchars($photo['id']) ?>"
                        onclick="openModal('<?= htmlspecialchars($photo['path']) ?>')">

                    <!-- Affichage du nom et prénom du publieur -->
                    <?php
                    $u = User::findById($photo['user_id']);
                    $publisher = $u ? htmlspecialchars($u->nom . ' ' . $u->prenom) : "Inconnu";
                    ?>
                    <div class="publisher">
                        <?= $publisher ?>
                    </div>

                    <!-- Boutons pour l'auteur ou le propriétaire du groupe -->
                    <?php if (Session::get('user')['id'] == $photo['user_id'] || Session::get('user')['id'] == $group->owner_id): ?>
                        <div class="btn-group">
                            <!-- Bouton de suppression -->
                            <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/delete" method="post"
                                onsubmit="return confirm('Confirmer la suppression de cette photo ?');">
                                <button type="submit" class="delete-btn">
                                    Supprimer
                                </button>
                            </form>
                            <!-- Bouton de partage public (affiché uniquement pour l'auteur) -->
                            <?php if (Session::get('user')['id'] == $photo['user_id']): ?>
                                <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/share" method="post">
                                    <button type="submit" class="share-btn">
                                        Partager publiquement
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-gray-700">Aucune photo n'a encore été uploadée dans ce groupe.</p>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
$title = 'Photos du groupe : ' . htmlspecialchars($group->name);
require __DIR__ . '/../layout.php';
?>
