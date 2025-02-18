<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-6">Réinitialisation du mot de passe</h2>

  <form class="form--md" method="POST" action="/password-reset">
    <div class="input--div">
      <label class="input--label">Votre Email</label>
      <input type="email" name="email" class="input input--lg" required>
    </div>

    <button type="submit" class="button button--primary">
      Envoyer le lien
    </button>
  </form>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
