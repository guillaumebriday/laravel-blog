[![Build Status](https://travis-ci.org/guillaumebriday/laravel-blog.svg?branch=master)](https://travis-ci.org/guillaumebriday/laravel-blog)

# Laravel 5.5 blog

The purpose of this repository is to show good development practices on [Laravel](http://laravel.com/) as well as to present cases of use of the framework's functionalities like :

- [Authentication](https://laravel.com/docs/5.5/authentication)
- API
  - Token authentication
  - [Transformers](http://fractal.thephpleague.com/transformers/)
  - Versioning
- [Blade](https://laravel.com/docs/5.5/blade)
- [Cache](https://laravel.com/docs/5.5/cache)
- [Filesystem](https://laravel.com/docs/5.5/filesystem)
- [Helpers](https://laravel.com/docs/5.5/helpers)
- [Homestead](https://laravel.com/docs/5.5/homestead)
- [Jobs & Queues](https://laravel.com/docs/5.5/queues)
- [Localization](https://laravel.com/docs/5.5/localization)
- [Mail](https://laravel.com/docs/5.5/mail)
- [Migrations](https://laravel.com/docs/5.5/migrations)
- [Policies](https://laravel.com/docs/5.5/authorization)
- [Providers](https://laravel.com/docs/5.5/providers)
- [Requests](https://laravel.com/docs/5.5/validation#form-request-validation)
- [Seeding & Factories](https://laravel.com/docs/5.5/seeding)
- [Testing](https://laravel.com/docs/5.5/testing)

## Installation

Development environment requirements :
- [VirtualBox 5.1](https://www.virtualbox.org/wiki/Downloads)
- [Vagrant 1.9](https://www.vagrantup.com/downloads.html)
- [Composer 1.3](https://getcomposer.org)

Setting up your development environment on your local machine with [Homestead](https://laravel.com/docs/5.5/homestead) :
```
$ git clone https://github.com/guillaumebriday/laravel-blog.git
$ cd laravel-blog
$ cp .env.dev .env
$ composer install
$ vagrant up
```

Now you can access the site via [http://192.168.10.10](http://192.168.10.10) or [http://laravel-blog.app](http://laravel-blog.app) if you added the domain to your hosts file.

## Before starting

The following commands must be executed on the virtual machine :
```
$ vagrant ssh
$ cd /home/vagrant/laravel-blog
```

You need to run the migrations :
```
$ php artisan migrate
```

Seed the database :
```
$ php artisan db:seed
```

This will create a new user that you can use to sign in :
```
Email : darthvader@deathstar.ds
Password : 4nak1n
```

And then, compile the assets :
```
$ npm install
$ npm run dev
```

## Useful commands

The following commands must be executed on the virtual machine in the folder ```/home/vagrant/laravel-blog```.

Running tests :
```
$ ./vendor/bin/phpunit
```

Running php-cs-fixer :
```
$ ./vendor/bin/php-cs-fixer fix --config=.php_cs --verbose --dry-run --diff
```

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
GET http://laravel-blog.app/api/v1/posts?api_token=your_private_token_here

# Authorization Header
curl --header "Authorization: Bearer your_private_token_here" http://laravel-blog.app/api/v1/posts
```

API are prefixed by ```api``` and the API version number like so ```v1```.

## More details

More details are available or to come on [Guillaume Briday's blog](https://blog.guillaumebriday.fr) (French).

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.

## License

This project is released under the [MIT](http://opensource.org/licenses/MIT) license.
