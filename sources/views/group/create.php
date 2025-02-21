<?php ob_start(); ?>
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Créer un groupe</h1>
    <form action="/group/create" method="post" class="form">
        <div class="input--div">
            <label for="name" class="block text-gray-700 font-medium">Nom du groupe :</label>
            <input type="text" name="name" id="name" class="input  input--lg" placeholder="Nom du groupe" required>
        </div>
        <button type="submit" class="button button--sm button--primary">Créer le groupe</button>
    </form>
</div>
<?php
$content = ob_get_clean();
$title = 'Créer un groupe';
require __DIR__ . '/../layout.php';
?>