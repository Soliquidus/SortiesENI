# SortiesENI.com (Français)

Projet Symfony 5 débuté pendant la formation à l'ENI et toujours en cours de développement. Site d'organisations de
sorties entre personnes de l'école.

## Installation

Installation du serveur web Apache, PHP 7.3.22, base de données MySQL, phpMyAdmin et swiftMailer via [MailDev](https://maildev.github.io/maildev/).

Installation de l'application Symfony :

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

# SortiesENI.com (English)

Symfony 5 project started during my training at ENI School and still in development. Event organization website
between students from a same school.

## Installation

Apache web server installation, PHP 7.3.22, MySQL database, phpMyAdmin and swiftMailer with [MailDev](https://maildev.github.io/maildev/).

Symfony's application installation :

```bash
cd /path/to/project

composer update
npm install --force
npm install -g maildev
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

## Useful commands

Launch MailDev server (default => localhost:1080) :

```bash
mailDev
```

Initialize manifest.json for Webpack Encore :

```bash
npm run dev-server
```

Database update :

```bash
php bin/console doctrine:schema:update --force
```

Push data in the database :

```bash
php bin/console doctrine:fixtures:load
```