# Projet de test

- [Projet de test](#projet-de-test)
  - [Environnement de travail: Docker](#environnement-de-travail-docker)
  - [Sujet](#sujet)
    - [Ressource](#ressource)
    - [Formulaire](#formulaire)
    - [Pour allez plus loin](#pour-allez-plus-loin)

## Environnement de travail: Docker

Le projet fourni un environnement de travail sous docker permettant de déployer un serveur Apache2+PHP8 pour lancer l'application ainsi qu'une base de données Mysql.

(Les informations suivantes sont données pour un environnement linux)

Prérequis:

* docker
* docker-compose

Installer docker et docker-compose sur votre machine:

https://docs.docker.com/engine/install/ubuntu/#install-using-the-repository

https://docs.docker.com/engine/install/linux-postinstall/#manage-docker-as-a-non-root-user

https://docs.docker.com/engine/install/linux-postinstall/#configure-docker-to-start-on-boot

https://docs.docker.com/compose/install/#install-compose-on-linux-systems

https://docs.docker.com/compose/completion/#install-command-completion

Lancer le container Docker:

```
$ docker-compose up -d --build
```

Installer les dépendances:

```
$ docker-compose exec app composer install
```

Ouvrir votre navigateur et vérifier que l'application est lancée:

http://localhost:8080/

L'environnement monte un volume permettant de partager les sources local avec le container. Vous pouvez donc travailler directement en local via votre IDE préféré et visualiser votre travail dans votre navigateur préféré.

Vous pouvez aussi monter un shell directement avec le container:

```
$ docker-compose exec app bash
```

## Sujet

Le but de l'exercice est de fournir un projet permettant de créer une ressource via un formulaire.

### Ressource

Vous devez créer une entité utilisant l'ORM Doctrine pour stocker les informations suivantes:

* title (string)
* author (string)
* date (date)
* summary (blob)
* isbn13 (digit)
* url (url)

Cette ressource sera nommée `Book`.

Les champs sont tous obligatoires sauf l'URL.

Il n'est pas possible d'avoir 2 `title` identiques en BDD.

Astuce: penser à utiliser la console Symfony ^^ (make:entity).

Penser à mettre à jour le schéma en BDD:

```
bin/console doctrine:schema:update --force
```

### Formulaire

En utilisant les templates Twig, vous fournissez une page avec un formulaire permettant de créer la ressource ci-dessus.

* afficher une erreur si un champ est manquant
* afficher une erreur si le livre existe déjà

Astuce: penser à utiliser la console Symfony ^^ (make:controller & make:form).

### Pour allez plus loin

Si vous voulez aller plus loin et nous montrer votre savoir faire (optionnel):

* ajouter une page permettant de lister les ressources déjà créées
* utilisation de Bootstrap ou autre framework
* modification et suppression d'une ressource
* pagination
* utilisation de git pour sauver votre travail
* tests
* ...