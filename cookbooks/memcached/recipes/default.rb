#
# Cookbook Name:: memcached
# Recipe:: default
#
# Copyright 2014, YOUR_COMPANY_NAME
#
# All rights reserved - Do Not Redistribute
#
package "php" do
    action :install
end

package "php-mbstring" do
    action :install
end

package "php-pecl-memcached" do
    action :install
end

package "libevent" do
  action :install
end

package "memcached" do
  action :install
end

service "memcached" do
  supports :status => true, :restart => true, :reload => true
  action [ :enable, :start ]
end