# SortiesENI.com

Projet Symfony 5 débuté pendant la formation à l'ENI et toujours en cours de développement. Site d'organisations de
sorties entre personnes de l'école.

## Installation

Installation du serveur web Apache, PHP 7.3.22, base de données MySQL, phpMyAdmin et swiftMailer via [MailDev](https://maildev.github.io/maildev/).

Installation de l'application Symfony.

```bash
cd /path/to/project

composer update
npm install --force
npm install -g maildev
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

## Commandes utiles

Lancer le serveur pour MailDev (localhost:1080 par défaut) :

```bash
mailDev
```

Initialiser le manifest.json de webpack Encore :

```bash
npm run dev-server
```

Mise à jour de la base de données :

```bash
php bin/console doctrine:schema:update --force
```

Mettre en place le jeu de données :

```bash
php bin/console doctrine:fixtures:load
```