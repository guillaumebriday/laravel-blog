[![build status](https://gitlab.com/guillaumebriday/laravel-blog/badges/master/build.svg)](https://gitlab.com/guillaumebriday/laravel-blog/commits/master)

# Laravel 5.4 blog

The purpose of this repository is to show good development practices on [Laravel](http://laravel.com/) as well as to present cases of use of the framework's functionalities like :

- [Localization](https://laravel.com/docs/5.4/localization)
- [Jobs & Queues](https://laravel.com/docs/5.4/queues)
- [Migrations](https://laravel.com/docs/5.4/migrations)
- [Seeding & Factories](https://laravel.com/docs/5.4/seeding)
- [Testing](https://laravel.com/docs/5.4/testing)
- [Blade](https://laravel.com/docs/5.4/blade)
- [Policies](https://laravel.com/docs/5.4/authorization)
- [Providers](https://laravel.com/docs/5.4/providers)
- [Requests](https://laravel.com/docs/5.4/validation#form-request-validation)
- [Helpers](https://laravel.com/docs/5.4/helpers)
- [Mail](https://laravel.com/docs/5.4/mail)
- [Cache](https://laravel.com/docs/5.4/cache)

## Installation

You can use [Laravel homestead](https://laravel.com/docs/5.4/homestead) to setup your local development environment. On other environment, make sure the [default requirements](https://laravel.com/docs/5.4#installation) are available.

## Before starting

```
$ composer install
$ npm install
$ php artisan migrate
```

## Useful commands

Running tests :
```
$ ./vendor/bin/phpunit
```

Running php-cs-fixer :
```
$ ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

Compiling assets :
```
$ npm run dev
```

Running seeders :
```
$ php artisan db:seed
```

This will create a new user that you can use to sign in.
Email : ```darthvader@deathstar.ds```
Password : ```4nak1n```

Generating fake data :
```
$ php artisan db:seed --class=DevDatabaseSeeder
```

Running the queue worker :
```
$ php artisan queue:work
```

Starting job for newsletter :
```
$ php artisan tinker
> dispatch(new App\Jobs\PrepareNewsletterSubscriptionEmail());
```

## More details

More details are available or to come on [Guillaume Briday's blog](https://blog.guillaumebriday.fr) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
