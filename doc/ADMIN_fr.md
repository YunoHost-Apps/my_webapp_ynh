# 🛠️ Guide d'Administration - My Webapp

Cette application fournit un **squelette d'application web vierge** où vous pouvez ajouter votre propre contenu (HTML, CSS, PHP, etc.) dans le répertoire `__INSTALL_DIR__/www/`. La façon la plus simple d'ajouter du contenu est d'utiliser SFTP.

## 🔐 Accès SFTP

### Détails de Connexion

Une fois installée, visitez l'URL de votre application pour voir les informations de connexion :

- **Hôte** : `__DOMAIN__`
- **Nom d'utilisateur** : `__ID__`
- **Mot de passe** : Le mot de passe que vous avez défini lors de l'installation
- **Port** : 22 (port SSH standard)

> **💡 Astuce Mot de Passe** : Si vous n'avez pas défini de mot de passe lors de l'installation, le système utilise automatiquement votre nom d'utilisateur actuel comme mot de passe.

### Clients SFTP

Vous pouvez vous connecter avec n'importe quel client SFTP :

- **Windows/Mac/Linux** : [FileZilla](https://filezilla-project.org/)
- **Mac** : Finder intégré (⌘+K)
- **Linux** : Gestionnaire de fichiers ou ligne de commande
- **Ligne de Commande** : `sftp __ID__@__DOMAIN__`
- **Chemin par Défaut** : `/` (racine de votre domaine)

### Mot de Passe Oublié ?

Pas de souci ! Vous pouvez changer votre mot de passe SFTP à tout moment :

1. Allez dans le **Panneau d'Administration YunoHost**
2. Naviguez vers **Applications > My Webapp > Configuration**
3. Mettez à jour votre mot de passe dans la section SFTP
4. Assurez-vous que SFTP est activé

## 💻 Accès en Ligne de Commande

À partir de YunoHost v11.1.21, vous pouvez utiliser :

```bash
sudo yunohost app shell __APP__
```

Cela vous donne un accès direct en tant qu'utilisateur de votre application, et la commande `php` utilisera la version PHP installée pour votre application.

## 📁 Gestion de Vos Fichiers

### Structure des Fichiers

```
__INSTALL_DIR__/www/
├── index.html          # Votre page principale
├── css/               # Feuilles de style
├── js/                # Fichiers JavaScript
├── images/            # Images et médias
└── error/             # Pages d'erreur personnalisées
```

### Ajout de Contenu

1. **Connectez-vous via SFTP** avec vos identifiants
2. **Naviguez vers le dossier `www`**
3. **Téléchargez vos fichiers** (HTML, CSS, JS, PHP, images, etc.)
4. **Votre site est en ligne** immédiatement !

## ⚠️ Gestion des Erreurs

### Pages d'Erreur Personnalisées

Créez des pages d'erreur personnalisées pour une meilleure expérience utilisateur :

1. **Créez un dossier `error`** dans `__INSTALL_DIR__/www/error/`
2. **Ajoutez vos pages personnalisées** :
   - `403.html` - Accès interdit
   - `404.html` - Page non trouvée
3. **Activez la fonctionnalité** dans le panneau de configuration de l'application

### Codes d'Erreur Supportés

- **403** : Accès Interdit
- **404** : Page Non Trouvée

## ⚙️ Configuration Avancée

### Personnalisation Nginx

Pour personnaliser la configuration du serveur web :

1. **Éditez les fichiers** dans `/etc/nginx/conf.d/__DOMAIN__.d/__ID__.d/`
2. **Utilisez l'extension `.conf`** pour vos fichiers
3. **Testez la configuration** : `nginx -t`
4. **Rechargez nginx** : `systemctl reload nginx`

### Modes de Routage

Votre application supporte 3 modes de routage :

- **Static** : Sert les fichiers statiques, bascule vers index.php
- **Front** : Routage direct vers index.php (mode SPA)
- **Public** : Sert depuis le répertoire public

Changez-les dans le panneau de configuration sous "Configuration du Routage".

## 🚀 Checklist de Démarrage Rapide

- [ ] Installez l'application avec vos paramètres préférés
- [ ] Notez vos identifiants SFTP depuis l'URL de l'application
- [ ] Connectez-vous via SFTP et téléchargez vos fichiers
- [ ] Testez votre site web
- [ ] Personnalisez les pages d'erreur (optionnel)
- [ ] Configurez le mode de routage si nécessaire

## 📚 Besoin d'Aide ?

- **Communauté YunoHost** : [community.yunohost.org](https://community.yunohost.org)
- **Documentation** : Consultez la description de l'application pour l'utilisation de base
- **Modes de Routage** : Consultez la documentation des tests pour la configuration avancée
