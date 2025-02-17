# Documentation Technique - Appli Photo PHP

Ce site statique contient la documentation technique de l'application **Appli Photo PHP**. La documentation a été générée automatiquement avec [VitePress](https://vitepress.dev/) à partir des fichiers Markdown situés dans le dossier `docs/` de la branche principale du projet.

---

## Contexte et Objectifs

**Appli Photo PHP** est une application de gestion de photos en PHP (architecturée en MVC) qui permet aux utilisateurs de :
- Partager leurs photos de roadtrips entre amis,
- Gérer les utilisateurs et les groupes,
- Uploader, afficher et supprimer des photos,
- Utiliser un framework CSS personnalisé basé sur SASS et la méthodologie BEM.

Pour faciliter la maintenance et l'accès à l'information, nous avons mis en place une documentation technique moderne qui détaille l'installation, l'utilisation et l'architecture du projet.

---

## Processus de Mise en Place

1. **Création de la Structure de la Documentation**  
   - Un dossier `docs/` a été ajouté à la racine du projet.
   - La structure inclut notamment :
     - `docs/index.md` – Page d'accueil de la documentation.
     - `docs/guide/getting-started.md` – Guide de démarrage.
     - `docs/guide/usage.md` – Explications sur l'utilisation de l'application.
     - `docs/features/css-framework.md` – Documentation sur le framework CSS & SASS (méthodologie BEM, mobile-first, dark mode, etc.).

2. **Configuration de VitePress**  
   - VitePress a été installé et configuré via le fichier `docs/.vitepress/config.ts`.
   - La propriété `base` a été définie sur `/appli-photo-php/` pour assurer que les liens vers les assets (CSS, images, etc.) soient correctement résolus sur GitHub Pages.

3. **Génération et Déploiement**  
   - La commande `npm run docs:build` génère le site statique dans le dossier `docs/.vitepress/dist`.
   - La commande `npm run docs:deploy` déploie le contenu généré sur la branche `gh-pages` à l'aide du package `gh-pages`.
   - La branche `gh-pages` est utilisée par GitHub Pages pour héberger la documentation.

---

## Accès à la Documentation

La documentation est accessible en ligne via l'URL suivante :

[https://TheaCOLINOT.github.io/appli-photo-php/](https://TheaCOLINOT.github.io/appli-photo-php/)

---

## Mise à Jour de la Documentation

Pour mettre à jour la documentation technique :

1. **Modifier les fichiers source**  
   Apportez les modifications nécessaires dans les fichiers Markdown situés dans le dossier `docs/` de la branche principale.

2. **Générer la nouvelle version**  
   Exécutez la commande :
   ```bash
   npm run docs:build

@MariamBouhassoune
