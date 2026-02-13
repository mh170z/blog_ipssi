# Guide d'Installation et Démarrage

## Étape 1 : Prérequis

Assurez-vous que votre système dispose de :
- **PHP 8.3 ou supérieur** : Vérifiez avec `php --version`
- **Composer** : Vérifiez avec `composer --version`
- **Git** : Vérifiez avec `git --version`
- **SQLite** : Généralement inclus dans PHP (vérifie avec `php -m | grep sqlite`)

## Étape 2 : Clone ou Récupération du Projet

```bash
cd /Users/mohamed/workspace/ipsi
# Le projet est dans le répertoire projet1
cd projet1
```

## Étape 3 : Installer les Dépendances

```bash
composer install --ignore-platform-req=ext-redis
```

## Étape 4 : Configurer la Base de Données

La base de données SQLite se crée automatiquement. Les migrations sont déjà appliquées.

```bash
# Créer les tables (si nécessaire)
bin/console doctrine:migrations:migrate --no-interaction
```

## Étape 5 : Charger les Données de Test (Optionnel)

Pour avoir des données de test :

```bash
bin/console doctrine:fixtures:load --no-interaction
```

## Étape 6 : Démarrer l'Application

### Option A : Avec PHP intégré (Recommandé pour développement)
```bash
php -S 127.0.0.1:8000 -t public
```

### Option B : Avec le serveur Symfony CLI
```bash
symfony serve --no-tls
```

### Option C : Avec un serveur Apache/Nginx
Configurez le serveur pour servir le répertoire `public/` comme racine web.

## Étape 7 : Accéder à l'Application

Ouvrez votre navigateur et accédez à :
```
http://localhost:8000
```

## Étapes Suivantes après Installation

### 1. S'inscrire ou Se Connecter

**Première visite** : Cliquez sur "Register" pour créer un compte ou connectez-vous avec un compte de test.

**Comptes de test pré-créés** (si fixtures chargées) :
- Admin: `admin@blog.com` / `admin123`
- User 1: `user1@blog.com` / `user123`
- User 2: `user2@blog.com` / `user123`

### 2. Parcourir le Blog

- Accueil : voir tous les articles
- Articles individuels : lire le contenu complet et les commentaires
- Ajouter des commentaires : si connecté

### 3. Créer des Articles (Admin seulement)

1. Connectez-vous en tant qu'administrateur
2. Cliquez sur "Admin" dans le menu
3. Sélectionnez "Create Post"
4. Remplissez les informations et publiez

## Troubleshooting

### L'application ne démarre pas

```bash
# Vérifier la version PHP
php --version

# Vérifier les détails d'erreur
php -d display_errors=1 bin/console

# Vérifier les permissions
chmod +x bin/console
```

### Erreur de base de données

```bash
# Recréer la base de données
rm -f var/data.db
bin/console doctrine:migrations:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
```

### Erreur de cache

```bash
# Vider le cache
bin/console cache:clear
```

### Port 8000 déjà utilisé

```bash
# Utiliser un port différent
php -S 127.0.0.1:8080 -t public
```

## Structure de Fichiers Important

```
projet1/
├── public/               # Affichage public avec index.php
├── src/
│   ├── Controller/      # Contrôleurs
│   ├── Entity/          # Modèles de données
│   └── Form/            # Formulaires
├── templates/           # Templates Twig
├── config/              # Configuration
├── migrations/          # Migrations base de données
├── var/
│   └── data.db         # Base de données SQLite
└── .env                 # Variables d'environnement
```

## Développement

### Créer une nouvelle migration après modification des entités

```bash
bin/console make:migration
bin/console doctrine:migrations:migrate
```

### Vider le cache quand nécessaire

```bash
bin/console cache:clear
```

### Créer un nouvel utilisateur via ligne de commande

```bash
bin/console make:user
```

## Fonctionnalités Implémentées

✅ Authentification utilisateur (inscription/connexion)
✅ Gestion des rôles (Admin/User)
✅ Système CRUD complet pour les articles
✅ Catégorisation des articles
✅ Système de commentaires
✅ Interface Bootstrap responsive
✅ Protection des routes sensibles
✅ Base de données relationnelle
✅ Migrations Doctrine
✅ Fixtures pour données de test

## Fonctionnalités Futures Possibles

⬜ Système de recherche avancée
⬜ Tags en plus des catégories
⬜ Système de Like/Favoris
⬜ Notifications par email
⬜ Profil utilisateur complet avec avatar
⬜ Brouillons d'articles
⬜ Pagination
⬜ API REST
⬜ Tests unitaires et d'intégration
⬜ Export en PDF/CSV

## Support

Pour toute question concernant l'installation ou le fonctionnement, veuillez :
1. Consulter le README.md
2. Vérifier les logs dans `var/log/`
3. Contacter l'administrateur du projet

---

**Bon développement ! 🚀**
