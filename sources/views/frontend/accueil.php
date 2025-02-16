<?php ob_start(); ?>

    <section>

        <div
            class="banner banner--text"
            style="background-image: url('./dist/banner.jpg')">
            <!-- <h1 class="banner__title">Bienvenue sur Phphoto</h1> -->
            <div class="banner__content">
                <h1>Bienvenue sur <span>Phphoto</span></h1>
                <p>Votre premier Application de photo Grouper partager entre amis et famille</p>	
                <a href="/login" class="mr-4 button button--primary">
            Connectez-vous !
        </a>
            </div>
        </div>
    </section>

<?php
$content = ob_get_clean();
$title = 'Accueil';
require __DIR__ . '/../layout.php';
?>
