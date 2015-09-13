default['project'] = 'my_example_app'

default['webroot'] = '/var/www'
default['approot'] = "#{default['webroot']}/#{default['project']}"
default['docroot'] = "#{default['approot']}/public"
default['viewroot'] =
default['viewcache'] = "#{default['viewroot']}/cache"

default['mysql']['server_root_password'] = 'root'
default['mysql']['server_root_username'] = 'root'
default['mysql']['version'] = '5.5'

default['app'] = {
    templates: {
        'config/database.php' => 'app/config/database.php',
        'config/app.php' => 'app/config/app.php',
        'config/view.options.php' => 'app/config/view.options.php',
        'config/templates.path.php' => 'app/config/templates.path.php'
    },
    directories: {
        views: "#{default['approot']}/views"
    }
}
default['app']['directories']['view.cache'] = "#{default['app']['directories']['views']}/cache"

default['database'] = {
    driver: 'mysql',
    host: '127.0.0.1',
    name: default['project'],
    port: '3306',
    user: node['mysql']['server_root_username'],
    pass: node['mysql']['server_root_password']
}

default['apache']['mpm'] = 'prefork'
default['php']['ext_conf_dir'] = '/etc/php5/apache2/conf.d'
default['php']['conf_dir'] = '/etc/php5/apache2'
default['php']['directives'] = {
  'date.timezone' => 'America/New_York',
  'error_log' => "#{node['approot']}/server/error.log",
  'html_errors' => node.chef_environment == 'development' ? 'On' : 'Off'
}
