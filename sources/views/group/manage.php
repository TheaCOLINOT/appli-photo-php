<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Gérer le groupe : <?= htmlspecialchars($group->name) ?></h1>
    
    <!-- Menu interne -->
    <nav class="mb-6">
        <a href="/group/<?= htmlspecialchars($group->name) ?>/manage" class="mr-4 text-blue-500 hover:underline">Membres</a>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="mr-4 text-blue-500 hover:underline">Photos</a>
        <a href="/group" class="mr-4 text-blue-500 hover:underline">Groupe</a>
    </nav>
    
    <!-- Messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="mb-4 p-4 rounded <?php echo ($flash['type'] === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>
    
    <!-- Tableau des membres -->
    <h2 class="text-2xl font-semibold mb-4">Membres du groupe</h2>
    <?php if (!empty($members)): ?>
        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">Nom</th>
                    <th class="py-2 px-4 border">Email</th>
                    <th class="py-2 px-4 border">Rôle</th>
                    <th class="py-2 px-4 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($members as $member): ?>
                    <?php $user = User::findById($member['user_id']); ?>
                    <tr>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($user ? $user->nom . ' ' . $user->prenom : 'Utilisateur inconnu') ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($user ? $user->email : '') ?></td>
                        <td class="py-2 px-4 border"><?= htmlspecialchars($member['role']) ?></td>
                        <td class="py-2 px-4 border">
                            <?php if (Session::get('user')['id'] === $group->owner_id && $member['user_id'] != $group->owner_id): ?>
                                <!-- Formulaire pour modifier le rôle -->
                                <form action="/groups/update-member/<?= htmlspecialchars($group->name) ?>/<?= htmlspecialchars($member['user_id']) ?>" method="post" class="inline-block mr-2">
                                    <select name="role" class="border rounded px-2 py-1">
                                        <option value="read" <?= ($member['role'] === 'read') ? 'selected' : '' ?>>Lecteur</option>
                                        <option value="write" <?= ($member['role'] === 'write') ? 'selected' : '' ?>>Éditeur</option>
                                    </select>
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600">Modifier</button>
                                </form>
                                <!-- Formulaire pour supprimer le membre -->
                                <form action="/groups/remove-member/<?= htmlspecialchars($group->name) ?>/<?= htmlspecialchars($member['user_id']) ?>" method="post" class="inline-block" onsubmit="return confirm('Confirmer la suppression de ce membre ?');">
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                                </form>
                            <?php else: ?>
                                <span class="text-gray-600">Aucune action</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-gray-700">Aucun membre dans le groupe.</p>
    <?php endif; ?>
    
    <!-- Formulaire pour ajouter un membre via liste déroulante -->
    <?php if (Session::get('user')['id'] === $group->owner_id): ?>
        <h3 class="text-2xl font-semibold mt-8 mb-4">Ajouter un membre</h3>
        <form action="/groups/add-member/<?= htmlspecialchars($group->name) ?>" method="post" class="bg-gray-50 p-4 border rounded">
            <div class="mb-4">
                <label for="user_email" class="block text-gray-700 font-medium">Ajouter un utilisateur :</label>
                <input type="text" name="user_email" id="name" class="w-full border rounded px-3 py-2" placeholder="Email" required>
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700 font-medium">Rôle :</label>
                <select name="role" id="role" class="w-full border rounded px-3 py-2">
                    <option value="read">Lecteur (voir seulement)</option>
                    <option value="write">Éditeur (uploader et voir)</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Ajouter le membre
            </button>
        </form>
    <?php endif; ?>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
