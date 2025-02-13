<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
  <h1 class="text-3xl font-bold mb-6">Tableau de bord des Groupes</h1>

  <nav class="mb-6">
    <a href="/group/create" class="mr-4 text-blue-500 hover:underline">Créer un groupe</a>
    <a href="/group/my" class="mr-4 text-blue-500 hover:underline">Mes groupes</a>
  </nav>

  <?php if (!empty($myGroups)): ?>
    <ul class="list-disc pl-6">
      <?php foreach ($myGroups as $group): ?>
        <li>
          <?php if (Session::get('user')['id'] == $group['owner_id']): ?>
            <a href="/group/<?php echo htmlspecialchars($group['name']); ?>/manage" class="text-blue-500 hover:underline">
              <?php echo htmlspecialchars($group['name']); ?>
            </a>
          <?php else: ?>
            <a href="/group/<?php echo htmlspecialchars($group['name']); ?>/photos" class="text-blue-500 hover:underline">
              <?php echo htmlspecialchars($group['name']); ?>
            </a>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>

    </ul>
  <?php else: ?>
    <p>Aucun groupe trouvé.</p>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>