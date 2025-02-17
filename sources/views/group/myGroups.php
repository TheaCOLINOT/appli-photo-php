<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Mes Groupes</h1>

    <?php
    // Filtrer uniquement les groupes dont l'utilisateur connecté est propriétaire
    $ownerGroups = [];
    if (isset($myGroups) && count($myGroups) > 0) {
        foreach ($myGroups as $group) {
            if (Session::get('user')['id'] == $group['owner_id']) {
                $ownerGroups[] = $group;
            }
        }
    }
    ?>

    <?php if (!empty($ownerGroups)): ?>
        <ul class="list-disc pl-6">
            <?php foreach ($ownerGroups as $group): ?>
                <li class="mb-2 flex items-center">
                    <a href="/group/<?php echo htmlspecialchars($group['name']); ?>/manage" class="text-blue-500 hover:underline flex-1">
                        <?php echo htmlspecialchars($group['name']); ?>
                    </a>
                    <form action="/group/<?php echo htmlspecialchars($group['name']); ?>/delete" method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?');">
                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Supprimer</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-gray-700">Vous n'avez créé aucun groupe pour le moment.</p>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>