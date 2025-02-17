<?php ob_start(); ?>
<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Inscription</h2>
    <form method="POST" action="/register">
        <div class="mb-4">
            <label class="block text-gray-700">Nom</label>
            <input type="text" name="nom" class="w-full border rounded px-3 py-2" 
                   value="<?php echo htmlspecialchars(Session::getOldInput('nom')); ?>">
            <?php if (Session::hasError('nom')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('nom'); ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Prénom</label>
            <input type="text" name="prenom" class="w-full border rounded px-3 py-2" 
                   value="<?php echo htmlspecialchars(Session::getOldInput('prenom')); ?>">
            <?php if (Session::hasError('prenom')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('prenom'); ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Email</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" 
                   value="<?php echo htmlspecialchars(Session::getOldInput('email')); ?>">
            <?php if (Session::hasError('email')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('email'); ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Mot de passe</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
            <?php if (Session::hasError('password')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('password'); ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            <?php if (Session::hasError('password_confirmation')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('password_confirmation'); ?></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600">
            S'inscrire
        </button>
    </form>
    <p class="mt-4 text-center text-gray-600 text-sm">
        Déjà inscrit ? <a href="/login" class="text-blue-500 hover:text-blue-700">Se connecter</a>
    </p>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
