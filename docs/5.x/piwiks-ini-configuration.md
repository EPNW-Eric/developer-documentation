---
category: DevelopInDepth
title: Configuration
---
# INI Configuration

## INI files

INI configuration options are stored in both the `config/config.ini.php` and `config/global.ini.php` files.

- `global.ini.php` contains default option values and is a file distributed with Piwik's code
- `config.ini.php` contains the *user configuration*: it lets users overrides the default values. This file is not distributed with Piwik's code as it is customized by every user.

Plugins and other code can access and modify INI config options using the [Piwik\Config](/api-reference/Piwik/Config) singleton.

*To learn more about individual configuration options, read the documentation in [global.ini.php](https://github.com/matomo-org/matomo/blob/master/config/global.ini.php).*

### INI file structure

The INI config options are grouped into different sections. Sections are declared in the INI configuration with surrounding brackets, for example:

```ini
[MySection]
my_config_value = 1
```

An option can be used to store multiple items by appending `[]` to the name and setting it more than once, for example:

```ini
[MySection]
myarray[] = 1
myarray[] = 2
myarray[] = 3
```

## Reading INI configuration

The [Config](/api-reference/Piwik/Config) singleton allows PHP code to access whole configuration sections. They are accessed as if they were named public fields of the [Config](/api-reference/Piwik/Config) singleton.

For example, the following code will output every config option in the `[General]` section:

```php
for (Config::getInstance()->General as $name => $value) {
    echo "Option $name == " . print_r($value, true);
}
```

## Modifying INI configuration

Configuration options can be modified in memory through the [Config](/api-reference/Piwik/Config) singleton in the same way they are set:

```php
Config::getInstance()->Development['disable_merged_assets'] = 1;
```

To persist these changes, so they will appear in the INI files, call the [`forceSave()`](/api-reference/Piwik/Config#forcesave) method:

```php
Config::getInstance()->forceSave();
```

## Accessing configurations in JavaScript

You can add new configs to [Config::getClientSideOptions()](https://github.com/matomo-org/matomo/blob/4.4.1/core/Config.php#L183-L190) and these configurations will then be accessible using JavaScript as part of the `piwik.config` object. When exposing a config you want to double check to not expose any configs that shouldn't be visible by everyone (publicly). Any configuration value will be visible to everyone through the HTML eg on the login screen etc. Also depending on the value you might want to enforce a certain type for the config. For example if the config is supposed to be an integer then it would be good to convert it to an integer just in case it is a string etc.

## Adding new configuration options

**Plugins cannot add new configuration options.** If you are creating a core contribution and want to add a new INI option, you can simply add the option and its default value to `global.ini.php`.

If you want to make your plugin configurable, create a [Plugin Setting](/guides/plugin-settings).

## Boolean Configuration Options

### Naming

It's best practice to not start a configuration's name with `disable_` but rather use `enable_`. For example, `disable_processing_unique_visitors_range = 0` is slightly harder to read for non-technical users in comparison to `enable_processing_unique_visitors_range = 1`. Note that a boolean configuration doesn't have to start with `enable_`. Some settings might not use it, for example `assume_secure_protocol = 0/1`, `multi_server_environment = 0/1`, or `force_ssl = 0/1`.

### Values

For example, `force_ssl = 1` is a boolean value in the configuration.
By convention, we check whether a feature is enabled by comparing
the setting against the value `1` like this:

```php
if ( \Piwik\Config::getInstance()->General['setting'] == 1) {
}
```

This is currently not consistent throughout the code base as some
places compared the value as a boolean like below (not recommended):

```php
if ( \Piwik\Config::getInstance()->General['setting']) {
}
```

It was suggested that we
[improve and clarify this in the future](https://github.com/matomo-org/matomo/issues/17876).
We can't refactor the boolean checks to compare against 1 as it would be a breaking change since it would mean if someone configures for example 2 then it would no longer be interpreted as enabled.

Please note when someone configures `setting = on` or
`setting = yes` then their value gets converted in the code 
to `1` as well. The values `off` and `no` will be converted 
to `0`.
