# Mini Blog - Symfony Application

Un mini-blog développé avec Symfony 7.4 avec authentification d'utilisateurs, gestion des articles, des catégories et des commentaires.

## Fonctionnalités

### Pour les Visiteurs
- 👁️ Voir la page d'accueil
- 📚 Parcourir la liste des articles
- 💬 Voir les commentaires des articles

### Pour les Utilisateurs Connectés
- ✍️ Ajouter des commentaires sur les articles
- 👤 Consulter et modifier leur profil
- 📖 Accéder à toutes les fonctionnalités publiques

### Pour les Administrateurs  
- 📝 Ajouter, modifier et supprimer des articles
- 🏷️ Gérer les catégories
- 👥 Gérer les utilisateurs (voir la liste, activer/désactiver)
- 💬 Approuver ou supprimer les commentaires

## Technologies Utilisées

- **Backend**: Symfony 7.4
- **Base de données**: Doctrine ORM + SQLite
- **Frontend**: Bootstrap 5.3
- **Authentification**: Symfony Security
- **Formulaires**: Symfony Forms

## Installation

### Prérequis
- PHP 8.3 ou supérieur
- Composer
- SQLite

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone <repository-url>
cd projet1
```

2. **Installer les dépendances**
```bash
composer install --ignore-platform-req=ext-redis
```

3. **Créer la base de données et les tables**
```bash
bin/console doctrine:migrations:migrate --no-interaction
```

4. **Charger les données de test (optionnel)**
```bash
bin/console doctrine:fixtures:load --no-interaction
```

## Démarrer l'Application

### Option 1: Utiliser le serveur Symfony CLI
```bash
symfony serve
```

### Option 2: Utiliser PHP
```bash
php -S localhost:8000 -t public
```

L'application sera accessible à `http://localhost:8000`

## Comptes de Test

Après le chargement des fixtures, les comptes suivants sont disponibles:

### Administrateur
- Email: `admin@blog.com`
- Mot de passe: `admin123`

### Utilisateurs Réguliers
- Email: `user1@blog.com` / Mot de passe: `user123`
- Email: `user2@blog.com` / Mot de passe: `user123`

## Structure du Projet

```
projet1/
├── src/
│   ├── Controller/        # Contrôleurs de l'application
│   ├── Entity/           # Entités Doctrine (User, Post, Category, Comment)
│   ├── Form/             # Formulaires Symfony
│   └── DataFixtures/     # Données de test
├── templates/            # Templates Twig
│   ├── base.html.twig    # Template de base avec Bootstrap
│   ├── blog/             # Pages du blog
│   ├── auth/             # Pages d'authentification
│   └── admin/            # Pages d'administration
├── config/
│   ├── packages/         # Configuration des packages
│   └── routes.yaml       # Définition des routes
├── migrations/           # Migrations Doctrine
├── public/               # Includes CSS, JS, images
└── var/
    └── data.db          # Base de données SQLite
```

## Entités

### User (Utilisateur)
- `id`: Identifiant unique
- `email`: Adresse e-mail (unique)
- `password`: Mot de passe haché
- `firstName`: Prénom
- `lastName`: Nom de famille
- `roles`: Tableau de rôles (ROLE_USER, ROLE_ADMIN)
- `profilePicture`: URL optionnelle de photo de profil
- `isActive`: Statut du compte
- `createdAt`: Date de création
- `updatedAt`: Date de dernière mise à jour

### Post (Article)
- `id`: Identifiant unique
- `title`: Titre de l'article
- `content`: Contenu de l'article
- `picture`: URL de l'image de couverture
- `publishedAt`: Date de publication
- `author`: Lien vers l'utilisateur (auteur)
- `category`: Lien vers la catégorie

### Category (Catégorie)
- `id`: Identifiant unique
- `name`: Nom de la catégorie
- `description`: Description optionnelle

### Comment (Commentaire)
- `id`: Identifiant unique
- `content`: Contenu du commentaire
- `author`: Lien vers l'utilisateur (auteur)
- `post`: Lien vers l'article
- `status`: Statut (pending, approved, rejected)
- `createdAt`: Date de création

## Routes Disponibles

### Pages Publiques
- `GET /` - Page d'accueil
- `GET /post/{id}` - Détail d'un article
- `GET /login` - Page de connexion
- `GET /register` - Page d'inscription
- `GET /logout` - Déconnexion

### Pages Protégées (Utilisateurs)
- `POST /comment/add/{id}` - Ajouter un commentaire

### Pages Admin
- `GET /admin/post` - Liste des articles
- `GET /admin/post/new` - Créer un nouvel article
- `GET /admin/post/{id}/edit` - Éditer un article
- `POST /admin/post/{id}/delete` - Supprimer un article
- `GET /admin/category` - Gérer les catégories

## Configuration de la Sécurité

La sécurité est configurée dans `config/packages/security.yaml`:
- **Authentification**: Formulaire de connexion
- **Fournisseur d'utilisateurs**: User entity
- **Pare-feu**: Protège les routes `/admin` et `/comment`
- **Rôles**: ROLE_USER et ROLE_ADMIN

## Gestion des Utilisateurs

### Inscription
Les nouveaux utilisateurs peuvent s'inscrire via `/register` avec:
- Email
- Prénom
- Nom de famille
- Mot de passe (minimum 6 caractères)
- Acceptation des conditions

### Connexion
Les utilisateurs se connectent via `/login` avec email et mot de passe.

## Gestion des Articles

### Créer un Article (Admin)
1. Naviguer vers `/admin/post/new`
2. Remplir les champs (titre, contenu, catégorie, image)
3. Soumettre le formulaire

### Éditer un Article (Admin)
1. Naviguer vers `/admin/post`
2. Cliquer sur "Éditer" pour l'article
3. Modifier les informations
4. Sauvegarder

### Supprimer un Article (Admin)
1. Naviguer vers `/admin/post`
2. Cliquer sur "Supprimer" pour l'article
3. Confirmer la suppression

## Gestion des Commentaires

### Ajouter un Commentaire (Utilisateur Connecté)
1. Consulter un article
2. Remplir le formulaire de commentaire
3. Soumettre

### Modérer les Commentaires (Admin)
- Les commentaires sont auto-approuvés par défaut
- Les administrateurs peuvent supprimer les commentaires

## Customisation

### Modifier les Couleurs Bootstrap
Éditer les variables CSS en haut du fichier `templates/base.html.twig`:
```css
:root {
    --bs-primary: #0d6efd;
    --bs-secondary: #6c757d;
}
```

### Ajouter des Catégories
1. Accès au panneau d'administration (`/admin/category`)
2. Cliquer sur "Nouvelle Catégorie"
3. Remplir les détails

## Dépannage

### La base de données n'est pas créée
```bash
bin/console doctrine:database:create
```

### Réinitialiser les données
```bash
bin/console doctrine:migrations:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
```

### Problèmes d'authentification
- Vérifier que la base de données est correctement initialisée
- Vérifier la configuration dans `security.yaml`
- Réinitialiser les données de test

## Développement Futur

- [ ] Système de recherche d'articles
- [ ] Tags en plus des catégories
- [ ] Système de like/partage
- [ ] Notifications par email
- [ ] Profil utilisateur complet
- [ ] Système de brouillons pour les articles
- [ ] Pagination des articles
- [ ] API REST
- [ ] Tests unitaires


