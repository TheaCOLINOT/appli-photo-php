<!DOCTYPE html>
<html lang="fr" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site</title>
    <link rel="stylesheet" href="/dist/framework-esgi.css">

</head>

<body>
    <header class="header">
        <nav class="nav">
            <div class="nav__container">

                <ul class="nav__menu">
                    <li class="nav__item">
                        <a href="/" class="nav__link">Accueil</a>
                    </li>
                    <li class="nav__item">
                        <a href="/" class="nav__link">Galerie</a>
                    </li>
                    <?php if (!Session::get('user')): ?>
                        <li class="nav__item">
                            <a href="/login" class="nav__link">Connexion</a>
                        </li>
                        <li class="nav__item">
                            <a href="/register" class="nav__link">Inscription</a>
                        </li>
                    <?php else: ?>
                        <li class="nav__item">
                            <a href="/upload/manage" class="nav__link">Mes photos</a>
                        </li>
                        <li class="nav__item">
                            <a href="/group" class="nav__link">Groupe</a>
                        </li>
                        <li class="nav__item">
                            <span class="nav__user">Bienvenue, <?php echo htmlspecialchars(Session::get('user')['prenom']); ?></span>
                        </li>
                        <li class="nav__item">
                            <a href="/logout" class="nav__link">Déconnexion</a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </nav>
    </header>

    <main class="container">
        <?php if ($flash = Session::getFlash()): ?>
            <div class="flash-message <?php echo ($flash['type'] === 'success') ? 'flash-success' : 'flash-error'; ?>">
                <?php echo htmlspecialchars($flash['message']); ?>
            </div>
        <?php endif; ?>
        <?php echo $content ?? ''; ?>
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 MonSite. Tous droits réservés.</p>
        </div>
    </footer>

</body>

</html>