<?php ob_start(); ?>
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Uploader une photo</h1>
    <form action="/upload" method="post" enctype="multipart/form-data" class="bg-gray-50 p-4 border rounded">
        <label class="block text-gray-700 mb-2">Choisissez une image :</label>
        <input type="file" name="photo" accept="image/*" class="mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Uploader</button>
    </form>
</div>
<?php 
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
