# License Handler · Eliasis PHP Framework plugin

[![Packagist](https://img.shields.io/packagist/v/eliasis-framework/license-handler.svg)](https://packagist.org/packages/eliasis-framework/license-handler) [![Downloads](https://img.shields.io/packagist/dt/eliasis-framework/license-handler.svg)](https://github.com/eliasis-framework/license-handler) [![License](https://img.shields.io/packagist/l/eliasis-framework/license-handler.svg)](https://github.com/eliasis-framework/license-handler/blob/master/LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/1310dbbd9f8b49fba6589f61795de09e)](https://www.codacy.com/app/Josantonius/license-handler?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=eliasis-framework/license-handler&amp;utm_campaign=Badge_Grade) [![Build Status](https://travis-ci.org/eliasis-framework/license-handler.svg?branch=master)](https://travis-ci.org/eliasis-framework/license-handler) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![codecov](https://codecov.io/gh/eliasis-framework/license-handler/branch/master/graph/badge.svg)](https://codecov.io/gh/eliasis-framework/license-handler)

[Versión en español](README-ES.md)

Licensing and applications manager.

---

- [Requirements](#requirements)
- [Installation](#installation)
- [Available Methods](#available-methods)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [Database](#database)
- [Tests](#tests)
- [TODO](#-todo)
- [Contribute](#contribute)
- [License](#license)
- [Copyright](#copyright)

---

## Requirements

This plugin is supported by **PHP versions 5.6** or higher and is compatible with **HHVM versions 3.0** or higher.

## Installation

The preferred way to install this extension is through [Composer](http://getcomposer.org/download/).

To install **License Handler**, simply:

    $ composer require eliasis-framework/license-handler

The previous command will only install the necessary files, if you prefer to **download the entire source code** you can use:

    $ composer require eliasis-framework/license-handler --prefer-source

You can also **clone the complete repository** with Git:

    $ git clone https://github.com/eliasis-framework/license-handler.git

## Available Methods

Available methods in this plugin:

### Applications

#### - Add application:

```php
$application->add($name, $type, $category, $active);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $name | Application name. | string | Yes |
| $type | Application type. | string | Yes |
| $category | Application category. | string | Yes |
| $active | Application state. | boolean| Yes |

**@return** (int) → Application inserted ID.

#### - Update application:

```php
$application->update($id, $name, $type, $category, $active);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $id | Application ID. | string | Yes |
| $name | Application name. | string | Yes |
| $type | Application type. | string | Yes |
| $category | Application category. | string | Yes |
| $active | Application state. | boolean| Yes |

**@return** (int) → Rows affected.

### Sites

#### - Add site:

```php
$site->add($domain, $host, $ip, $authorized);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $domain | Site domain. | string | Yes |
| $host | Site host. | string | Yes |
| $ip | Site ip. | string | Yes |
| $authorized | Authorized?. | boolean| Yes |

**@return** (int) → Site inserted ID.

#### - Update site:

```php
$site->update($id, $domain, $host, $ip, $authorized);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $id | Site ID. | string | Yes |
| $domain | Site domain. | string | Yes |
| $host | Site host. | string | Yes |
| $ip | Site ip. | string | Yes |
| $authorized | Authorized?. | boolean| Yes |

**@return** (int) → Rows affected.

### License

#### - Generate license key:

```php
$license->generateKey($characters, $segments);
```

| Atttribute | Description | Type | Required | Default
| --- | --- | --- | --- | --- |
| $characters | Characters number by segments. | int | No | 5 |
| $segments | Segments number. | int | No | 5 |

**@return** (string) → License key.

#### - Add license:

```php
$license->add($appID, $siteID, $key, $state, $expire);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $appID | Application table id. | int | Yes |
| $siteID | Site table id. | int | Yes |
| $key | License key. | string | Yes |
| $state | License state. | bool | Yes |
| $expire | License expiration date. | string| Yes |

**@return** (int) → License inserted ID.

#### - Update license:

```php
$license->update($id, $appID, $siteID, $key, $state, $expire);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $id | License ID. | string | Yes |
| $appID | Application table id. | int | Yes |
| $siteID | Site table id. | int | Yes |
| $key | License key. | string | Yes |
| $state | License state. | bool | Yes |
| $expire | License expiration date. | string| Yes |

**@return** (int) → Rows affected.

#### - Check if license exists:

```php
$license->keyExists($license);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $license | License key. | string | Yes |

**@return** (boolean)

### Options

#### - Add option:

```php
$option->add($licenseID, $name, $value);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $licenseID | License table id. | string | Yes |
| $name | Option name. | string | Yes |
| $value | Option value. | string | Yes |

**@return** (int) → Option inserted ID.

#### - Update option:

```php
$option->update($id, $licenseID, $name, $value);
```

| Atttribute | Description | Type | Required
| --- | --- | --- | --- |
| $id | Option ID. | string | Yes |
| $licenseID | License table id. | string | Yes |
| $name | Option name. | string | Yes |
| $value | Option value. | string | Yes |

**@return** (int) → Rows affected.

## Quick Start

To use this plugin, your [Eliasis application](https://github.com/eliasis-framework/eliasis) must use the [PHP-Database](https://eliasis-framework.github.io/eliasis/v1.1.3/lang/en/#libraries-Database) library and add the following to the application configuration files:

```php
/**
 * eliasis-app/config/complements.php
 */
return [

    'plugin' => [

        'license-handler' => [

            'db-id' => 'app',
            'db-prefix' => 'test_',
            'db-charset' => 'utf8',
            'db-engine' => 'innodb'
        ],
    ],
];
```

And get the instances from each table:

```php
use Eliasis\Complement\Type\Plugin;

$site = Plugin::WP_Plugin_Info()->getControllerInstance('Site');
$option = Plugin::WP_Plugin_Info()->getControllerInstance('Option');
$license = Plugin::WP_Plugin_Info()->getControllerInstance('License);
$application = Plugin::WP_Plugin_Info()->getControllerInstance('Application');
```

## Usage

### Applications

#### - Add application:

```php
$appID = $application->add('app-name', 'plugin', 'WordPress', 1);
```

#### - Update application:

```php
$application->update($appID, 'new-app-name', 'module', 'Prestashop', 1);
```

### Sites

#### - Add site:

```php
$siteID = $site->add(
	'domain.com', 
	'host.domain.com',
	'87.142.85.70', 1
);
```

#### - Update site:

```php
$site->update(
	$siteID, 
	'new-domain.com', 
	'host.new-domain.com', 
	'87.142.85.70', 1
);
```

### License

#### - Generate license key:

```php
$license = $license->generateKey(); // 3FGSV-BZ49N-U79EA-S96ZY-MFQ63

$license = $license->generateKey(5, 5); // 3FGSV-BZ49N-U79EA-S96ZY-MFQ63

$license = $license->generateKey(4, 4); // 3FGS-BZ4N-U7EA-S9ZY

$license = $license->generateKey(6, 5); // SF4W2H-FEJKZ5-PU7KAD-N77486-BKMJSW

$license = $license->generateKey(4, 2); // FT3Q-EBT5
```

#### - Add license:

```php
$licenseID = $license->add(1, 1, $key, $license, '+1day');

$licenseID = $license->add(1, 1, $key, $license, '+10days');

$licenseID = $license->add(1, 1, $key, $license, '+1week');

$licenseID = $license->add(1, 1, $key, $license, '+1month');

$licenseID = $license->add(1, 1, $key, $license, '+2months');

$licenseID = $license->add(1, 1, $key, $license, '+1year');

$licenseID = $license->add(1, 1, $key, $license, '+2years');
```

#### - Update license:

```php
$license->update(1, 1, $key, $license, '+3weeks');
```

#### - Check if license exists:

```php
$license->keyExists('SF4W2H-FEJKZ5-PU7KAD-N77486-BKMJSW');
```

### Options

#### - Add option:

```php
$option->add($licenseID, 'lang', 'es-ES');
```

#### - Update option:

```php
$option->update($id, $licenseID, 'lang', 'en-EN');
```

## Database

This plugin will create the following tables.

### - test_applications:

The table structure created is as follows:

| Columns | Data type |
| --- | --- |
| app_id | INT(9) |
| app_name | VARCHAR(80) |
| app_type | VARCHAR(80) |
| app_category | VARCHAR(80) |
| app_state | INT(1) |
| updated | TIMESTAMP |
| created | TIMESTAMP |

### - test_sites:

The table structure created is as follows:

| Columns | Data type |
| --- | --- |
| site_id | INT(9) |
| site_domain | VARCHAR(255) |
| site_host | VARCHAR(255) |
| site_ip | VARCHAR(1) |
| site_authorized | INT(1) |
| updated | TIMESTAMP |
| created | TIMESTAMP |

### - test_licenses:

The table structure created is as follows:

| Columns | Data type |
| --- | --- |
| lic_id | INT(9) |
| app_id | INT(9) |
| site_id | INT(9) |
| lic_key | VARCHAR(29) |
| lic_state | INT(1) |
| lic_expire | DATETIME |
| site_authorized | INT(1) |
| updated | TIMESTAMP |
| created | TIMESTAMP |

### - test_options:

The table structure created is as follows:

| Columns | Data type |
| --- | --- |
| option_id | INT(9) |
| lic_id | INT(9) |
| option_name | VARCHAR(180) |
| option_value | LONGTEXT |

## Tests 

To run [tests](tests) you just need [composer](http://getcomposer.org/download/) and to execute the following:

    $ git clone https://github.com/eliasis-framework/license-handler.git
    
    $ cd license-handler

    $ composer install

Run unit tests with [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Run [PSR2](http://www.php-fig.org/psr/psr-2/) code standard tests with [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Run [PHP Mess Detector](https://phpmd.org/) tests to detect inconsistencies in code style:

    $ composer phpmd

Run all previous tests:

    $ composer tests

## ☑ TODO

- [ ] Run PHPUnit on Travis CI.
- [ ] Add more methods.
- [ ] Improve tests.
- [ ] Improve documentation.
- [ ] Refactor code for disabled code style rules. See [phpmd.xml](phpmd.xml) and [.php_cs.dist](.php_cs.dist).

## Contribute

If you would like to help, please take a look at the list of
[issues](https://github.com/eliasis-framework/license-handler/issues) or the [To Do](#-todo) checklist.

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Run the command `composer install` to install the dependencies.
  This will also install the [dev dependencies](https://getcomposer.org/doc/03-cli.md#install).
* Run the command `composer fix` to excute code standard fixers.
* Run the [tests](#tests).
* Create a **branch**, **commit**, **push** and send me a
  [pull request](https://help.github.com/articles/using-pull-requests).

## License

This project is licensed under **MIT license**. See the [LICENSE](LICENSE) file for more info.

## Copyright

2017 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)

If you find it useful, let me know :wink:

You can contact me on [Twitter](https://twitter.com/Josantonius) or through my [email](mailto:hello@josantonius.com).