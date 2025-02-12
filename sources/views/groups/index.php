<?php ob_start(); ?>

<div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold mb-6">Créer un groupe</h2>
    <form method="POST" action="/groups">
        <div class="mb-4">
            <label class="block text-gray-700">Nom du groupe</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2">
            <?php if (Session::hasError('name')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('name'); ?></p>
            <?php endif; ?>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <input type="text" name="description" class="w-full border rounded px-3 py-2">
            <?php if (Session::hasError('description')): ?>
                <p class="text-red-500 text-sm"><?php echo Session::getError('description'); ?></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="w-full bg-blue-500 text-white rounded py-2 px-4 hover:bg-blue-600">
                Créer
        </button>
    </form>
</div>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>