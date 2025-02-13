<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Créer un groupe</h1>
    <form action="/group/create" method="post" class="bg-gray-50 p-4 border rounded">
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-medium">Nom du groupe :</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2" placeholder="Nom du groupe" required>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Créer le groupe</button>
    </form>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
