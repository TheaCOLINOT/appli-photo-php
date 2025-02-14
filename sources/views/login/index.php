<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-6">Connexion</h2>

  <?php if (Session::hasError('auth')): ?>
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      <?php echo Session::getError('auth'); ?>
    </div>
  <?php endif; ?>
  <figure>
    <img src="assets\scss/images/img1.jpg" alt="image présentation" class="img1">
  </figure>
  <form method="POST" action="/login">
    <div class="input">
      <label class="block text-gray-700">Email</label>
      <input type="email" name="email" class="input"
        value="<?php echo htmlspecialchars(Session::getOldInput('email')); ?>">
      <?php if (Session::hasError('email')): ?>
        <p class="text-red-500 text-sm"><?php echo Session::getError('email'); ?></p>
      <?php endif; ?>
    </div>

    <div class="input">
      <label class="block text-gray-700">Mot de passe</label>
      <input type="password" name="password" class="input">
      <?php if (Session::hasError('password')): ?>
        <p class="text-red-500 text-sm"><?php echo Session::getError('password'); ?></p>
      <?php endif; ?>
    </div>

    <div class="flex items-center justify-between mb-6">
      <button type="submit" class="button button--primary">
        Se connecter
      </button>
      <a href="/password-reset" class="button button--secondary">
        Mot de passe oublié ?
      </a>
    </div>
  </form>


  <p class="text-center text-gray-600 text-sm">
    Pas encore de compte ? <a href="/register" class="text-blue-500 hover:text-blue-700">S'inscrire</a>
  </p>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>