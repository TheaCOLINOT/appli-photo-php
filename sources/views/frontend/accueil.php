<?php ob_start(); ?>

    <section>
        <div class="banner banner--text" style="background-image: url('./dist/banner.jpg')">
            <div class="banner__content">
                <h1>Bienvenue sur <span>Phphoto</span></h1>
                <p>Votre premier Application de photo Grouper partager entre amis et famille</p>	
                <form action="/login" method="GET">
                    <button class="button button--primary">Rechercher</button>
                </form>
            </div>
        </div>
    </section>
<section >
    <h2 class="title">A propos</h2>
    <div class="apropos  container">
        <div class="apropos--item grid">
                <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                    <p>Votre premier Application de photo Grouper partager 
                        entre amis Votre premier Application de photo Grouper partager entre amis
                        Votre premier Application de photo Grouper partager entre amis Votre premier A
                        pplication de photo Grouper partager entre amis Votre premier Application de photo Grouper partager entre amis Votre premier Application de photo Grouper partager
                        entre amis Votre premier Application de photo Grouper partager entre amis 
                    </p>
                    <a href="/login">En savoir plus</a>
                </div>
                <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6" >
                    <img src="/public/image1.png" class="image image--md " alt="image présentation">
                </div>  
        </div>
        <div class="apropos--item--revers  grid">
                <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                    <p>Votre premier Application de photo Grouper partager 
                        entre amis Votre premier Application de photo Grouper partager entre amis
                        Votre premier Application de photo Grouper partager entre amis Votre premier A
                        pplication de photo Grouper partager entre amis Votre premier Application de photo Grouper partager entre amis Votre premier Application de photo Grouper partager
                        entre amis Votre premier Application de photo Grouper partager entre amis 
                    </p>
                    <a href="/login">En savoir plus</a>
                </div>
                <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6" >
                    <img src="/public/image2.png" class="image image--md " alt="image présentation">
                </div>  
        </div>        
        <div class="apropos--item grid">
                <div class="apropos--content--text  col-lg-6 col-md-6 col-12 col-xxl-6">
                    <p>Votre premier Application de photo Grouper partager 
                        entre amis Votre premier Application de photo Grouper partager entre amis
                        Votre premier Application de photo Grouper partager entre amis Votre premier A
                        pplication de photo Grouper partager entre amis Votre premier Application de photo Grouper partager entre amis Votre premier Application de photo Grouper partager
                        entre amis Votre premier Application de photo Grouper partager entre amis 
                    </p>
                    <a href="/login">En savoir plus</a>
                </div>
                <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6" >
                    <img src="/public/image3.png" class="image image--md " alt="image présentation">
                </div>  
        </div>
    </div>
</section>
<section >
    <h2 class="title">Cart</h2>
    <div class="apropos  container">
        <div class="apropos--item grid">
                <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                    <p>Votre premier Application de photo Grouper partager 
                        entre amis Votre premier Application de photo Grouper partager entre amis
                        Votre premier Application de photo Grouper partager entre amis Votre premier A
                        pplication de photo Grouper partager entre amis Votre premier Application de photo Grouper partager entre amis Votre premier Application de photo Grouper partager
                        entre amis Votre premier Application de photo Grouper partager entre amis 
                    </p>
                    <a href="/login">En savoir plus</a>
                </div>
                <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6" >
                    <img src="/public/image1.png" class="image image--md " alt="image présentation">
                </div>  
        </div>
        <div class="apropos--item--revers  grid">
                <div class="apropos--content--text col-lg-6 col-md-6 col-12 col-xxl-6">
                    <p>Votre premier Application de photo Grouper partager 
                        entre amis Votre premier Application de photo Grouper partager entre amis
                        Votre premier Application de photo Grouper partager entre amis Votre premier A
                        pplication de photo Grouper partager entre amis Votre premier Application de photo Grouper partager entre amis Votre premier Application de photo Grouper partager
                        entre amis Votre premier Application de photo Grouper partager entre amis 
                    </p>
                    <a href="/login">En savoir plus</a>
                </div>
                <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6" >
                    <img src="/public/image2.png" class="image image--md " alt="image présentation">
                </div>  
        </div>        
        <div class="apropos--item grid">
                <div class="apropos--content--text  col-lg-6 col-md-6 col-12 col-xxl-6">
                    <p>Votre premier Application de photo Grouper partager 
                        entre amis Votre premier Application de photo Grouper partager entre amis
                        Votre premier Application de photo Grouper partager entre amis Votre premier A
                        pplication de photo Grouper partager entre amis Votre premier Application de photo Grouper partager entre amis Votre premier Application de photo Grouper partager
                        entre amis Votre premier Application de photo Grouper partager entre amis 
                    </p>
                    <a href="/login">En savoir plus</a>
                </div>
                <div class="col-lg-6 col-md-6 apropos--content--image col-xl-6 col-xxl-6" >
                    <img src="/public/image3.png" class="image image--md " alt="image présentation">
                </div>  
        </div>
    </div>
</section>
<?php
$content = ob_get_clean();
$title = 'Accueil';
require __DIR__ . '/../layout.php';
?>
