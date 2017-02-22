[![build status](https://gitlab.com/guillaumebriday/laravel-blog/badges/master/build.svg)](https://gitlab.com/guillaumebriday/laravel-blog/commits/master)

# Laravel 5.4 blog

Ce dépôt a pour vocation de montrer les bonnes pratiques de développement sur [Laravel](http://laravel.com/) ainsi que de presenter plusieurs cas concrets d'utilisations des fonctionnalités du framework comme :

- [La localisation](https://laravel.com/docs/5.4/localization)
- [La programmation parallèle et asynchrone (Queue)](https://laravel.com/docs/5.4/queues)
- [Les migrations](https://laravel.com/docs/5.4/migrations)
- [Les seeds & factories](https://laravel.com/docs/5.4/seeding)
- [Les tests](https://laravel.com/docs/5.4/testing)
- [Les templates, partials et components](https://laravel.com/docs/5.4/blade)
- [Les policies](https://laravel.com/docs/5.4/authorization)
- [Les providers](https://laravel.com/docs/5.4/providers)
- [Les requests](https://laravel.com/docs/5.4/validation#form-request-validation)
- [Les helpers](https://laravel.com/docs/5.4/helpers)
- [Les mails](https://laravel.com/docs/5.4/mail)
- [Le cache](https://laravel.com/docs/5.4/cache)

## Informations

L'application est prévue pour être internationalisé. Actuellement, seule la traduction française est disponible.

## Installation

Vous pouvez utiliser [Laravel homestead](https://laravel.com/docs/5.4/homestead) pour installer le projet sur un environnement local.

## Quelques commandes

Initialisation du projet :
```
$ composer install
$ npm install
$ php artisan migrate
```

Lancer les tests :
```
$ ./vendor/bin/phpunit
```

Lancer php-cs-fixer :
```
$ ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

Construire les assets :
```
$ npm run dev
```

Lancer les seeds :
```
$ php artisan db:seed
```

Cela aura pour effet de créer un utilisateur. Vous pourrez alors l'utiliser pour vous connecter à l'application :
Identifiant : ```darthvader@deathstar.ds```
Mot de passe : ```4nak1n```

Créer des données de tests :
```
$ php artisan db:seed --class=DevDatabaseSeeder
```

Lancer le worker de queue :
```
$ php artisan queue:work
```

Lancer le job pour la newsletter :
```
$ php artisan tinker
> dispatch(new App\Jobs\PrepareNewsletterSubscriptionEmail());
```

## Plus de détails

Plus de détails sont disponibles ou à venir sur [le blog de Guillaume Briday](https://blog.guillaumebriday.fr).

## Todo

- [ ] Migrer les tests vers la syntaxe de laravel 5.4
- [ ] Rajouter des tests
- [ ] Répondre à un commentaire
- [ ] Ajouter une sécurité sur la newsletter
- [ ] Ajouter la traduction en anglais et adapter les routes

## Contribution

N'hésitez pas à contribuer au projet en l'adaptant ou en y ajoutant des fonctionnalités ! Ouvrez des issues ou faites des Pull Requets, c'est fait pour.

## License

Ce projet est une application open-source sous licence [MIT](http://opensource.org/licenses/MIT).
