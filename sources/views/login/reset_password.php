<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="title">Nouveau mot de passe</h2>

  <form class="form--md" method="POST" action="/reset-password">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <div class="input--div">
      <label class="input--label">Nouveau mot de passe</label>
      <input type="password" name="password" class="input input--lg" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600">
      Réinitialiser le mot de passe
    </button>
  </form>
</div>
<?php
$content = ob_get_clean();
$title = "Nouveau mot de passe";
require __DIR__ . '/../layout.php';
?>