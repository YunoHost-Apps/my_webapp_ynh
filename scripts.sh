#!/bin/bash

function validate_install() {
    if [ "$with_sftp" -eq 1 ] && [ -z "$password" ]; then
        ynh_die "You need to set a password to enable SFTP"
    fi
}

# could have a validate_upgrade

# could have a migrate_settings() ? for non-straightforward cases

# FIXME : need something for backward compat to make sure the settings exist
#ynh_app_default_setting_set --key=with_sftp --value=false
#ynh_app_default_setting_set --key=database --value=none
#ynh_app_default_setting_set --key=phpversion --value=none
#ynh_app_default_setting_set --key=custom_error_file --value=0

function build() {
    mkdir -p $install_dir/www
}

function after_init_as_root() {
    # SFTP password
    if [ -n "$password" ]; then
        chpasswd <<< "${app}:${password}"
    fi
    
    # Setup example index.html
    # ... FIXME : we need some helper to render the file ...
    # it's not a real conf because we don't want to track it
    cp "conf/index.html" "$install_dir/www/index.html"
    _ynh_replace_vars "$install_dir/www/index.html"
}

function after_finalize_as_root() {
    # Home directory of the user needs to be owned by root to allow
    # SFTP connections
    chown root:root "$install_dir"
    setfacl -m g:$app:r-x "$install_dir"
    setfacl -m g:www-data:r-x "$install_dir"
}
