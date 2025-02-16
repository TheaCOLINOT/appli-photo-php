<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Inscription</h2>

    <div class="form form--div">
        <img src="/public/img1.jpg" alt="image présentation" class="image image--md image--square">
        <form class="form--md" method="POST" action="/register">
            <div class="input--div">
                <label class="input--label">Nom</label>
                <input type="text" name="nom" class="input input--lg" 
                    value="<?php echo htmlspecialchars(Session::getOldInput('nom')); ?>">
                <?php if (Session::hasError('nom')): ?>
                    <p class="text-red-500 text-sm"><?php echo Session::getError('nom'); ?></p>
                <?php endif; ?>
            </div>
            <div class="input--div">
                <label class="input--label">Prénom</label>
                <input type="text" name="prenom" class="input input--lg" 
                    value="<?php echo htmlspecialchars(Session::getOldInput('prenom')); ?>">
                <?php if (Session::hasError('prenom')): ?>
                    <p class="text-red-500 text-sm"><?php echo Session::getError('prenom'); ?></p>
                <?php endif; ?>
            </div>
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
            <div class="input--div">
                <label class="input--label">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" class="input input--lg">
                <?php if (Session::hasError('password_confirmation')): ?>
                    <p class="text-red-500 text-sm"><?php echo Session::getError('password_confirmation'); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="button button--primary">
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
require __DIR__ . '/../layout.php';
?>
