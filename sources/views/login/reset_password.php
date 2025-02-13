<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-6">Nouveau mot de passe</h2>

  <form method="POST" action="/reset-password">
    <input type="hidden" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
    <div class="mb-4">
      <label class="block text-gray-700">Nouveau mot de passe</label>
      <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600">
      Réinitialiser le mot de passe
    </button>
  </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>