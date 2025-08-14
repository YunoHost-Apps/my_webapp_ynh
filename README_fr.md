# My Webapp - Package YunoHost

Application Web personnalisée avec accès SFTP pour servir des fichiers statiques (HTML, CSS, JS) et PHP.

## Fonctionnalités

- **3 Modes de Rewrite** : Choisissez la meilleure configuration pour votre application
- **Accès SFTP** : Accès SFTP optionnel pour la gestion des fichiers
- **Support PHP** : Support de plusieurs versions PHP (7.4 à 8.4)
- **Support Base de Données** : Support optionnel MySQL ou PostgreSQL
- **Pages d'Erreur Personnalisées** : Support des pages d'erreur 404 et autres personnalisées

## Modes de Rewrite

### 1. Mode Par Défaut
- **Objectif** : Service web standard sans règles de rewrite spéciales
- **Cas d'Usage** : Sites web statiques simples, applications PHP basiques
- **Comportement** : Sert les fichiers directement depuis le répertoire `www/`
- **Configuration** : Utilise le comportement par défaut de `nginx.conf`

### 2. Mode Front
- **Objectif** : Application à point d'entrée unique (comme un contrôleur frontal)
- **Cas d'Usage** : Applications PHP modernes, frameworks SPA
- **Comportement** : Toutes les requêtes sont réécrites vers `/index.php`
- **Configuration** : Utilise `rewrite-front.conf`

### 3. Mode Framework
- **Objectif** : Applications style framework (Laravel, Symfony, etc.)
- **Cas d'Usage** : Frameworks PHP modernes avec répertoire public
- **Comportement** : Toutes les requêtes sont réécrites vers `/public/index.php`
- **Configuration** : Utilise `rewrite-framework.conf`

## Installation

Lors de l'installation, il vous sera demandé de choisir :
- **Domaine** : Votre nom de domaine
- **Chemin** : Chemin d'installation (par défaut : `/site`)
- **Accès SFTP** : Si vous souhaitez activer l'accès SFTP
- **Mot de Passe** : Mot de passe SFTP (si SFTP est activé)
- **Version PHP** : Version PHP à utiliser (7.4 à 8.4)
- **Base de Données** : Type de base de données (aucune, MySQL, PostgreSQL)
- **Fichiers d'Erreur Personnalisés** : Activer les pages d'erreur personnalisées
- **Mode de Rewrite** : Choisir entre par défaut, front, ou framework

## Configuration

Vous pouvez changer le mode de rewrite après l'installation en utilisant :
```bash
yunohost app config my_webapp
```

## Structure des Fichiers

```
www/
├── index.html          # Fichier HTML principal
├── index.php           # Fichier PHP de test
├── ads.txt            # Fichier ads.txt (servi directement)
├── public/            # Répertoire mode framework
│   └── index.php      # Point d'entrée framework
└── error/             # Pages d'erreur personnalisées (si activées)
    └── 404.html       # Page 404 personnalisée
```

## Fonctionnalités de Sécurité

- Les fichiers et répertoires cachés sont bloqués (sauf `.well-known`)
- Les types de fichiers sensibles (`.json`, `.tpl`, `.ini`, `.env`) sont refusés
- Permissions et propriété des fichiers appropriées
- Isolation de l'accès SFTP

## Support

Pour les problèmes et questions, veuillez consulter la documentation YunoHost ou créer un ticket dans le dépôt du package.
