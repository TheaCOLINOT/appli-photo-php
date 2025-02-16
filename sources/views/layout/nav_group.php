<nav class="mb-6 flex items-center justify-between">
    <?php if (Session::get('user')['id'] == $group->owner_id): ?>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/manage" class="mr-4 button button--primary">
            Membres
        </a>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="mr-4 button button--primary">
            Photos
        </a>
        <a href="/group" class="mr-4 button button--primary">
            Groupe
        </a>
    <?php else: ?>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="mr-4 button button--primary">
            Photos
        </a>
        <a href="/group" class="mr-4 button button--primary">
            Groupe
        </a>
    <?php endif; ?>
</nav>