# 🚀 MaPFMP - Gestion des Documents PFMP

MaPFMP est une application Web permettant aux lycéens de déposer et suivre leurs documents pour la période de formation en milieu professionnel (PFMP). L'objectif est d'automatiser et de simplifier le processus de collecte des documents tout en facilitant le suivi des dossiers par le Bureau des Entreprises (BDE).

## 📜 Fonctionnalités
- 📂 **Dépôt sécurisé des documents** (PDF, JPG, PNG)
- ✅ **Validation automatique** des documents requis
- 📊 **Suivi des dossiers** avec indicateur (Feu rouge / Feu vert)
- 🔔 **Notifications et rappels** pour les documents manquants
- 🔐 **Authentification sécurisée** via ENT ou formulaire
- ☁️ **Stockage Cloud sécurisé**
- 📱 **Compatible Web & Android (future version)**

---

## 🛠️ Technologies utilisées
### **Frontend**
- 🌐 HTML5, CSS3 (Bootstrap/Tailwind)
- 🎨 JavaScript (Vue.js ou React)

### **Backend**
- 🐘 PHP (Laravel) / Node.js (NestJS)
- 🗄️ Base de données MySQL / MariaDB

### **Sécurité**
- 🔑 Authentification sécurisée
- 🔒 RGPD & cryptage des données
- 🔍 Vérification des fichiers uploadés

---

## 🚀 Installation et déploiement

### Prérequis 📌
- PHP 8.x & Composer
- Node.js & npm/yarn (si applicable)
- MySQL / MariaDB
- Serveur Apache/Nginx

### Étapes d'installation 🛠️

1. **Cloner le projet** :
   ```sh
   git clone https://github.com/VOTRE-UTILISATEUR/MaPFMP.git
   cd MaPFMP
   ```

2. **Installer les dépendances** :
   ```sh
   composer install
   npm install # ou yarn install
   ```

3. **Configurer l’environnement** :
   Copier `.env.example` en `.env` et modifier les valeurs :
   ```sh
   cp .env.example .env
   ```

   Modifier les variables de connexion à la base de données :
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mapfmp
   DB_USERNAME=root
   DB_PASSWORD=yourpassword
   ```

4. **Générer la clé d'application** :
   ```sh
   php artisan key:generate
   ```

5. **Migrer la base de données** :
   ```sh
   php artisan migrate --seed
   ```

6. **Lancer le serveur de développement** :
   ```sh
   php artisan serve
   ```

---

## 📖 Documentation
- [📄 Guide utilisateur](docs/user-guide.md)
- [⚙️ Guide d'installation](docs/installation.md)
- [💻 API Documentation](docs/api-docs.md)

---

## 🛠️ Contribution
1. Forker le projet
2. Créer une branche `feature/ma-nouvelle-fonctionnalité`
3. Faire un commit avec un message clair
4. Soumettre une Pull Request 🎉

---

## 📄 Licence
Ce projet est sous licence **MIT**. Consultez le fichier [LICENSE](LICENSE) pour plus de détails.

---

### 📩 Contact
📧 **Email :** support@mapfmp.com  
🌍 **Site Web :** [mapfmp.com](https://mapfmp.com)  
📣 **Discord :** [Rejoindre la communauté](https://discord.gg/xxxxxx)

---

Merci de votre intérêt pour MaPFMP ! 🚀🎯
