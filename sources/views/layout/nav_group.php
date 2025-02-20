<nav class="container">
    <?php if (Session::get('user')['id'] == $group->owner_id): ?>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/manage" class="button button--primary">
            Membres
        </a>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="button button--primary">
            Photos
        </a>
        <a href="/group" class="button button--primary">
            Groupe
        </a>
    <?php else: ?>
        <a href="/group/<?= htmlspecialchars($group->name) ?>/photos" class="button button--primary">
            Photos
        </a>
        <a href="/group" class="button button--primary">
            Groupe
        </a>
    <?php endif; ?>
</nav>