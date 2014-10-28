package "vixie-cron" do
  action :install
end

service "crond" do
  supports :status => true, :restart => true, :reload => true
  action [ :enable, :start ]
end