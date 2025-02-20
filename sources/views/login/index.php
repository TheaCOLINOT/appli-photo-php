<?php ob_start(); ?>
<section >
  <div class="container ">
    <h2 class="title">Connexion</h2>

    <?php if (Session::hasError('auth')): ?>
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <?php echo Session::getError('auth'); ?>
      </div>
    <?php endif; ?>
    <div class="grid ">
      <div class="col-lg-6 col-md-6 image col-xl-6 col-xxl-6" >
         <img src="/public/img1.jpg" alt="image  présentation" class="image   image--md image--square">
      </div>
      <form  method="POST"  class="form col-lg-6 col-md-6 col-12 col-xxl-6"  action="/login">
        <div class="input--div">
          <label class="input--label">Email</label>
          <input type="email" name="email" class="input  input--lg"
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

        <div class="form--footer">
          <button type="submit" class="button--sm button--primary">
            Se connecter
          </button>
          <a href="/password-reset" class="button button--sm button--secondary">
            Mot de passe oublié ?
          </a>
        </div>
        <p class="text-center text-gray-600 text-sm">
          Pas encore de compte ? <a href="/register" class="text-blue-500 hover:text-blue-700">S'inscrire</a>
        </p>
      </form>
    </div>
  </div>
</section>

<?php
$content = ob_get_clean();
$title = "Connexion";
require __DIR__ . '/../layout.php';
?>