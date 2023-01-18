![image_search_api](https://i.postimg.cc/tRDnkmVc/petittheatreruelle.png)

<h1 align="center">Final Symfony Project</h1>

![image search api](https://i.postimg.cc/s3bQTWv3/2023-01-18-23-29-31-Petit-Th-atre-de-la-Ruelle.png)


### Installation

```bash
git clone https://github.com/AnthonyDel28/Theater.git
```
```bash
composer install
```
Créez la database, et ensuite faites un load des fixtures

## Contenu
- Site destiné à un Théâtre 

###Page d'accueil : :house:
- Navbar Responsive 
- Slider dynamique 
- Les 4 news les plus récentes 
- Widgets et un footer  

###Page des spectacles :accordion:
- Tous les spectacles de cette année
- Tous les comédiens de chaque spectacle
- Un bouton pour acheter un Ticket (ne sera pas déployé en ligne)
- Un widget pour partager le post sur facebook
- Un formulaire pour écrire un commentaire  

###Page des actualités :page_with_curl:
- Toutes les news
- Un bouton pour partager la news sur facebook
- Un bouton pour liker / disliker la news
- Un formulaire pour écrire un commentaire  

### Page de connexion et d'inscription :e-mail:
- Informations utiles
- Tarifs  

### Page de connexion et d'inscription :e-mail:
- Formulaire de contact (permettant d'envoyer un mail directement au Théâtre)  
  (En local les emails seront interceptés par mailtrap)  

### Page de connexion et d'inscription :e-mail:
- Formulaires de connexion et d'inscription, protégés par un captcha Google
- Envoi de mail de confirmation à l'inscription, template ultra design à l'image du Théâtre
- Fonction "Mot de passe oublié?" 100% fonctionnelle par Token & Email  

### Page de profil
- Photo de profil (et formulaire pour la modifier)
- Informations du compte (et formulaire pour les modifier)
- Liste des commentaires écrits par l'user
- Liste des tickets achetés par l'user, permettant de les télécharger en PDF  

###Administration :black_nib:
- Page d'administration affichant un message de bienvenue et quelques stats
- Permet de gérer les spectacles, les comédiens, les news, les commentaires, les users,
les tickets
- Permet de lister les emails reçus et envoyés
- Permet d'écrire un email avec un template à l'image du Théâtre
- Permet de changer les sliders, leurs images et leur ordre ainsi que la caption  

###Autre :desktop_computer:
- Les pages d'erreur ont été customisées (visible uniquement en prod)
- La fonction d'achat de ticket ne sera pas déployée sur le domaine
- Toutes les fonctions de mail ne seront pas visibles à 100% en mode Dev


![Symfony](https://img.shields.io/badge/Symfony-V6-red)
![Bootstrap](https://img.shields.io/badge/Bootstrap-V5-blue)
![PHPSTORM](https://img.shields.io/badge/PhpStorm-IDE-purple)
![JavaScript](https://img.shields.io/badge/JavaScript-JS-green)

###Ce site sera déployé d'ici quelques jours sur l'adresse suivante:
##www.petittheatredelaruelle.be

Made with :heart: by Anthony D.
