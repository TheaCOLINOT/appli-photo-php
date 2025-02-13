<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-6">Réinitialisation du mot de passe</h2>

  <form method="POST" action="/password-reset">
    <div class="mb-4">
      <label class="block text-gray-700">Votre Email</label>
      <input type="email" name="email" class="w-full border rounded px-3 py-2" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600">
      Envoyer le lien
    </button>
  </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
