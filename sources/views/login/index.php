<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
  <h2 class="text-2xl font-bold mb-6">Connexion</h2>

  <?php if (Session::hasError('auth')): ?>
    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
      <?php echo Session::getError('auth'); ?>
    </div>
  <?php endif; ?>
  <div class="form form--div">
    <img src="/public/img1.jpg" alt="image présentation" class="image image--md image--square">
    <form class="form--md" method="POST" action="/login">

      <div class="input--div">
        <label class="input--label">Email</label>
        <input type="email" name="email" class="input input--lg"
          value="<?php echo htmlspecialchars(Session::getOldInput('email')); ?>">
        <?php if (Session::hasError('email')): ?>
          <p class="text-red-500 text-sm"><?php echo Session::getError('email'); ?></p>
        <?php endif; ?>
      </div>

      <div class="input--div">
        <label class="input--label">Mot de passe</label>
        <input type="password" name="password" class="input input--lg">
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
      <p class="text-center text-gray-600 text-sm">
        Pas encore de compte ? <a href="/register" class="text-blue-500 hover:text-blue-700">S'inscrire</a>
      </p>
    </form>
    
  </div>


  
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>