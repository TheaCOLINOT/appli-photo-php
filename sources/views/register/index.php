<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="title">Inscription</h2>

    <div class="grid">
       <div class="col-lg-6 col-md-6 image col-xl-6 col-xxl-6" >
            <img src="/public/img1.jpg" alt="image présentation" class="image image--md image--square">
        </div>

        <form  method="POST" class=" col-lg-6 col-md-6 col-12 col-xxl-6"  action="/register">
            <div class="input--div">
                <label class="input--label">Nom</label>
                <input type="text" name="nom" class="input input--lg" 
                    value="<?php echo htmlspecialchars(Session::getOldInput('nom')); ?>">
                <?php if (Session::hasError('nom')): ?>
                    <p ><?php echo Session::getError('nom'); ?></p>
                <?php endif; ?>
            </div>
            <div class="input--div">
                <label class="input--label">Prénom</label>
                <input type="text" name="prenom" class="input input--lg" 
                    value="<?php echo htmlspecialchars(Session::getOldInput('prenom')); ?>">
                <?php if (Session::hasError('prenom')): ?>
                    <p ><?php echo Session::getError('prenom'); ?></p>
                <?php endif; ?>
            </div>
            <div class="input--div">
                <label class="input--label">Email</label>
                <input type="email" name="email" class="input input--lg" 
                    value="<?php echo htmlspecialchars(Session::getOldInput('email')); ?>">
                <?php if (Session::hasError('email')): ?>
                    <p ><?php echo Session::getError('email'); ?></p>
                <?php endif; ?>
            </div>
            <div class="input--div">
                <label class="input--label">Mot de passe</label>
                <input type="password" name="password" class="input input--lg">
                <?php if (Session::hasError('password')): ?>
                    <p ><?php echo Session::getError('password'); ?></p>
                <?php endif; ?>
            </div>
            <div class="input--div">
                <label class="input--label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="input input--lg">
                <?php if (Session::hasError('password_confirmation')): ?>
                    <p ><?php echo Session::getError('password_confirmation'); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="button button--sm button--primary">
                S'inscrire
            </button>
            <p class="mt-4 text-center text-gray-600 text-sm">
                Déjà inscrit ? <a href="/login" class="text-blue-500 hover:text-blue-700">Se connecter</a>
            </p>
        </form>
    </div>
</div>
<?php 
$content = ob_get_clean();
$title = "Inscription";
require __DIR__ . '/../layout.php';
?>
