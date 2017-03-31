[![build status](https://gitlab.com/guillaumebriday/laravel-blog/badges/master/build.svg)](https://gitlab.com/guillaumebriday/laravel-blog/commits/master)

# Laravel 5.4 blog

The purpose of this repository is to show good development practices on [Laravel](http://laravel.com/) as well as to present cases of use of the framework's functionalities like :

- [Authentication](https://laravel.com/docs/5.4/authentication)
- API
  - Token authentication
  - [Transformers](http://fractal.thephpleague.com/transformers/)
  - Versioning
- [Blade](https://laravel.com/docs/5.4/blade)
- [Cache](https://laravel.com/docs/5.4/cache)
- [Filesystem](https://laravel.com/docs/5.4/filesystem)
- [Helpers](https://laravel.com/docs/5.4/helpers)
- [Jobs & Queues](https://laravel.com/docs/5.4/queues)
- [Localization](https://laravel.com/docs/5.4/localization)
- [Mail](https://laravel.com/docs/5.4/mail)
- [Migrations](https://laravel.com/docs/5.4/migrations)
- [Policies](https://laravel.com/docs/5.4/authorization)
- [Providers](https://laravel.com/docs/5.4/providers)
- [Requests](https://laravel.com/docs/5.4/validation#form-request-validation)
- [Seeding & Factories](https://laravel.com/docs/5.4/seeding)
- [Testing](https://laravel.com/docs/5.4/testing)

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

## Accessing the API

Clients can access to the REST API. API requests require authentication via token. You can create a new token in your user profil.

Then, you can use this token either as url parameter or in Authorization header :

```
# Url parameter
GET http://laravel-blog.dev/api/v1/posts?api_token=your_private_token_here

# Authorization Header
curl --header "Authorization: Bearer your_private_token_here" http://laravel-blog.dev/api/v1/posts
```

API are prefixed by ```api``` and the API version number like so ```v1```.

## More details

More details are available or to come on [Guillaume Briday's blog](https://blog.guillaumebriday.fr) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
