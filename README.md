# Installation du Projet

## Prérequis

- Docker & Docker Compose
- Git
- Node.js et npm
- Make

## Étapes d'Installation

### 1. Cloner le Projet

```bash
git clone https://github.com/TheaCOLINOT/appli-photo-php.git
cd appli-photo-php
```

### 2. Configuration de l'Environnement

- Copier le fichier `.env.example` en `.env`
- Configurer les variables d'environnement selon votre environnement local

### 3. Lancement du Projet

Démarrer les conteneurs Docker :
```bash
make start
```

### 4. Installation des Dépendances Front-end

```bash
npm install --save-dev vite
npm run build
```

## Accès à l'Application

Une fois l'installation terminée, vous pouvez accéder à :

- Application : `http://localhost:8000`
- phpMyAdmin : `http://localhost:8080`

## Développement

### Modification du CSS

Le projet utilise SASS pour la gestion des styles. Pour compiler les modifications CSS :

```bash
npm run build
```

## Dépannage

### Problèmes Courants

1. Si les conteneurs Docker ne démarrent pas :
   - Vérifier que les ports 8000 et 8080 sont disponibles
   - S'assurer que Docker est en cours d'exécution

2. Si les styles ne se mettent pas à jour :
   - Vérifier que la commande `npm run build` a été exécutée
   - Vider le cache du navigateur

## Accès à la Documentation

La documentation est accessible en ligne via l'URL suivante :

[https://TheaCOLINOT.github.io/appli-photo-php/](https://TheaCOLINOT.github.io/appli-photo-php/)

