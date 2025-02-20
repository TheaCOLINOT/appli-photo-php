# Guide de démarrage

Ce guide vous explique comment installer et lancer l'application en local.

## Prérequis

- [Git](https://git-scm.com/)
- [Docker](https://www.docker.com/) et [Docker Compose](https://docs.docker.com/compose/)
- [Node.js](https://nodejs.org/) (pour compiler les fichiers SASS)

## Installation

1. **Cloner le dépôt GitHub**
   ```bash
   git clone https://github.com/TheaCOLINOT/appli-photo-php.git
   cd appli-photo-php


Configurer l’environnement
Créez un fichier .env à partir de .envexample et configurez les paramètres (base de données, certificats, etc.).

Lancer l’application avec Docker
Utilisez la commande suivante pour démarrer Docker Compose :

bash
Copier
make start
Compilation du CSS
Pour modifier le CSS (utilisant SASS), installez les dépendances et compilez :

bash
Copier
npm install --save-dev vite
npm run build
Accéder à l’application

Frontend : http://localhost:8000
phpMyAdmin : http://localhost:8080
diff
Copier

#### c. Utilisation de l’application (`docs/guide/usage.md`)

```markdown
# Utilisation de l’application

L’application permet à des groupes d’amis de partager leurs photos de roadtrips. Voici un aperçu des principales fonctionnalités :

## Gestion des utilisateurs

- **Inscription :** Remplissez le formulaire d’inscription. Les données sont vérifiées et le mot de passe est haché.
- **Connexion :** Authentification sécurisée et création de session.
- **Réinitialisation du mot de passe :** Un email contenant un lien sécurisé est envoyé pour réinitialiser le mot de passe.

## Gestion des photos

- **Upload de photos :** Les utilisateurs connectés peuvent uploader des photos (avec validation de taille et format).
- **Affichage :** Les photos sont organisées par groupe.
- **Suppression :** Seuls l’auteur de la photo ou le propriétaire du groupe peuvent supprimer une photo.
- **Partage :** Possibilité de générer un lien de partage public pour certaines photos.

## Gestion des groupes

- **Création :** Chaque groupe est créé avec un propriétaire unique.
- **Administration :** Le propriétaire peut ajouter/supprimer des membres et attribuer des rôles (lecture ou écriture).
