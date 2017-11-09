namespace :laravel do
  desc 'Run migrations'
  task :migrate do
    on roles(:app) do
      within release_path do
        execute 'docker-compose' , :run, '--rm', 'blog-server', 'php artisan migrate --force'
      end
    end
  end

  desc 'Run seeds'
  task :seeds do
    on roles(:app) do
      within release_path do
        execute 'docker-compose' , :run, '--rm', 'blog-server', 'php artisan db:seed --force'
      end
    end
  end

  desc 'Copying the dotenv file'
  task :env do
    on roles(:app) do
      execute :cp, fetch(:dotenv), release_path
    end
  end

  desc 'Determine which paths, if any, to have ACL permissions set.'
  task :resolve_acl_paths do
    laravel_acl_paths = fetch(:laravel_acl_paths)

    set :file_permissions_paths, fetch(:file_permissions_paths, []).push(*laravel_acl_paths).uniq
  end

  desc 'Ensure that ACL paths exist.'
  task :ensure_acl_paths_exist do
    on roles(:app) do
      fetch(:file_permissions_paths).each do |path|
        within release_path do
          execute :mkdir, '-p', path
        end
      end
    end
  end
end
