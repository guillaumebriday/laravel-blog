# Laravel 5.6 blog

[![Build Status](https://travis-ci.org/guillaumebriday/laravel-blog.svg?branch=master)](https://travis-ci.org/guillaumebriday/laravel-blog)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/guillaumebriday)

The purpose of this repository is to show good development practices on [Laravel](http://laravel.com/) as well as to present cases of use of the framework's functionalities like :

- [Authentication](https://laravel.com/docs/5.6/authentication)
- API
  - Token authentication
  - [API Resources](https://laravel.com/docs/5.6/eloquent-resources)
  - Versioning
- [Blade](https://laravel.com/docs/5.6/blade)
- [Broadcasting](https://laravel.com/docs/5.6/broadcasting)
- [Cache](https://laravel.com/docs/5.6/cache)
- [Filesystem](https://laravel.com/docs/5.6/filesystem)
- [Helpers](https://laravel.com/docs/5.6/helpers)
- [Horizon](https://laravel.com/docs/5.6/horizon)
- [Localization](https://laravel.com/docs/5.6/localization)
- [Mail](https://laravel.com/docs/5.6/mail)
- [Migrations](https://laravel.com/docs/5.6/migrations)
- [Policies](https://laravel.com/docs/5.6/authorization)
- [Providers](https://laravel.com/docs/5.6/providers)
- [Requests](https://laravel.com/docs/5.6/validation#form-request-validation)
- [Seeding & Factories](https://laravel.com/docs/5.6/seeding)
- [Testing](https://laravel.com/docs/5.6/testing)

Beside Laravel, this project uses other tools like :

- [Bootstrap 4](https://getbootstrap.com/)
- [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)
- [Travis CI](https://travis-ci.org/)
- [Font Awesome](http://fontawesome.io/)
- [Vue.js](https://vuejs.org/)
- [axios](https://github.com/mzabriskie/axios)
- [Redis](https://redis.io/)
- [spatie/laravel-medialibrary](https://github.com/spatie/laravel-medialibrary)
- Many more to discover.

## Some screenshots

You can find some screenshots of the application on : [https://imgur.com/a/Jbnwj](https://imgur.com/a/Jbnwj)

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/guillaumebriday/laravel-blog.git
$ cd laravel-blog
$ cp .env.example .env
$ docker-compose run --rm --no-deps blog-server composer install
$ docker-compose run --rm --no-deps blog-server php artisan key:generate
$ docker-compose run --rm --no-deps blog-server php artisan vendor:publish --provider="Laravel\Horizon\HorizonServiceProvider"
$ docker-compose run --rm --no-deps blog-server php artisan storage:link
$ docker run --rm -it -v $(pwd):/app -w /app node npm install
$ docker-compose up -d
```

Now you can access the application via [http://localhost:8000](http://localhost:8000).

**There is no need to run ```php artisan serve```. PHP is already running in a dedicated container.**

## Before starting
You need to run the migrations with the seeds :
```
$ docker-compose run --rm blog-server php artisan migrate --seed
```

This will create a new user that you can use to sign in :
```
Email : darthvader@deathstar.ds
Password : 4nak1n
```

And then, compile the assets :
```
$ docker run --rm -it -v $(pwd):/app -w /app node npm run dev
```

Starting job for newsletter :
```
$ docker-compose run blog-server php artisan tinker
> PrepareNewsletterSubscriptionEmail::dispatch();
```

## Useful commands
Seeding the database :
```
$ docker-compose run --rm blog-server php artisan db:seed
```

Running tests :
```
$ docker-compose run --rm blog-server ./vendor/bin/phpunit
```

Running php-cs-fixer :
```
$ docker-compose run --rm --no-deps blog-server ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

Generating backup :
```
$ docker-compose run --rm blog-server php artisan backup:run
```

Generating fake data :
```
$ docker-compose run --rm blog-server php artisan db:seed --class=DevDatabaseSeeder
```

Discover package
```
$ docker-compose run --rm --no-deps blog-server php artisan package:discover
```

In development environnement, rebuild the database :
```
$ docker-compose run --rm blog-server php artisan migrate:fresh --seed
```

## Accessing the API

Clients can access to the REST API. API requests require authentication via token. You can create a new token in your user profil.

Then, you can use this token either as url parameter or in Authorization header :

```
# Url parameter
GET http://laravel-blog.app/api/v1/posts?api_token=your_private_token_here

# Authorization Header
curl --header "Authorization: Bearer your_private_token_here" http://laravel-blog.app/api/v1/posts
```

API are prefixed by ```api``` and the API version number like so ```v1```.

Do not forget to set the ```X-Requested-With``` header to ```XMLHttpRequest```. Otherwise, Laravel won't recognize the call as an AJAX request.

To list all the available routes for API :

```bash
$ docker-compose run --rm --no-deps blog-server php artisan route:list --path=api
```

## More details

More details are available or to come on [Guillaume Briday's blog](https://blog.guillaumebriday.fr) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
