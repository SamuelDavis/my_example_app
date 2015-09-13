# UTILITIES
include_recipe 'apt'
include_recipe 'curl'
include_recipe 'vim'
include_recipe 'git'

# Apache
include_recipe 'apache2'
include_recipe 'apache2::mod_php5'
include_recipe 'apache2::mod_rewrite'

# PHP
include_recipe 'php'
include_recipe 'php::module_mysql'
include_recipe 'php::module_curl'
include_recipe 'php::module_gd'
package 'php5-mcrypt'
execute 'php5enmod mcrypt'

# DATABASE
if node['database']['host'] == '127.0.0.1'
    include_recipe 'my_example_app::database'
end

# APP TEMPLATES
node['app']['templates'].each do |app_template, template_target|
    template "#{node['approot']}/#{template_target}" do
        mode 00644
        source "#{app_template}.erb"
        action :create
    end
end
# APP DIRECTORIES
node['app']['directories'].each do |key, dir|
    directory dir do
        recursive true
    end
end

# COMPOSER
include_recipe 'composer'
composer_project node['approot'] do
    quiet false
    action :install
end

# SET PERMISSIONS
execute "sudo chown -R www-data:www-data #{node['approot']}"

# ENABLE VHOST
template "#{node['apache']['dir']}/sites-available/#{node['project']}.conf" do
    source 'vhost.conf.erb'
    mode 00644
    action :create
end

symlink_file = "#{node['apache']['dir']}/sites-enabled/#{node['project']}.conf"
symlink_exists = ::File.symlink?(symlink_file)
execute "a2ensite #{node['project']}" do
    not_if { symlink_exists }
end

if node.chef_environment == 'development'
    php_pear "xdebug" do
        zend_extensions ['xdebug.so']
        action :install
    end
end

execute 'sudo service apache2 restart'
