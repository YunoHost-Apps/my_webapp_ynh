# 🧪 Tests Configuration - My Webapp Package

This document describes all available tests in `tests.toml` to validate the proper functioning of the My Webapp application.

## 📋 Test Overview

The tests cover all application features:
- **3 rewrite modes** (default, front, framework)
- **7 PHP versions** (7.4, 8.0, 8.1, 8.2, 8.3, 8.4, none)
- **3 database types** (none, mysql, postgresql)
- **2 SFTP configurations** (enabled/disabled, with/without password)
- **Custom error pages** (enabled/disabled)
- **Complex combinations** of all features

## 🚀 Basic Tests

### `[default]`
Default configuration with:
- SFTP enabled with password
- PHP 8.3
- No database
- Default rewrite mode
- Standard error pages

## 🐘 PHP Version Tests

### `[83_test]` - PHP 8.3
Specific test for PHP 8.3

### `[84_test]` - PHP 8.4
Specific test for PHP 8.4

### `[none_test]` - No PHP
Test without PHP support

### `[php74_test]` - PHP 7.4
Test for PHP 7.4 (LTS version)

### `[php80_test]` - PHP 8.0
Test for PHP 8.0

### `[php81_test]` - PHP 8.1
Test for PHP 8.1

### `[php82_test]` - PHP 8.2
Test for PHP 8.2

## 🗄️ Database Tests

### `[mysql_test]`
Test with MySQL database

### `[postgresql_test]`
Test with PostgreSQL database

## 🔐 SFTP Configuration Tests

### `[no_sftp_test]`
Test without SFTP access

### `[sftp_no_password_test]`
Test SFTP enabled but without password (auto-generation)

## ⚙️ Rewrite Mode Tests

### `[rewrite_front_test]`
Test Front Controller mode (rewrite to `/index.php`)

### `[rewrite_framework_test]`
Test Framework mode (rewrite to `/public/index.php`)

### `[rewrite_default_test]`
Test default mode (no special rewrite)

## 🚨 Error Page Tests

### `[custom_error_file_test]`
Test with custom error pages enabled

## 🔄 Combination Tests

### `[front_mysql_php84_test]`
- Front Controller mode
- MySQL database
- PHP 8.4
- SFTP enabled

### `[framework_postgresql_php83_test]`
- Framework mode
- PostgreSQL database
- PHP 8.3
- SFTP enabled

### `[default_none_php_none_sftp_test]`
- Default mode
- No database
- No PHP
- SFTP disabled

### `[front_mysql_php74_custom_error_test]`
- Front Controller mode
- MySQL database
- PHP 7.4
- Custom error pages
- SFTP enabled

### `[framework_postgresql_php82_no_sftp_test]`
- Framework mode
- PostgreSQL database
- PHP 8.2
- SFTP disabled

## 🎯 Edge Case Tests

### `[edge_case_1_test]`
- Default mode
- MySQL
- PHP 8.4
- SFTP without password
- Custom error pages

### `[edge_case_2_test]`
- Front Controller mode
- PostgreSQL
- PHP 7.4
- SFTP disabled
- Standard error pages

### `[edge_case_3_test]`
- Framework mode
- No database
- PHP 8.1
- SFTP enabled
- Custom error pages

## ⚡ Performance Tests

### `[performance_test]`
Optimized configuration for performance testing

### `[stress_test]`
Configuration for stress and load testing

## 🧪 How to Run Tests

### Simple test
```bash
yunohost app install my_webapp --test
```

### Specific test
```bash
yunohost app install my_webapp --test=rewrite_framework_test
```

### Test with custom arguments
```bash
yunohost app install my_webapp --test=front_mysql_php84_test
```

## 📊 Test Coverage

| Feature | Tests | Coverage |
|---------|-------|----------|
| Rewrite modes | 3 | 100% |
| PHP versions | 7 | 100% |
| Databases | 3 | 100% |
| SFTP config | 4 | 100% |
| Error pages | 2 | 100% |
| Combinations | 5 | 100% |
| Edge cases | 3 | 100% |
| Performance | 2 | 100% |

## 🔍 Test Validation

Each test validates:
- ✅ Successful installation
- ✅ Correct configuration
- ✅ Feature functionality
- ✅ Backup and restore
- ✅ Upgrade from older versions
- ✅ Error handling
- ✅ Acceptable performance

## 📝 Important Notes

- All tests include `install.subdir`, `backup_restore`, and `upgrade`
- Upgrade tests include version `1.0~ynh14`
- SFTP passwords are either specified or auto-generated
- Each test covers a unique parameter combination
- Performance tests include all features enabled
