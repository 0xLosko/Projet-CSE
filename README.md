# Projet-CSE
L’application permet aux visiteurs du site d’obtenir des informations sur les offres sociales et culturelles proposées, par le CSE du lycée St-Vincent, à ses salariés.


## Stack technique
* [HTML/TWIG](https://developer.mozilla.org/fr/docs/Web/HTML)
* [CSS](https://developer.mozilla.org/fr/docs/Web/CSS)
* [Symfony](https://symfony.com/) - Le framework web utilisé pour développer l'application
* [JavaScript](https://developer.mozilla.org/fr/docs/Web/JavaScript) - Le langage de programmation utilisé pour créer des fonctionnalités interactives côté client
* [MySQL](https://dev.mysql.com/doc/) - La base de données relationnelle utilisée pour stocker les données de l'application.


## Prérequis
- PHP 8.1 ou une version supérieure.

- Composer : Composer est un gestionnaire de dépendances pour PHP. Vous pouvez télécharger Composer à partir de getcomposer.org.

- MySQL : Symfony utilise une base de données relationnelle pour stocker les données de l'application. Vous pouvez installer MySQL à partir de mysql.com.

- Un serveur Web : Symfony peut être exécuté sur n'importe quel serveur Web compatible avec PHP, tel que Apache ou Nginx. Si vous n'en avez pas déjà un installé, vous pouvez installer Wamp (pour Windows), Mamp (pour Mac) ou Xampp (pour Windows, Mac et Linux).

Une fois que vous avez installé les prérequis ci-dessus, vous pouvez suivre les instructions d'installation spécifiques pour votre application Symfony.

## Installation
Voici les étapes pour installer l'application :

1. [Téléchargez le zip à partir de Git](https://github.com/Projet-CSE/archive/main.zip) et décompressez-le dans le répertoire de votre choix.

2. Ouvrez un terminal et accédez au répertoire du projet décompressé.

3. Lancez la commande `composer install` pour installer les dépendances requises pour l'application.

4. Si nécessaire, modifiez le fichier `.env` pour fournir les informations de connexion correctes à votre base de données.

5. Lancez la commande "php bin/console doctrine:database:create" pour créer la base de données.

6. Ensuite, lancez la commande "php bin/console doctrine:migrations:migrate" pour exécuter les migrations.

7. Pour démarrer le serveur Symfony, exécutez la commande `symfony server:start`.

Après avoir exécuté ces étapes, vous devriez être en mesure d'accéder à l'application en ouvrant votre navigateur Web et en visitant `http://localhost:8000` (ou une autre adresse fournie par Symfony).


## Jeu de données
ici jdd



## Contributeurs

* **Losko** - *Full stack* - [GITHUB](https://github.com/0xLosko)
* **Tducrocq** - *Full stack* - [GITHUB](https://github.com/Tdcrq)

