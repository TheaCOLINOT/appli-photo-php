<?php ob_start(); ?>

<!-- SECTION Bannière -->
<section>
    <div class="banner banner--text" style="background-image: url('./dist/banner.jpg')">
        <div class="banner__content">
            <h1>Bienvenue sur <span>Phphoto</span></h1>
            <p>Votre première application de photos à partager entre amis et en famille</p>
            <form action="/login" method="GET">
                <button class="button button--primary">Rechercher</button>
            </form>
        </div>
    </div>
</section>

<!-- SECTION À propos -->
<section>
    <h2 class="title">À propos</h2>
    <div class="apropos container">
        <div class="apropos--item grid">
            <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                <p>
                    Votre première Application de photo Grouper partager entre amis, etc...
                </p>
                <a href="/login">En savoir plus</a>
            </div>
            <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6">
                <img src="/public/image1.png" class="image image--md" alt="image présentation">
            </div>
        </div>

        <div class="apropos--item--revers grid">
            <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                <p>
                    Votre première Application de photo Grouper partager entre amis, etc...
                </p>
                <a href="/login">En savoir plus</a>
            </div>
            <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6">
                <img src="/public/image2.png" class="image image--md" alt="image présentation">
            </div>
        </div>

        <div class="apropos--item grid">
            <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                <p>
                    Votre première Application de photo Grouper partager entre amis, etc...
                </p>
                <a href="/login">En savoir plus</a>
            </div>
            <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6">
                <img src="/public/image3.png" class="image image--md" alt="image présentation">
            </div>
        </div>
    </div>
</section>

<!-- SECTION Catégories -->
<section class="categories container">
    <h2 class="categories__title">Categories</h2>
    <div class="grid">

        <!-- Carte 1 : THEA -->
        <div class="card col-lg-6 col-md-4 col-12 col-xxl-4">
            <span class="card__label">CATEGORY</span>
            <span class="card__project">PROJECT 20XX</span>
            <span class="card__title">THEA-COFOUNDER</span>
            <p class="card__description">
                ART est une entreprise de création de rêves, voyages & d’achats internationaux
                de biens d’art, un ensemble de personnes pour porter la création à travers
                un ensemble de regards. Culture, c’est la base de tout,
                nous partageons nos cultures à travers les voyages.
            </p>
            <img src="/public/imageCategorie1.png" alt="Thea" class="card__img" />
        </div>

        <!-- Carte 2 : MARIAM -->
        <div class="card col-lg-6 col-md-4 col-12 col-xxl-4">
            <span class="card__label">CATEGORY</span>
            <span class="card__project">PROJECT 20XX</span>
            <span class="card__title">MARIAM-COFOUNDER</span>
            <p class="card__description">
                ART est une entreprise de création de rêves, voyages & d’achats internationaux
                de biens d’art, un ensemble de personnes pour porter la création à travers
                un ensemble de regards. Culture, c’est la base de tout,
                nous partageons nos cultures à travers les voyages.
            </p>
            <img src="/public/imageCategorie2.png" alt="Mariam" class="card__img" />
        </div>

        <!-- Carte 3 : JOEL -->
        <div class="card col-lg-6 col-md-4 col-12 col-xxl-4">
            <span class="card__label">CATEGORY</span>
            <span class="card__project">PROJECT 20XX</span>
            <span class="card__title">JOEL-COFOUNDER</span>
            <p class="card__description">
                ART est une entreprise de création de rêves, voyages & d’achats internationaux
                de biens d’art, un ensemble de personnes pour porter la création à travers
                un ensemble de regards. Culture, c’est la base de tout,
                nous partageons nos cultures à travers les voyages.
            </p>
            <img src="/public/imageCategorie3.png" alt="Joel" class="card__img" />
        </div>

    </div>
</section>


<?php
$content = ob_get_clean();
$title = 'Accueil';
require __DIR__ . '/../layout.php';
?>