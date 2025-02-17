<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Photos du groupe : <?= htmlspecialchars($group->name) ?></h1>

    <!-- Menu interne -->
    <nav class="mb-6">
        <?php if (Session::get('user')['id'] == $group->owner_id): ?>
            <a href="/group/<?= htmlspecialchars($group->name) ?>/manage" class="mr-4 text-blue-500 hover:underline">Membres</a>
            <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="mr-4 text-blue-500 hover:underline">Photos</a>
            <a href="/group" class="mr-4 text-blue-500 hover:underline">Groupe</a>
        <?php else: ?>
            <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="mr-4 text-blue-500 hover:underline">Photos</a>
            <a href="/group" class="mr-4 text-blue-500 hover:underline">Groupe</a>
        <?php endif; ?>
    </nav>

    <!-- Messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="mb-4 p-4 rounded <?= ($flash['type'] === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire d'upload affiché uniquement si l'utilisateur peut uploader -->
    <?php if ($canUpload): ?>
        <div class="mb-6">
            <form action="/group/<?= htmlspecialchars($group->name) ?>/upload" method="post" enctype="multipart/form-data" class="bg-gray-50 p-4 border rounded">
                <label class="block text-gray-700 mb-2">Uploader une nouvelle photo :</label>
                <input type="file" name="photo" accept="image/*" class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Uploader</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- Galerie des photos -->
    <?php if (!empty($photos)): ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($photos as $photo): ?>
                <div class="relative border rounded overflow-hidden">
                    <img src="/<?= htmlspecialchars($photo['path']) ?>"
                        alt="Photo <?= htmlspecialchars($photo['id']) ?>"
                        class="object-cover w-full h-48 cursor-pointer"
                        onclick="openModal('<?= htmlspecialchars($photo['path']) ?>')">

                    <!-- Affichage du nom et prénom du publieur -->
                    <?php
                    $u = User::findById($photo['user_id']);
                    $publisher = $u ? htmlspecialchars($u->nom . ' ' . $u->prenom) : "Inconnu";
                    ?>
                    <div class="absolute bottom-0 left-0 bg-black bg-opacity-50 text-white text-xs w-full text-center py-1">
                        <?= $publisher ?>
                    </div>

                    <!-- Boutons pour l'auteur ou le propriétaire du groupe -->
                    <?php if (Session::get('user')['id'] == $photo['user_id'] || Session::get('user')['id'] == $group->owner_id): ?>
                        <div class="absolute top-2 right-2 flex flex-col space-y-1">
                            <!-- Bouton de suppression -->
                            <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/delete" method="post" onsubmit="return confirm('Confirmer la suppression de cette photo ?');">
                                <button type="submit" class="bg-red-500 text-white text-sm px-2 py-1 rounded hover:bg-red-600">
                                    Supprimer
                                </button>
                            </form>
                            <!-- Bouton de partage public (affiché uniquement pour l'auteur) -->
                            <?php if (Session::get('user')['id'] == $photo['user_id']): ?>
                                <form action="/photo/<?= htmlspecialchars($photo['id']) ?>/share" method="post">
                                    <button type="submit" class="bg-purple-500 text-white text-sm px-2 py-1 rounded hover:bg-purple-600">
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
require __DIR__ . '/../layout.php';
?>