#!/bin/bash

#=================================================
# GENERIC STARTING
#=================================================
# IMPORT GENERIC HELPERS
#=================================================

source _common.sh
source /usr/share/yunohost/helpers

ynh_abort_if_errors

#=================================================
# RETRIEVE ARGUMENTS
#=================================================

install_dir=$(ynh_app_setting_get --app=$app --key=install_dir)
domain=$(ynh_app_setting_get --app=$app --key=domain)
path=$(ynh_app_setting_get --app=$app --key=path)

#=================================================
# SPECIFIC GETTERS FOR TOML SHORT KEY
#=================================================

#=================================================
# SPECIFIC VALIDATORS FOR TOML SHORT KEYS
#=================================================

#=================================================
# SPECIFIC SETTERS FOR TOML SHORT KEYS
#=================================================

set__password() {
    if [ ! "$password" == "" ]
    then
        ynh_app_setting_set --app=$app --key=password --value="$password"
    fi
}

#=================================================
# GENERIC FINALIZATION
#=================================================

ynh_app_config_validate() {
    _ynh_app_config_validate

    if [ "${changed[with_sftp]}" == "true" ] && [ $with_sftp -eq 1 ] && [ "$password" == "" ]
    then
        ynh_die --message="You need to set a password to enable SFTP"
    fi
}

ynh_app_config_apply() {
    _ynh_app_config_apply

    if [ "${changed[phpversion]}" == "true" ]
    then
        if [ "${old[phpversion]}" != "none" ]
        then
            ynh_app_setting_set --app=$app --key=phpversion --value="${old[phpversion]}"
            ynh_remove_fpm_config
        fi
        ynh_remove_app_dependencies
        YNH_PHP_VERSION=$phpversion
        # ^ ynh_add_config replaces __PHPVERSION__ by __PHP_YNH_VERSION__...
        ynh_app_setting_set --app=$app --key=phpversion --value="$phpversion"

        database=$(ynh_app_setting_get --app=$app --key=database)
        dependencies="$(ynh_read_manifest -k "resources.apt.packages")"
        dependencies_from_raw_bash=$(eval "$(ynh_read_manifest -k "resources.apt.packages_from_raw_bash")" | tr "\n" " ")
        ynh_install_app_dependencies "$dependencies $dependencies_from_raw_bash"

        nginx_extra_conf_dir="/etc/nginx/conf.d/$domain.d/$app.d"
        mkdir -p "$nginx_extra_conf_dir"
        if [ "$phpversion" == "none" ]
        then
            ynh_delete_file_checksum --file="$nginx_extra_conf_dir/php.conf"
            ynh_secure_remove --file="$nginx_extra_conf_dir/php.conf"
        else
            ynh_add_config --template="nginx-php.conf" --destination="$nginx_extra_conf_dir/php.conf"
            ynh_add_fpm_config --phpversion=$phpversion
            # ^ the helper takes care of ynh_app_setting_set the phpversion
        fi

        ynh_add_nginx_config
    fi

    if [ "${changed[with_sftp]}" == "true" ] && [ $with_sftp -eq 1 ]
    then
        ynh_system_user_add_group --username=$app --groups="sftp.app"

        if [ ! "$password" == "" ]
        then
            chpasswd <<< "${app}:${password}"
        fi
    elif [ "${changed[with_sftp]}" == "true" ] && [ $with_sftp -eq 0 ]
    then
        ynh_system_user_del_group --username=$app --groups="sftp.app"
    fi
    
    if [ "${changed[password]}" == "true" ] && [ ! "$password" == "" ]
    then
        chpasswd <<< "${app}:${password}"
    fi

    if [ "${changed[custom_error_file]}" == "true" ]
    then
        CUSTOM_ERROR_FILE=$custom_error_file
        nginx_extra_conf_dir="/etc/nginx/conf.d/$domain.d/$app.d"

        if [ $custom_error_file -eq 1 ]
        then
            ynh_add_config --template="nginx-code-error.conf" --destination="$nginx_extra_conf_dir/error-code.conf"
        elif [ $custom_error_file -eq 0 ]
        then
            ynh_secure_remove --file="$nginx_extra_conf_dir/error-code.conf"
        fi
        ynh_systemd_action --service_name=nginx --action=reload
    fi

    if [ "$phpversion" != "none" ]
    then
        ynh_add_fpm_config --phpversion=$phpversion
    fi
}

ynh_app_config_run $1
