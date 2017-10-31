namespace :docker do
  desc 'Build images'
  task :build do
    on roles(:app) do
      within release_path do
        execute :docker, :build, '-t', fetch(:application), "#{release_path}/provisioning"
      end
    end
  end

  desc 'Run containers'
  task :up do
    on roles(:app) do
      within release_path do
        execute 'docker-compose', :up, '-d'
      end
    end
  end

  desc 'Stop containers'
  task :down do
    on roles(:app) do
      within release_path do
        cmd = 'docker ps -a -q'
        execute :docker, :stop, "$(#{cmd})" if capture(cmd) != ''
        execute :docker, :rm, "$(#{cmd})" if capture(cmd) != ''
        execute :docker, :network, :prune, '-f'
      end
    end
  end

  desc 'Copying the docker-compose file'
  task :compose do
    on roles(:app) do
      within release_path do
        execute :cp, fetch(:docker_compose), 'docker-compose.yml'
      end
    end
  end
end
