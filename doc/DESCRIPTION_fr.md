# 🌐 My Webapp - Votre Application Web Personnalisée

Cette application vous permet d'installer facilement une **application web personnalisée** où vous pouvez déployer votre propre site web en utilisant des fichiers HTML, CSS, JavaScript ou PHP.

## ✨ Fonctionnalités Principales

- **Déploiement Facile** : Téléchargez vos fichiers via SFTP ou toute autre méthode
- **Routage Flexible** : Choisissez entre 3 modes de routage (static, front, public)
- **Support Base de Données** : Base de données MySQL ou PostgreSQL optionnelle avec sauvegarde automatique
- **Support PHP** : Sélectionnez parmi les versions PHP 8.0 à 8.4, ou aucune
- **Pages d'Erreur Personnalisées** : Créez des pages d'erreur 404 personnalisées
- **Accès SFTP** : Transfert de fichiers sécurisé avec fallback automatique du mot de passe

## 🚀 Pour Commencer

1. **Installez l'application** et choisissez vos préférences
2. **Téléchargez vos fichiers** dans le dossier `www` via SFTP
3. **Accédez à votre site** à l'URL choisie
4. **Personnalisez** les pages d'erreur et les paramètres selon vos besoins

## 📁 Structure des Fichiers

```
www/
├── index.html          # Votre page principale
├── css/               # Feuilles de style
├── js/                # Fichiers JavaScript
├── images/            # Images et médias
└── error/             # Pages d'erreur personnalisées (optionnel)
```

## 🔐 Accès SFTP

- **Nom d'utilisateur** : Même nom que votre application
- **Mot de passe** : Celui que vous avez défini lors de l'installation
- **Port** : Port SSH standard (généralement 22)
- **Répertoire** : Dossier `www/` pour les fichiers publics

> **💡 Astuce** : Si vous ne définissez pas de mot de passe lors de l'installation, le système utilisera automatiquement votre nom d'utilisateur actuel comme mot de passe pour plus de commodité.

## 🎨 Options de Personnalisation

- **Mode de Routage** : Choisissez comment les URLs sont gérées
- **Version PHP** : Sélectionnez la version PHP qui correspond à vos besoins
- **Base de Données** : Ajoutez une base de données pour du contenu dynamique
- **Pages d'Erreur** : Créez des pages d'erreur 404 et d'erreur personnalisées

## 📚 Besoin d'Aide ?

- Consultez la documentation d'administration pour la configuration détaillée
- Visitez la communauté YunoHost pour le support
- Consultez la documentation des modes de routage pour une utilisation avancée 
