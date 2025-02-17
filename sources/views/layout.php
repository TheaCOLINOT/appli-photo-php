<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Application</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg mb-8">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="flex space-x-4">
                    <a href="/" class="py-4 px-2 hover:text-blue-500">Accueil</a>
                    <?php if (!Session::get('user')): ?>
                        <a href="/login" class="py-4 px-2 hover:text-blue-500">Connexion</a>
                        <a href="/register" class="py-4 px-2 hover:text-blue-500">Inscription</a>
                    <?php else: ?>
                        <a href="/upload/manage" class="py-4 px-2 hover:text-blue-500">Mes photos</a>
                        <a href="/group" class="py-4 px-2 hover:text-blue-500">Groupe</a>
                    <?php endif; ?>
                </div>
                <?php if (Session::get('user')): ?>
                    <div class="flex items-center space-x-4">
                        <span class="py-4 px-2">Bienvenue, <?php echo htmlspecialchars(Session::get('user')['prenom']); ?></span>
                        <a href="/logout" class="py-4 px-2 hover:text-blue-500">Déconnexion</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="container mx-auto px-4">
        <?php if ($flash = Session::getFlash()): ?>
            <div class="mb-4 p-4 rounded <?php echo ($flash['type'] === 'success') ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        <?php echo $content ?? ''; ?>
    </div>
</body>
</html>
