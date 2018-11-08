namespace :node do
  desc 'Install dependencies'
  task :install do
    on roles(:app) do
      within release_path do
        execute :docker , :run, '--rm', '-i', '-u 1000', '-v $(pwd):/data', '-v /var/www/node_modules:/data/node_modules', '-w /data', 'node', 'yarn'
      end
    end
  end

  desc 'Build assets'
  task :build do
    on roles(:app) do
      within release_path do
        execute :docker , :run, '--rm', '-i', '-u 1000', '-v $(pwd):/data', '-v /var/www/node_modules:/data/node_modules', '-w /data', 'node', 'yarn production'
      end
    end
  end
end
