# Architecture du Mini Blog Symfony

## Vue d'Ensemble

Le Mini Blog est une application web monolithique construite avec Symfony 7.4 et Bootstrap 5.3, suivant l'architecture Model-View-Controller (MVC) classique.

```
Client (Navigateur) 
    ↓
Router (Symfony Routing)
    ↓
Contrôleur (AuthController, BlogController, etc.)
    ↓
Entités & Services (Doctrine ORM)
    ↓
Base de Données (SQLite)
    ↓
Templates Twig (Bootstrap)
    ↓
Client (HTML/CSS/JS)
```

## Composants Principales

### 1. Couche Présentation (Views)

**Emplacement**: `templates/`

```
templates/
├── base.html.twig          # Layout de base avec navigation
├── blog/
│   ├── index.html.twig     # Page d'accueil du blog
│   └── detail.html.twig    # Page de détail d'un article
├── auth/
│   ├── login.html.twig     # Formulaire de connexion
│   └── register.html.twig  # Formulaire d'inscription
└── admin/
    ├── post/
    │   ├── list.html.twig  # Liste des articles (admin)
    │   └── form.html.twig  # Formulaire article (création/édition)
    └── category/
        └── list.html.twig  # Gestion des catégories
```

**Framework utilisé**: Twig 3.23 + Bootstrap 5.3

**Approche**: 
- Templates statiques avec contrôles de sécurité intégrés
- Intégration de Bootstrap via CDN
- Formulaires Symfony rendus automatiquement
- Messages flash pour les notifications

### 2. Couche Contrôleur (Controllers)

**Emplacement**: `src/Controller/`

| Contrôleur | Responsabilités |
|-----------|-----------------|
| `AuthController` | Inscription, connexion, déconnexion |
| `BlogController` | Affichage des articles et de l'accueil |
| `CommentController` | Ajout et suppression de commentaires |
| `AdminPostController` | Gestion CRUD des articles (admin) |

**Patterns utilisés**:
- Route attributes pour la définition des routes
- Services d'injection de dépendances
- Redirections basées sur les rôles
- Utilisation de `AuthenticationUtils` pour le contexte de sécurité

### 3. Couche Métier (Entities & Business Logic)

**Emplacement**: `src/Entity/`

#### Entité User
```php
User {
  - id: int (Primary Key)
  - email: string (Unique) ← Authentication Username
  - password: string (Hashed)
  - firstName, lastName: string
  - roles: array (ROLE_USER, ROLE_ADMIN)
  - profilePicture: string|null
  - isActive: bool
  - createdAt, updatedAt: DateTimeImmutable
  - posts: OneToMany → Post
  - comments: OneToMany → Comment
}
```

#### Entité Post
```php
Post {
  - id: int (Primary Key)
  - title: string
  - content: text
  - picture: string|null
  - publishedAt: DateTimeImmutable
  - author: ManyToOne → User
  - category: ManyToOne → Category
  - comments: OneToMany → Comment
}
```

#### Entité Category
```php
Category {
  - id: int (Primary Key)
  - name: string
  - description: text|null
  - posts: OneToMany → Post
}
```

#### Entité Comment
```php
Comment {
  - id: int (Primary Key)
  - content: text
  - createdAt: DateTimeImmutable
  - status: enum (pending, approved, rejected)
  - author: ManyToOne → User
  - post: ManyToOne → Post
}
```

### 4. Couche Persistence (Repository)

**Emplacement**: `src/Repository/` (Auto-générés par Doctrine)

Utilisation de Doctrine ORM pour :
- Requêtes via QueryBuilder
- Relations automatiques entre entités
- Migrations de schéma de base de données
- Transactions atomiques

### 5. Couche Présentation de Formulaires

**Emplacement**: `src/Form/`

| Formulaire | Utilisation |
|-----------|-------------|
| `RegistrationFormType` | Inscription utilisateur |
| `CommentFormType` | Ajout de commentaire |
| `PostFormType` | Création/édition d'article |

**Avantages**:
- Gestion automatique des contrôles CSRF
- Validation côté serveur intégrée
- Affichage personnalisé avec Bootstrap

## Diagramme de Flux d'Authentification

```
Utilisateur non authentifié
    ↓
Entre email et mot de passe
    ↓
POST /login
    ↓ (Symfony Security)
Vérifie credentials contre User Entity
    ↓
UserProvider charge depuis base de données
    ↓
PasswordHasher valide le mot de passe
    ↓
Token de session créé
    ↓
Utilisateur redirigé vers page demandée
```

## Architecture de Sécurité

### Authentification
- **Méthode**: Session HTTP + Cookies
- **Fournisseur**: `UserProvider` basé sur Entité `User`
- **Hachage**: bcrypt automatique

### Autorisation
- **Rôles**: ROLE_USER, ROLE_ADMIN
- **Token**: CSRF tokens sur tous les formulaires
- **Firewall**: Protection des routes `/admin` et `/comment`

### Contrôl d'Accès
```yaml
security.yaml:
  access_control:
    - { path: ^/admin, roles: ROLE_ADMIN }
    - { path: ^/comment, roles: ROLE_USER }
```

## Cycle de Vie d'une Requête

### 1. Request Entrante
```
GET /post/1
    ↓
index.php (entry point)
    ↓
Kernel initialise l'environnement
    ↓
Router identifie la route
```

### 2. Matching de Route
```
URL: /post/1
Route: /post/{id}
Controller: BlogController::detail()
```

### 3. Exécution du Contrôleur
```php
public function detail(Post $post): Response
{
    // Doctrine auto-injection de Post via {id}
    // Rendu du template avec contexte
    return $this->render('blog/detail.html.twig', [
        'post' => $post,
    ]);
}
```

### 4. Rendu du Template
```
blog/detail.html.twig
    ↓ (extends)
base.html.twig
    ↓ (Twig rendering)
Output HTML final
```

### 5. Response au Client
```
HTTP 200 OK
Content-Type: text/html
Content-Length: [taille]
[HTML body]
```

## Patterns de Design Utilisés

### Dependency Injection
```php
public function __construct(
    private UserPasswordHasherInterface $passwordHasher,
    private EntityManagerInterface $em
)
```

### Active Record (Doctrine Entities)
Chaque entité gère ses propres données et relations.

### Repository Pattern
`EntityManager` comme gestionnaire central de persistence.

### Template Method (Twig Inheritance)
```twig
{% extends "base.html.twig" %}
{% block body %}
    <!-- Contenu spécifique -->
{% endblock %}
```

### Data Transfer Objects (Forms)
Les formulaires Symfony transforment les données entre:
- Modèle (Entity)
- Vue (Template)
- Requête HTTP

## Flux de Données pour CREation d'Article

```
1. GET /admin/post/new
   → AdminPostController::new()
   → Crée Post vide
   → Crée formulaire avec PostFormType
   → Render form.html.twig

2. Utilisateur remplit et soumet

3. POST /admin/post/new
   → AdminPostController::new()
   → PostFormType traite les données
   → Valide les données
   → Si valide:
      - Définit author à getUser()
      - Persiste Post dans la BDD
      - Flush changes
      - Redirige vers list
   → Si invalide:
      - Réaffiche le formulaire avec erreurs
```

## Optimisations Implémentées

### Performance
- ✅ Route attributes au lieu de configuration YAML
- ✅ Lazy loading de la sécurité
- ✅ Requêtes optimisées avec Doctrine
- ✅ Cache de twig en production

### Sécurité
- ✅ Hachage des mots de passe bcrypt
- ✅ Protection CSRF sous Symfony
- ✅ Validation server-side complète
- ✅ Contrôle d'accès stricte au rôle

### Maintenabilité
- ✅ Séparation claire des responsabilités
- ✅ Réutilisation de templates avec inheritance
- ✅ Services injectés plutôt que singletons
- ✅ Fixtures pour données de test

## Considérations de Scalabilité

### Actuellement
- ✅ Monolite avec une seule base de données
- ✅ Session utilisateur stockée en fichier (var/)
- ✅ Pas de cache distribué

### Futur (Scaling)
- API REST séparée pour mobile
- Microservices (Auth, Posts, Comments séparés)
- Redis pour sessions distribuées
- Caching avec Varnish ou Redis
- CDN pour asset statiques

## Stack Technologique

```
┌─────────────────────────────────────┐
│     Frontend (Bootstrap 5.3)        │
│   HTML5 + CSS3 + JavaScript         │
└────────────┬────────────────────────┘
             │
┌────────────▼────────────────────────┐
│   Symfony 7.4 Applications Layer     │
│  Controllers, Services, EventListeners
└────────────┬────────────────────────┘
             │
┌────────────▼────────────────────────┐
│   Twig 3.23 (Template Engine)       │
└────────────┬────────────────────────┘
             │
┌────────────▼────────────────────────┐
│   Doctrine ORM 3.6                  │
│   Database Abstraction Layer        │
└────────────┬────────────────────────┘
             │
┌────────────▼────────────────────────┐
│   DBAL with SQLite Driver           │
└────────────┬────────────────────────┘
             │
┌────────────▼────────────────────────┐
│   SQLite Database (var/data.db)     │
└─────────────────────────────────────┘
```

## Fichiers de Configuration Clés

| Fichier | Objectif |
|---------|----------|
| `config/packages/security.yaml` | Authentification et autorisations |
| `config/packages/doctrine.yaml` | Configuration ORM |
| `config/packages/twig.yaml` | Configuration Twig |
| `.env` | Variables d'environnement locales |

## Extensibilité

Le projet est conçu pour être extensible :

### Ajouter une nouvelle entité
```bash
bin/console make:entity NewEntity
bin/console make:migration
bin/console doctrine:migrations:migrate
```

### Ajouter une nouvelle route
```php
#[Route('/new-route', name: 'app_new_route')]
public function newRoute(): Response { }
```

### Ajouter une nouvelle page
```php
// Controller
// Template dans templates/
// Ajouter route dans security.yaml si protégée
```

---

**Architecture: MVC Monolithique Symfony | ORM: Doctrine | Frontend: Bootstrap + Twig**
