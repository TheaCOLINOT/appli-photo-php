<?php ob_start(); ?>
<div class="container">
    <h1>Gérer le groupe : <?= htmlspecialchars($group->name) ?></h1>
    
    <!-- Menu interne -->
    <?php include_once __DIR__ . '/../layout/nav_group.php'; ?>

    <!-- Messages flash -->
    <?php if ($flash = Session::getFlash()): ?>
        <div class="flash <?= ($flash['type'] === 'success') ? 'flash--success' : 'flash--error'; ?>">
            <?= htmlspecialchars($flash['message']) ?>
        </div>
    <?php endif; ?>
    
    <!-- Tableau des membres -->
    <h2>Membres du groupe</h2>
    <?php if (!empty($members)): ?>
        <!-- Wrapper responsive pour le tableau -->
        <div class="table-wrapper">
          <table class="table">
              <thead>
                  <tr>
                      <th>Nom</th>
                      <th>Email</th>
                      <th>Rôle</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($members as $member): ?>
                      <?php $user = User::findById($member['user_id']); ?>
                      <tr>
                          <td><?= htmlspecialchars($user ? $user->nom . ' ' . $user->prenom : 'Utilisateur inconnu') ?></td>
                          <td><?= htmlspecialchars($user ? $user->email : '') ?></td>
                          <td><?= htmlspecialchars($member['role']) ?></td>
                          <td>
                              <div class="table__actions">
                                  <?php if (Session::get('user')['id'] === $group->owner_id && $member['user_id'] != $group->owner_id): ?>
                                      <!-- Formulaire pour modifier le rôle -->
                                      <form action="/groups/update-member/<?= htmlspecialchars($group->name) ?>/<?= htmlspecialchars($member['user_id']) ?>" method="post" style="display:inline-block;">
                                          <select name="role">
                                              <option value="read" <?= ($member['role'] === 'read') ? 'selected' : '' ?>>Lecteur</option>
                                              <option value="write" <?= ($member['role'] === 'write') ? 'selected' : '' ?>>Éditeur</option>
                                          </select>
                                          <button type="submit" class="btn btn--blue">Modifier</button>
                                      </form>
                                      <!-- Formulaire pour supprimer le membre -->
                                      <form action="/groups/remove-member/<?= htmlspecialchars($group->name) ?>/<?= htmlspecialchars($member['user_id']) ?>" method="post" style="display:inline-block;" onsubmit="return confirm('Confirmer la suppression de ce membre ?');">
                                          <button type="submit" class="btn btn--red">Supprimer</button>
                                      </form>
                                  <?php else: ?>
                                      <span>Aucune action</span>
                                  <?php endif; ?>
                              </div>
                          </td>
                      </tr>
                  <?php endforeach; ?>
              </tbody>
          </table>
        </div>
    <?php else: ?>
        <p>Aucun membre dans le groupe.</p>
    <?php endif; ?>
    
    <!-- Formulaire pour ajouter un membre via liste déroulante -->
    <?php if (Session::get('user')['id'] === $group->owner_id): ?>
        <h3>Ajouter un membre</h3>
        <form action="/groups/add-member/<?= htmlspecialchars($group->name) ?>" method="post" class="form">
            <div>
                <label for="user_email">Ajouter un utilisateur :</label>
                <input type="text" name="user_email" id="user_email" placeholder="Email" required>
            </div>
            <div>
                <label class="input--label" for="role">Rôle :</label>
                <select name="role" id="role">
                    <option value="read">Lecteur (voir seulement)</option>
                    <option value="write">Éditeur (uploader et voir)</option>
                </select>
            </div>
            <button type="submit" class="button--sm button--primary">Ajouter le membre</button>
        </form>
    <?php endif; ?>
</div>
<?php 
$content = ob_get_clean();
$title = 'Gérer le groupe : ' . htmlspecialchars($group->name);
require __DIR__ . '/../layout.php';
?>
