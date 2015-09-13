mysql2_chef_gem node['project'] do
    client_version node['mysql']['version']
    action :install
end

mysql_service node['project'] do
    port node['database']['port']
    version node['mysql']['version']
    bind_address node['database']['host']
    data_dir '/data'
    initial_root_password node['mysql']['server_root_password']
    action [:create, :start]
end

root_connection = {
    host: node['database']['host'],
    port: node['database']['port'],
    password: node['mysql']['server_root_username'],
    password: node['mysql']['server_root_password']
}

mysql_database node['database']['name'] do
    connection root_connection
    action :create
end
