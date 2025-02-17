# Documentation du Projet PHP8 MVC - Application de Gestion de Photos

## 1. Présentation du Projet

L'application permet aux utilisateurs de partager leurs photos de roadtrips entre amis via un système de groupes privés. Elle propose les fonctionnalités principales suivantes :

- **Inscription et authentification** des utilisateurs.
- **Création et gestion de groupes de partage**.
- **Upload, affichage et suppression de photos**.
- **Partage de photos** via des liens publics.
- **Réinitialisation de mot de passe** via un email sécurisé.
- **Hébergement** accessible via une URL publique en HTTPS.

---

## 2. Architecture du Projet

Le projet est basé sur l'architecture **MVC (Modèle - Vue - Contrôleur)**, organisée comme suit :

- **Models** : Gestion des entités et interactions avec la base de données.
- **Controllers** : Traitement des requêtes et actions utilisateur.
- **Views** : Présentation des interfaces utilisateur, stylisées avec SASS.
- **Core** : Classes utilitaires pour la gestion de la base de données, la session, le routage et l'envoi d'emails.
- **Requests** : Validation des entrées utilisateur afin de sécuriser les formulaires.

---

## 3. Fonctionnalités Implémentées

### 3.1 Authentification et Gestion des Utilisateurs

- ✅ **Inscription** avec validation stricte et hachage des mots de passe.
- ✅ **Connexion sécurisée** utilisant `password_verify()`.
- ✅ **Déconnexion** avec suppression de la session.
- ✅ **Réinitialisation de mot de passe** par email via un lien sécurisé.

### 3.2 Gestion des Photos et Groupes

- ✅ **Upload de photos** avec validation (taille et format).
- ✅ **Affichage** des photos (par groupe ou personnelles).
- ✅ **Création et gestion de groupes** incluant l'ajout/suppression de membres.
- ✅ **Gestion des droits d’accès** (lecture/écriture, gestion par le propriétaire du groupe).
- ✅ **Suppression de photos** accessible uniquement à l'auteur ou à l'administrateur du groupe.
- ✅ **Partage public** de photos via un lien unique généré par l'utilisateur.

### 3.3 Gestion des Emails

- ✅ **Envoi d'emails** via PHPMailer en utilisant SMTP sécurisé.
- ✅ **Réinitialisation de mot de passe** : génération d'un jeton unique et envoi d'un lien sécurisé par email.
- ✅ **Configuration SMTP avec Gmail** :
  - **Installation** : Exécuter `composer require phpmailer/phpmailer` à la racine du projet.
  - **Paramètres** :
    - **Host** : `smtp.gmail.com`
    - **Port** : `587` (TLS)
    - **Authentification** : Utilisation d'un mot de passe d'application.
- ✅ **Format HTML** des emails pour une meilleure lisibilité.

### 3.4 Logique des Groupes

- ✅ **Création d'un groupe** avec un propriétaire unique.
- ✅ **Ajout de membres** par l’administrateur du groupe.
- ✅ **Attribution de rôles** :
  - **read** : Peut voir les photos du groupe.
  - **write** : Peut ajouter des photos.
- ✅ **Gestion des groupes** : Le propriétaire peut supprimer le groupe ou modifier les rôles des membres.
- ✅ **Partage de photos** : Par défaut limité au groupe, sauf si un lien public est généré par l'utilisateur.

### 3.5 Hébergement et Sécurisation

- ✅ **Déploiement avec Docker** : Utilisation de conteneurs pour PHP, Nginx et MariaDB.
- ✅ **Base de données relationnelle** : MySQL avec contraintes d'intégrité.
- ✅ **Utilisation de HTTPS** pour sécuriser les communications.
- ✅ **Protection** contre les attaques SQL Injection, XSS et CSRF.

#### Configuration de l'Hébergement

- **Environnement VPS Docker sur Hostinger** :
  - Le projet a été déployé sur un VPS utilisant Docker.
  - **Personnalisation du Dockerfile pour Nginx** :
    - Adaptation de la configuration pour le serveur.
    - Modification des ports pour correspondre aux besoins du serveur.
    - Intégration du certificat SSL dans la configuration.
  - **Mise à jour du fichier `.env`** :
    - Ajout des certificats.
  - **Modification du `docker-compose.yml`** :
    - Réglage des ports pour une communication sécurisée et conforme aux exigences du serveur.


