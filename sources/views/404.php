<!-- /views/404.php -->
<?php 
$title = 'Page non trouvée';
$content = '
<div class="flex flex-col items-center justify-center min-h-[400px]">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">404 - Page non trouvée</h1>
    <p class="text-gray-600 mb-6">La page que vous recherchez n\'existe pas.</p>
    <a href="/" class="text-blue-500 hover:text-blue-600">Retour à l\'accueil</a>
</div>
';

// Utiliser un chemin absolu basé sur __DIR__
require_once __DIR__ . '/layout.php';
?>