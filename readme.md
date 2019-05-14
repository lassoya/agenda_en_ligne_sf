# Gestion contact

## Prérequis
 - [ ] Ajouter **PHP**, **Mysql** dans vos variables d'environnement, cela permet de rendre **PHP** et **MySQL** accessible partout dans votre terminal [ici](https://blog.emmanuelgautier.fr/configurer-la-ligne-de-commande-php-sous-windows/)
 - [ ] Installer **composer** (Composer-Setup.exe) composer va vous servir à installer des dépendances (vendor) [ici](https://getcomposer.org/doc/00-intro.md#installation-windows)

## Installation un projet **Symfony**
- [ ] Documentation Symfony [ici](https://symfony.com/doc/current/best_practices/creating-the-project.html)

## Gestion des assets d'un projet (Webpack)**Symfony**
- [ ] Documentation Symfony [ici](https://symfony.com/doc/current/frontend.html)


## Commandes Webpack
- ```yarn encore dev --watch``` permet de recompiler les fichiers js et css à chaque modification

## Commandes Symfony de base

 - ``` bin/console server:run ``` permet de démarrer un serveur web
 - ``` bin/console debug:router ``` permet consulter l'ensemble des routes disponibles dans l'application
 - ``` doctrine:database:create ``` Permet de créer la base de données
 - ``` bin/console doctrine:schema:update ``` Execute les commandes permettants de mettre à jour la base de donnéees
 - ``` bin/console make:entity ``` permet de créer une entité doctrine
 - ``` bin/console make:controller ``` permet de créer un controller
