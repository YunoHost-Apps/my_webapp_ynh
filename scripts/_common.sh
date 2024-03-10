#!/bin/bash

#=================================================
# COMMON VARIABLES
#=================================================

#=================================================
# EXPERIMENTAL HELPERS
#=================================================

ynh_maintenance_mode_ON () {
	# Load value of $path and $domain from the config if their not set
	if [ -z $path ]; then
		path=$(ynh_app_setting_get $app path)
	fi
	if [ -z $domain ]; then
		domain=$(ynh_app_setting_get $app domain)
	fi

	mkdir -p /var/www/html/
	
	# Create an html to serve as maintenance notice
	echo "<!DOCTYPE html>
<html>
<head>
<meta http-equiv="refresh" content="3">
<title>Your app $app is currently under maintenance!</title>
<style>
	body {
		width: 70em;
		margin: 0 auto;
	}
</style>
</head>
<body>
<h1>Your app $app is currently under maintenance!</h1>
<p>This app has been put under maintenance by your administrator at $(date)</p>
<p>Please wait until the maintenance operation is done. This page will be reloaded as soon as your app will be back.</p>

</body>
</html>" > "/var/www/html/maintenance.$app.html"

	# Create a new nginx config file to redirect all access to the app to the maintenance notice instead.
	echo "# All request to the app will be redirected to ${path}_maintenance and fall on the maintenance notice
rewrite ^${path}/(.*)$ ${path}_maintenance/? redirect;
# Use another location, to not be in conflict with the original config file
location ${path}_maintenance/ {
alias /var/www/html/ ;

try_files maintenance.$app.html =503;

# Include SSOWAT user panel.
include conf.d/yunohost_panel.conf.inc;
}" > "/etc/nginx/conf.d/$domain.d/maintenance.$app.conf"

	# The current config file will redirect all requests to the root of the app.
	# To keep the full path, we can use the following rewrite rule:
	# 	rewrite ^${path}/(.*)$ ${path}_maintenance/\$1? redirect;
	# The difference will be in the $1 at the end, which keep the following queries.
	# But, if it works perfectly for a html request, there's an issue with any php files.
	# This files are treated as simple files, and will be downloaded by the browser.
	# Would be really be nice to be able to fix that issue. So that, when the page is reloaded after the maintenance, the user will be redirected to the real page he was.

	systemctl reload nginx
}

ynh_maintenance_mode_OFF () {
	# Load value of $path and $domain from the config if their not set
	if [ -z $path ]; then
		path=$(ynh_app_setting_get $app path)
	fi
	if [ -z $domain ]; then
		domain=$(ynh_app_setting_get $app domain)
	fi

	# Rewrite the nginx config file to redirect from ${path}_maintenance to the real url of the app.
	echo "rewrite ^${path}_maintenance/(.*)$ ${path}/\$1 redirect;" > "/etc/nginx/conf.d/$domain.d/maintenance.$app.conf"
	systemctl reload nginx

	# Sleep 4 seconds to let the browser reload the pages and redirect the user to the app.
	sleep 4

	# Then remove the temporary files used for the maintenance.
	rm "/var/www/html/maintenance.$app.html"
	rm "/etc/nginx/conf.d/$domain.d/maintenance.$app.conf"

	systemctl reload nginx
}


ynh_system_user_add_group() {
    # Declare an array to define the options of this helper.
    local legacy_args=uhs
    local -A args_array=([u]=username= [g]=groups=)
    local username
    local groups

    # Manage arguments with getopts
    ynh_handle_getopts_args "$@"
    groups="${groups:-}"

	local group
	for group in $groups; do
		usermod -a -G "$group" "$username"
	done
}


ynh_system_user_del_group() {
    # Declare an array to define the options of this helper.
    local legacy_args=uhs
    local -A args_array=([u]=username= [g]=groups=)
    local username
    local groups

    # Manage arguments with getopts
    ynh_handle_getopts_args "$@"
    groups="${groups:-}"

	local group
	for group in $groups; do
		gpasswd -d "$username" "$group"
	done
}


ynh_setup_my_nodeapp() {
    # Declare an array to define the options of this helper.
    local legacy_args=ai
    local -A args_array=([a]=app= [i]=install_dir=)
    local app
    local install_dir

    ynh_handle_getopts_args "$@"

    ynh_add_systemd_config --service="${app}-nodejs" --template="nodejs.service"
    ynh_add_systemd_config --service="${app}-nodejs-watcher" --template="nodejs-watcher.service"
    ynh_add_config --template="nodejs-watcher.path" --destination="/etc/systemd/system/${app}-nodejs-watcher.path"

    systemctl enable "${app}-nodejs-watcher.path" --quiet
    systemctl daemon-reload

    yunohost service add "${app}-nodejs" --description="$app NodeJS Server" --log="/var/log/$app-nodejs.log"
    ynh_systemd_action --service_name="${app}-nodejs"
    ynh_systemd_action --service_name="${app}-nodejs-watcher"
    ynh_systemd_action --service_name="${app}-nodejs-watcher.path"

    # Add the config manually because yunohost does not support custom nginx confs
    ynh_add_config --template="nginx-nodejs.conf" --destination="/etc/nginx/conf.d/$domain.d/$app.conf"
    ynh_store_file_checksum --file="/etc/nginx/conf.d/$domain.d/$app.conf"
    ynh_systemd_action --service_name=nginx --action=reload

    # Subsequent npm install will write to this folder (as it is within $app's home)
    # As such we prepare it with fitting rights
    mkdir -p "$install_dir/.npm"
    chown $app:$app "$install_dir/.npm"
}

ynh_remove_my_nodeapp() {
    # Declare an array to define the options of this helper.
    local legacy_args=a
    local -A args_array=([a]=app=)
    local app

    ynh_handle_getopts_args "$@"

    yunohost service remove "${app}-nodejs"

    ynh_remove_systemd_config --service="${app}-nodejs"
    ynh_remove_systemd_config --service="${app}-nodejs-watcher"
    ynh_secure_remove --file="/etc/systemd/system/${app}-nodejs-watcher.path"

    ynh_remove_nodejs
}
