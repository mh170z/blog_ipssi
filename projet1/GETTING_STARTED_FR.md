# 🎯 GUIDE DE DÉMARRAGE - Mini Blog Symfony

Bienvenue ! Ce guide vous aidera à démarrer rapidement avec le Mini Blog.

---

## ⚡ En 5 Minutes

### Étape 1 : Installation
```bash
cd /Users/mohamed/workspace/ipsi/projet1
composer install --ignore-platform-req=ext-redis
```

### Étape 2 : Base de Données
```bash
bin/console doctrine:fixtures:load --no-interaction
```

### Étape 3 : Démarrage
```bash
php -S 127.0.0.1:8000 -t public
```

### Étape 4 : Accès
```
http://localhost:8000
Admin: admin@blog.com / admin123
```

**Voilà ! L'application fonctionne ! 🎉**

---

## 🌐 Accéder à l'Application

Une fois le serveur lancé, ouvrez votre navigateur et allez à :
```
http://localhost:8000
```

Vous verrez la page d'accueil du blog avec les articles disponibles.

---

## 👤 Se Connecter

### Option 1 : Utiliser un Compte de Test
Cliquez sur "Login" et utilisez :
- **Email** : `admin@blog.com`
- **Mot de passe** : `admin123`

### Option 2 : Créer un Nouveau Compte
1. Cliquez sur "Register"
2. Remplissez le formulaire
3. Cliquez sur "Register"
4. Vous serez redirigé vers la page de connexion
5. Connectez-vous avec votre nouveau compte

---

## 📝 Ce que Vous Pouvez Faire

### Visiteur (Non Connecté)
✅ Voir la page d'accueil  
✅ Lire les articles  
✅ Voir les commentaires  
✅ S'inscrire  

### Utilisateur (Connecté)
✅ Toutes les actions du visiteur  
✅ **Ajouter des commentaires** sur les articles  
✅ Voir son nom d'utilisateur en haut  
✅ Se déconnecter  

### Administrateur (Connecté en tant qu'Admin)
✅ Toutes les actions de l'utilisateur  
✅ **Créer des articles**  
✅ **Éditer/supprimer des articles**  
✅ **Gérer les catégories**  
✅ Accéder au **Panneau Admin**  

---

## 📚 Lire un Article

1. Sur la page d'accueil, cliquez sur une carte d'article
2. Vous verrez le contenu complet
3. Les commentaires sont en bas
4. Si connecté, vous pouvez ajouter un commentaire

---

## 💬 Ajouter un Commentaire

1. Connectez-vous (si pas déjà fait)
2. Allez sur un article
3. Remplissez le formulaire de commentaire en bas
4. Cliquez "Post Comment"
5. Votre commentaire apparaîtra immédiatement

---

## ✍️ Créer un Article (Admin Seulement)

### Accéder à la Section Admin
1. Connectez-vous en tant qu'admin
2. Cliquez sur **"Admin"** dans le menu en haut
3. Sélectionnez **"Create Post"**

### Créer l'Article
1. Remplissez le **Titre**
2. Remplissez le **Contenu**
3. Sélectionnez une **Catégorie**
4. Entrez l'URL de l'**Image** (optionnel)
5. Cliquez **"Create Post"**

L'article apparaîtra immédiatement sur la page d'accueil !

---

## 🛠️ Gérer les Articles (Admin)

### Voir Tous les Articles
1. Admin → **Manage Posts**
2. Vous verrez un tableau avec tous les articles

### Modifier un Article
1. Aller sur **Manage Posts**
2. Cliquer sur **Éditer** (crayon) pour l'article
3. Modifier les informations
4. Cliquer **Save Changes**

### Supprimer un Article
1. Aller sur **Manage Posts**
2. Cliquer sur **Supprimer** (corbeille) pour l'article
3. Confirmer la suppression

---

## 🏷️ Gérer les Catégories (Admin)

1. Admin → **Categories**
2. Voir toutes les catégories
3. Créer, éditer, ou supprimer des catégories

**Catégories disponibles :**
- Technology
- Design
- Business
- Lifestyle
- Tutorial

---

## 👥 Comptes de Test Disponibles

| Rôle | Email | Mot de Passe |
|------|-------|-------------|
| Admin | admin@blog.com | admin123 |
| User | user1@blog.com | user123 |
| User | user2@blog.com | user123 |

---

## 🔐 Se Déconnecter

1. Cliquez sur votre **nom** en haut à droite
2. Sélectionnez **"Logout"**
3. Vous serez déconnecté et redirigé vers l'accueil

---

## 🆘 Problèmes Courants

### Le serveur ne démarre pas
```bash
# Vérifier PHP
php --version

# Essayer un port différent
php -S 127.0.0.1:8080 -t public
```

### Page 404 ou erreur
```bash
# Vider le cache
bin/console cache:clear

# Redémarrer le serveur
```

### Base de données manquante
```bash
# Recréer les données
bin/console doctrine:fixtures:load --no-interaction
```

### Erreur de permission
```bash
# Donner les permissions
chmod -R 755 var/
```

---

## 💡 Conseils et Astuces

### Navigation
- 🏠 **Cliquer sur le logo** en haut à gauche pour revenir à l'accueil
- 📱 **L'interface est responsive** et fonctionne sur mobile
- 🎨 **Le design est moderne** avec Bootstrap 5.3

### Données de Test
- 5 articles d'exemple sont pré-créés
- 5 catégories sont disponibles
- Les commentaires sont auto-approuvés
- Vous pouvez ajouter vos propres articles

### Supprimer Tous les Données
```bash
rm -f var/data.db
bin/console doctrine:migrations:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
```

---

## 📖 Documentation Supplémentaire

Pour plus d'informations :

- 📘 **README.md** - Guide complet
- ⚡ **QUICKSTART.md** - Démarrage rapide
- 📚 **INDEX.md** - Guide de navigation
- 🔧 **INSTALLATION.md** - Installation détaillée
- 🗺️ **API_ROUTES.md** - Routes disponibles
- 🏗️ **ARCHITECTURE.md** - Architecture technique
- ✨ **FEATURES.md** - Liste des fonctionnalités

---

## 🎓 Apprendre le Code

Si vous voulez comprendre comment fonctionne l'application :

1. Consultez **ARCHITECTURE.md** pour l'overview
2. Regardez les fichiers dans `src/Controller/`
3. Explorez les templates dans `templates/`
4. Étudiez les entités dans `src/Entity/`

---

## 🚀 Prochaines Étapes

1. ✅ Démarrer l'application (vous venez de le faire !)
2. ✅ Explorer les articles
3. ✅ Créer un compte
4. ✅ Ajouter un commentaire
5. ✅ Créer un article (si admin)
6. ✅ Lire la documentation complète

---

## ✨ Caractéristiques Clés

- 🔓 **Authentification sécurisée** - Inscription et connexion
- 📰 **Blog complet** - CRUD articles, commentaires, catégories
- 🎨 **Interface moderne** - Bootstrap 5.3, responsive
- 🔐 **Sécurité** - CSRF, validation, hachage des mots de passe
- 👥 **Rôles multiples** - Admin et User
- 💾 **Base de données** - SQLite avec fixtures
- 📚 **Documentation complète** - 9 fichiers Markdown

---

## 🎉 Vous Êtes Prêt !

Commencez à explorer le Mini Blog ! Si vous avez des questions, consultez la documentation.

**Bon développement ! 🚀**

---

*Mini Blog Symfony - 12 février 2026*
