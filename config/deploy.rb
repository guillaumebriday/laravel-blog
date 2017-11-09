# config valid only for current version of Capistrano
lock '3.9.1'

set :application, 'laravel-blog'
set :repo_url, 'git@github.com:guillaumebriday/laravel-blog.git'

# Default branch is :master
set :branch, :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/var/www/laravel-blog'

# Path to the dotenv file
set :dotenv, '/var/www/.env'

# Path to the docker-compose.yml file
set :docker_compose, '/var/www/docker-compose.yml'

# Paths that should have ACLs set for a standard Laravel 5 application
set :laravel_acl_paths, [
  'bootstrap/cache',
  'storage',
  'storage/app',
  'storage/app/public',
  'storage/framework',
  'storage/framework/cache',
  'storage/framework/sessions',
  'storage/framework/views',
  'storage/logs'
]
