{% if database != 'none' %}

Voici les informations pour se connecter à la base de donnée:

- Type : `__DATABASE__`
- Utilisateur de la base de données : `__DB_USER__`
- Nom de la base de données : `__DB_NAME__`
- Mot de passe : `__DB_PWD__`

{% endif %}

{% if with_sftp == 1 %}

## Accès SFTP

Vous pouvez accéder aux fichiers de votre application via SFTP :

- **Hôte** : `__DOMAIN__`
- **Port** : `22` (port SSH par défaut)
- **Nom d'utilisateur** : `__NAME__`
- **Mot de passe** : `__PASSWORD__`
- **Répertoire** : `__INSTALL_DIR__/www`

{% endif %}

## Informations de l'Application

- **URL** : `https://__DOMAIN____PATH__`
- **Mode de Rewrite** : `__REWRITE_MODE__`
- **Répertoire d'Installation** : `__INSTALL_DIR__`

## Détails du Mode de Rewrite

{% if rewrite_mode == 'default' %}
**Mode Par Défaut** : Service web standard sans règles de rewrite spéciales. Les fichiers sont servis directement depuis le répertoire `www/`.
{% endif %}

{% if rewrite_mode == 'front' %}
**Mode Front** : Application à point d'entrée unique. Toutes les requêtes sont réécrites vers `/index.php` (patron contrôleur frontal).
{% endif %}

{% if rewrite_mode == 'framework' %}
**Mode Framework** : Application style framework. Toutes les requêtes sont réécrites vers `/public/index.php` (style Laravel/Symfony).
{% endif %}
