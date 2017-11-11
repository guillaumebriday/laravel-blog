# Laravel 5.5 blog

[![Build Status](https://travis-ci.org/guillaumebriday/laravel-blog.svg?branch=master)](https://travis-ci.org/guillaumebriday/laravel-blog)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/guillaumebriday)

The purpose of this repository is to show good development practices on [Laravel](http://laravel.com/) as well as to present cases of use of the framework's functionalities like :

- [Authentication](https://laravel.com/docs/5.5/authentication)
- API
  - Token authentication
  - [API Resources](https://laravel.com/docs/5.5/eloquent-resources)
  - Versioning
- [Blade](https://laravel.com/docs/5.5/blade)
- [Broadcasting](https://laravel.com/docs/5.5/broadcasting)
- [Cache](https://laravel.com/docs/5.5/cache)
- [Filesystem](https://laravel.com/docs/5.5/filesystem)
- [Helpers](https://laravel.com/docs/5.5/helpers)
- [Jobs & Queues](https://laravel.com/docs/5.5/queues)
- [Localization](https://laravel.com/docs/5.5/localization)
- [Mail](https://laravel.com/docs/5.5/mail)
- [Migrations](https://laravel.com/docs/5.5/migrations)
- [Policies](https://laravel.com/docs/5.5/authorization)
- [Providers](https://laravel.com/docs/5.5/providers)
- [Requests](https://laravel.com/docs/5.5/validation#form-request-validation)
- [Seeding & Factories](https://laravel.com/docs/5.5/seeding)
- [Testing](https://laravel.com/docs/5.5/testing)

Beside Laravel, this project uses other tools like :

- [Bootstrap 4 Beta](https://getbootstrap.com/)
- [PHP-CS-Fixer](https://github.com/FriendsOfPhp/PHP-CS-Fixer)
- [Travis CI](https://travis-ci.org/)
- [Font Awesome](http://fontawesome.io/)
- [Vue.js](https://vuejs.org/)
- [axios](https://github.com/mzabriskie/axios)
- Many more to discover.

## Installation

Development environment requirements :
- [Docker](https://www.docker.com)
- [Docker Compose](https://docs.docker.com/compose/install/)

Setting up your development environment on your local machine :
```
$ git clone https://github.com/guillaumebriday/laravel-blog.git
$ cd laravel-blog
$ cp .env.example .env
$ docker-compose run blog-server composer install
$ docker-compose run blog-server php artisan key:generate
$ docker run --rm -it -v $(pwd):/app -w /app node npm install
$ docker-compose up -d
```

Now you can access the site via [http://localhost](http://localhost) or [http://laravel-blog.app](http://laravel-blog.app) if you added the domain to your hosts file.

## Before starting
You need to run the migrations :
```
$ docker-compose run blog-server php artisan migrate
```

Seed the database :
```
$ docker-compose run blog-server php artisan db:seed
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

## Useful commands
Running tests :
```
$ docker-compose run blog-server ./vendor/bin/phpunit
```

Running php-cs-fixer :
```
$ docker-compose run blog-server ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

Generating fake data :
```
$ docker-compose run blog-server php artisan db:seed --class=DevDatabaseSeeder
```

Starting job for newsletter :
```
$ docker-compose run blog-server php artisan tinker
> App\Jobs\PrepareNewsletterSubscriptionEmail::dispatch();
```

Discover package
```
$ docker-compose run blog-server php artisan package:discover
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
$ docker-compose run blog-server php artisan route:list --path=api
```

## Broadcasting & WebSockets
Before using WebSockets, you need to create a free Pusher account at [https://pusher.com/signup](https://pusher.com/signup) then login to your dashboard and create an app.

Set the `BROADCAST_DRIVER` in your `.env` file :

```txt
BROADCAST_DRIVER=pusher
```

Then fill in your Pusher app credentials in your `.env` file:

```txt
PUSHER_APP_ID=xxxxxx
PUSHER_APP_KEY=xxxxxx
PUSHER_APP_SECRET=xxxxxx
PUSHER_APP_CLUSTER=xx
```

## More details

More details are available or to come on [Guillaume Briday's blog](https://blog.guillaumebriday.fr) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
