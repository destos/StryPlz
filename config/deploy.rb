# Shared directories, these directories contain generated content which should
# not be wiped out during deployments.
set :shared_children, %w(logs cache)
set :application, "testvm" 
set :application_dir, "stryplz.com" 
set :deploy_to, "/var/www/html/#{application_dir}" #/#{stage}

# Commands on the server are run as the following user:
set :user, "deploy"
set :use_sudo, false

# Repository
set :scm,         :git
set :scm_verbose, true
set :branch,     "master"
set :deploy_via, :checkout



# Submodule support
set :git_enable_submodules, true
#set :git_recurse_submodules, true

# Remote machine
set :repository, "git@github.com:destos/StryPlz.git"

# Local machine
#set :local_repository, "nolimits-website:~/repositories/nle2.git/"

# SSH
#ssh_options[:keys] = %w(/Users/pat/.ssh/id_dsa.pub)
ssh_options[:keys] = %w(/home/deploy/.ssh/private_key) # SSH key
ssh_options[:forward_agent] = true
ssh_options[:port] = 22

# Roles
#role :web, "#{application}"
role :app, "#{user}"
role :web, "#{user}"

# --------------------------------------------
# Overloaded Methods.
# --------------------------------------------
# namespace :deploy do
# 	task :finalize_update do
# 			# Create cache directory
# 			run "mkdir #{latest_release}/application/cache"
# 
# 			# Symlink shared directories.
# 			run "ln -sf #{shared_path}/logs #{latest_release}/application/logs"
# 			run "ln -sf #{shared_path}/upload #{latest_release}/public/upload"
# 	end
# 
# 	task :migrate do
# 		php        = "/opt/php-5.3.3/bin/php"
# 		binary     = "modules/migrations/tools/doctrine"
# 		migrations = "config/migrations/#{stage}"
# 
# 		run "cd #{latest_release} && #{php} #{binary} --configuration=#{migrations}/conf.yml --db-configuration=#{migrations}/db.php --no-interaction migrations:migrate"
# 	end
# end

#after "deploy:update_code", "deploy:web:disable"
#after "deploy:symlink", "deploy:web:enable"

