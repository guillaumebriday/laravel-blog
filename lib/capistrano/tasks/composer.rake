namespace :composer do
  desc 'Install dependencies'
  task :install do
    on roles(:app) do
      within release_path do
        execute 'docker-compose' , :run, '--no-deps', '--rm', '-u www-data', 'blog-server', 'composer install --no-dev'
      end
    end
  end
end
