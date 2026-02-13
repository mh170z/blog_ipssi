# Documentation des Routes

## Routes Publiques (Accessibles sans connexion)

### Page d'Accueil
```
GET /
Template: blog/index.html.twig
Description: Affiche la liste de tous les articles publiés
```

### Détail d'un Article
```
GET /post/{id}
Template: blog/detail.html.twig
Parameters:
  - id: integer - ID de l'article
Description: Affiche le contenu complet d'un article avec les commentaires
```

### Inscription
```
GET /register
Template: auth/register.html.twig
Description: Formulaire d'inscription pour créer un nouveau compte

POST /register
Template: auth/register.html.twig
Form Data:
  - email: string - Adresse email (unique)
  - firstName: string - Prénom
  - lastName: string - Nom
  - plainPassword: string - Mot de passe (min 6 caractères)
  - agreeTerms: boolean - Acceptation des conditions
Redirect: /login après succès
```

### Connexion
```
GET /login
Template: auth/login.html.twig
Description: Formulaire de connexion

POST /login
Form Data:
  - email: string - Adresse email
  - password: string - Mot de passe
  - _remember_me: boolean - Mémoriser la connexion (optionnel)
Redirect: Page précédente ou à la page d'accueil après succès
```

### Déconnexion
```
GET /logout
Description: Déconnecte l'utilisateur et redirige vers l'accueil
Requires: Authentification (ROLE_USER)
```

---

## Routes Protégées - Utilisateurs Connectés

### Ajouter un Commentaire
```
POST /comment/add/{id}
Parameters:
  - id: integer - ID du post sur lequel ajouter le commentaire
Form Data:
  - comment_form[content]: string - Contenu du commentaire
Requires: ROLE_USER
Redirect: /post/{id} après succès
```

### Supprimer un Commentaire (Admin seulement)
```
POST /comment/delete/{id}
Parameters:
  - id: integer - ID du commentaire à supprimer
Requires: ROLE_ADMIN
Redirect: Page précédente après succès
```

---

## Routes Administrateur

### Lister les Articles
```
GET /admin/post
Template: admin/post/list.html.twig
Requires: ROLE_ADMIN
Description: Affiche la liste de tous les articles avec actions de modification/suppression
```

### Créer un Nouvel Article
```
GET /admin/post/new
Template: admin/post/form.html.twig
Requires: ROLE_ADMIN
Description: Formulaire de création d'article

POST /admin/post/new
Form Data:
  - post_form[title]: string - Titre de l'article (requis)
  - post_form[content]: text - Contenu (requis)
  - post_form[picture]: url - URL de l'image (optionnel)
  - post_form[category]: integer - ID de la catégorie (requis)
Requires: ROLE_ADMIN
Redirect: /admin/post après succès
```

### Éditer un Article
```
GET /admin/post/{id}/edit
Template: admin/post/form.html.twig
Parameters:
  - id: integer - ID de l'article
Requires: ROLE_ADMIN
Description: Formulaire d'édition d'article

POST /admin/post/{id}/edit
Parameters:
  - id: integer - ID de l'article
Form Data: (même que la création)
Requires: ROLE_ADMIN
Redirect: /admin/post après succès
```

### Supprimer un Article
```
POST /admin/post/{id}/delete
Parameters:
  - id: integer - ID de l'article
Requires: ROLE_ADMIN
Redirect: /admin/post après succès
```

### Gérer les Catégories
```
GET /admin/category
Template: admin/category/list.html.twig
Requires: ROLE_ADMIN
Description: Affiche la liste des catégories avec options de gestion
```

---

## Codes de Statut HTTP

| Code | Signification |
|------|--------------|
| 200 | OK - Requête réussie |
| 301 | Redirection permanente |
| 302 | Redirection temporaire |
| 400 | Erreur de requête |
| 401 | Non authentifié |
| 403 | Accès interdit (rôle insuffisant) |
| 404 | Ressource non trouvée |
| 500 | Erreur serveur |

---

## Parameters par Route

### IDs Dynamiques
- `{id}` : Identifiant unique (integer) pour un article, utilisateur ou commentaire

### Paramètres de Formulaires Symfony
```
form_name[field_name]: valeur
```

Exemple :
```
post_form[title]: "Mon Article"
post_form[category]: 1
comment_form[content]: "Mon commentaire"
```

---

## Redirections Automatiques

| Scénario | De | Vers |
|----------|----|----|
| Utilisateur connecté accède /login | /login | / |
| Utilisateur connecté accède /register | /register | / |
| Non connecté accède /admin/* | /admin/* | /login |
| Non connecté accède /comment/* | /comment/* | /login |
| Inscription réussie | /register | /login |
| Création d'article réussie | /admin/post/new | /admin/post |
| Suppression réussie | /admin/post | /admin/post |
| Commentaire ajouté | /comment/add/{id} | /post/{id} |

---

## Exemples d'Utilisation

### Créer un Article
```bash
# 1. Se connecter d'abord
curl -c cookies.txt -X POST http://localhost:8000/login \
  -d "email=admin@blog.com&password=admin123&_remember_me=1"

# 2. Créer l'article
curl -b cookies.txt -X POST http://localhost:8000/admin/post/new \
  -d "post_form[title]=Mon Article&post_form[content]=Contenu..." \
  -d "post_form[category]=1"
```

### Ajouter un Commentaire
```bash
curl -b cookies.txt -X POST http://localhost:8000/comment/add/1 \
  -d "comment_form[content]=Super article!"
```

---

## Messages Flash (Notifications)

L'application utilise les messages flash Symfony pour informer l'utilisateur :

- **success** : Action complétée avec succès
- **error** : Une erreur s'est produite
- **warning** : Avertissement
- **info** : Information générale

Exemple :
```
Registration successful! Please log in.
Post created successfully!
Comment deleted!
```

---

## Validation des Formulaires

### Inscription
- Email : requis, format email, unique
- Prénom : requis, max 100 caractères
- Nom : requis, max 100 caractères
- Mot de passe : requis, min 6 caractères
- Conditions : requis, doit être coché

### Article
- Titre : requis, max 255 caractères
- Contenu : requis
- Catégorie : requise
- Image : optionnelle, doit être une URL valide

### Commentaire
- Contenu : requis, min 1 caractère

---

## Versioning de l'API

La version actuelle est **v1.0.0** de l'API non-REST.

Prochaine version : Implémentation d'une API REST avec versioning `/api/v1/`.

---

## Sécurité

- Tous les mots de passe sont hachés avec bcrypt
- Les tokens CSRF protègent les formulaires
- Les rôles sont vérifiés server-side
- Les routes sensibles requièrent l'authentification
- Sessions utilisateur persistantes

---

**Pour plus de détails, consultez le README.md ou INSTALLATION.md**
