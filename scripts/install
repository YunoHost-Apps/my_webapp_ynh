#!/bin/bash

#=================================================
# GENERIC START
#=================================================
# IMPORT GENERIC HELPERS
#=================================================

source _common.sh
source /usr/share/yunohost/helpers

#=================================================
# MANAGE SCRIPT FAILURE
#=================================================

# Exit if an error occurs during the execution of the script
ynh_abort_if_errors

#=================================================
# RETRIEVE ARGUMENTS FROM THE MANIFEST
#=================================================

domain=$YNH_APP_ARG_DOMAIN
path_url=$YNH_APP_ARG_PATH
password=$YNH_APP_ARG_PASSWORD
is_public=$YNH_APP_ARG_IS_PUBLIC

with_mysql=$YNH_APP_ARG_WITH_MYSQL

app=$YNH_APP_INSTANCE_NAME
app_nb=$YNH_APP_INSTANCE_NUMBER

#=================================================
# CHECK IF THE APP CAN BE INSTALLED WITH THESE ARGS
#=================================================
ynh_script_progression --message="Validating installation parameters..." --weight=2

final_path=/var/www/$app
test ! -e "$final_path" || ynh_die --message="This path already contains a folder"

# Check password strength
if [ ${#password} -le 5 ]
then
    ynh_die --message="The password is too weak, it must be longer than 5 characters"
fi

# Register (book) web path
ynh_webpath_register --app=$app --domain=$domain --path_url=$path_url

#=================================================
# STORE SETTINGS FROM MANIFEST
#=================================================
ynh_script_progression --message="Storing installation settings..."

user=webapp${app_nb}
ynh_app_setting_set --app=$app --key=domain --value=$domain
ynh_app_setting_set --app=$app --key=path --value=$path_url
ynh_app_setting_set --app=$app --key=is_public --value=$is_public
ynh_app_setting_set --app=$app --key=with_mysql --value=$with_mysql
ynh_app_setting_set --app=$app --key=password --value="$password"
ynh_app_setting_set --app=$app --key=user --value=$user
ynh_app_setting_set --app=$app --key=final_path --value=$final_path

#=================================================
# STANDARD MODIFICATIONS
#=================================================
# CREATE A MYSQL DATABASE
#=================================================

if [ $with_mysql -eq 1 ]; then
    ynh_script_progression --message="Creating a MySQL database..." --weight=2

    db_name=$(ynh_sanitize_dbid --db_name=$app)
    ynh_app_setting_set --app=$app --key=db_name --value=$db_name
    ynh_mysql_setup_db --db_user=$db_name --db_name=$db_name
fi

#=================================================
# NGINX CONFIGURATION
#=================================================
ynh_script_progression --message="Configuring nginx web server..." --weight=2

# Create a dedicated nginx config
ynh_add_nginx_config

#=================================================
# CREATE DEDICATED USER
#=================================================
ynh_script_progression --message="Configuring system user..."

# Create a standard user (not a system user for sftp)
ynh_system_user_exists --username=$user || \
    useradd -d "$final_path" -M --user-group "$user"
# Add the password to this user
chpasswd <<< "${user}:${password}"

#=================================================
# SPECIFIC SETUP
#=================================================
# CONFIGURE SSH
#=================================================
ynh_script_progression --message="Configuring ssh..."

# Harden SSH connection for the user
echo "##-> ${app}
# Hardening user connection
Match User ${user}
  ChrootDirectory %h
  ForceCommand internal-sftp
  AllowTcpForwarding no
  PermitTunnel no
  X11Forwarding no
##<- ${app}" | tee -a /etc/ssh/sshd_config >/dev/null

ynh_systemd_action --service_name=ssh --action=reload

#=================================================
# MODIFY A CONFIG FILE
#=================================================

ynh_replace_string --match_string="__DOMAIN__" --replace_string="$domain" --target_file=../sources/www/index.html
ynh_replace_string --match_string="__USER__" --replace_string="$user" --target_file=../sources/www/index.html

if [ $with_mysql -eq 1 ]; then
    # Store the database access
    echo -e "# MySQL Database
    name: ${db_name}\nuser: ${db_name}\npass: ${db_pwd}" > ../sources/db_access.txt
fi

# Copy files to the right place
cp -r ../sources "$final_path"

#=================================================
# PHP-FPM CONFIGURATION
#=================================================
ynh_script_progression --message="Configuring php-fpm..." --weight=2

# Create a dedicated php-fpm config
ynh_replace_string --match_string="__USER__" --replace_string="$user" --target_file="../conf/php-fpm.conf"
ynh_add_fpm_config

#=================================================
# GENERIC FINALIZATION
#=================================================
# SECURE FILES AND DIRECTORIES
#=================================================

chown -R $user: "$final_path"
# Home directory of the user needs to be owned by root to allow
# SFTP connections
chown root: "$final_path"

#=================================================
# SETUP SSOWAT
#=================================================
ynh_script_progression --message="Configuring SSOwat..."

# Make app public if necessary
if [ $is_public -eq 1 ]
then
	ynh_app_setting_set --app=$app --key=skipped_uris --value="/"
fi

#=================================================
# RELOAD NGINX
#=================================================
ynh_script_progression --message="Reloading nginx web server..."

ynh_systemd_action --service_name=nginx --action=reload

#=================================================
# END OF SCRIPT
#=================================================

ynh_script_progression --message="Installation of $app completed" --last
