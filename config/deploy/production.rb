server 'laravel-blog.com', user: 'ubuntu', roles: %w{app db web}

after 'deploy:updated', 'docker:compose'
after 'deploy:updated', 'docker:build'
after 'deploy:updated', 'laravel:resolve_acl_paths'
after 'deploy:updated', 'laravel:ensure_acl_paths_exist'
after 'deploy:updated', 'composer:install'
after 'deploy:updated', 'node:install'
after 'deploy:updated', 'node:build'
after 'deploy:updated', 'laravel:env'
after 'deploy:updated', 'docker:down'
after 'deploy:updated', 'laravel:migrate'
after 'deploy:updated', 'laravel:seeds'
after 'deploy:updated', 'docker:up'
