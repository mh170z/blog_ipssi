# 🚀 QUICKSTART - Lancer l'application en 5 minutes

## Installation Rapide

### 1️⃣ Installer les dépendances (1 minute)
```bash
cd /Users/mohamed/workspace/ipsi/projet1
composer install --ignore-platform-req=ext-redis
```

### 2️⃣ Configurer la base de données (30 secondes)
```bash
# Les migrations sont déjà appliquées
# Charger les données de test
bin/console doctrine:fixtures:load --no-interaction
```

### 3️⃣ Démarrer le serveur (10 secondes)
```bash
php -S 127.0.0.1:8000 -t public
```

### 4️⃣ Ouvrir dans le navigateur
```
http://localhost:8000
```

### 5️⃣ Se connecter avec les données de test
```
Email: admin@blog.com
Mot de passe: admin123
```

---

## 🎯 Actions Rapides

### Créer un article (Admin)
1. Se connecter en tant qu'admin
2. Cliquer sur **Admin → Create Post**
3. Remplir le formulaire
4. Cliquer **Create Post**

### Ajouter un commentaire (Utilisateur)
1. Se connecter ou s'inscrire
2. Aller sur un article
3. Compléter le formulaire de commentaire
4. Cliquer **Post Comment**

### Voir la liste d'articles (Admin)
1. Cliquer **Admin → Manage Posts**
2. Voir, éditer ou supprimer un article

---

## 📚 Comptes de Test Disponibles

| Rôle | Email | Mot de passe |
|------|-------|-------------|
| Admin | admin@blog.com | admin123 |
| User | user1@blog.com | user123 |
| User | user2@blog.com | user123 |

---

## 🔧 Commandes Utiles

```bash
# Vider le cache
bin/console cache:clear

# Régénérer les fixtures
bin/console doctrine:fixtures:load --no-interaction

# Vérifier la base de données
bin/console doctrine:database:create --if-not-exists

# Lister les routes disponibles
bin/console debug:router
```

---

## 📁 Structure Clés

```
projet1/
├── public/               # Entrée web (index.php)
├── src/
│   ├── Controller/      # Logique métier
│   ├── Entity/          # Modèles de données (User, Post, etc.)
│   └── Form/            # Formulaires Symfony
├── templates/           # Vues Twig + Bootstrap
├── config/              # Configuration
└── var/
    └── data.db         # Base de données SQLite
```

---

## ❓ Dépannage Rapide

### "Connection refused" port 8000
```bash
# Utiliser un autre port
php -S 127.0.0.1:8080 -t public
```

### Erreur de base de données
```bash
# Réinitialiser la base de données
rm -f var/data.db
bin/console doctrine:migrations:migrate --no-interaction
bin/console doctrine:fixtures:load --no-interaction
```

### Erreur 404 sur les routes
```bash
# Vider le cache
bin/console cache:clear
```

---

## 📖 Documentation Complète

- **README.md** : Vue d'ensemble du projet
- **INSTALLATION.md** : Instructions d'installation détaillées
- **API_ROUTES.md** : Documentation des routes
- **ARCHITECTURE.md** : Architecture et design
- **FEATURES.md** : Liste complète des fonctionnalités

---

## 🎉 C'est prêt !

Accédez à `http://localhost:8000` et explorez le blog !

**Besoin d'aide ?** Consultez la documentation complète dans les fichiers `.md`.

---

*Mini Blog - Symfony 7.4 with Bootstrap 5.3*
