# License Handler · Eliasis PHP Framework plugin

[![Packagist](https://img.shields.io/packagist/v/eliasis-framework/license-handler.svg)](https://packagist.org/packages/eliasis-framework/license-handler) [![Downloads](https://img.shields.io/packagist/dt/eliasis-framework/license-handler.svg)](https://github.com/eliasis-framework/license-handler) [![License](https://img.shields.io/packagist/l/eliasis-framework/license-handler.svg)](https://github.com/eliasis-framework/license-handler/blob/master/LICENSE) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/604b93f429f5419ca30c57bfe646d0df)](https://www.codacy.com/app/Josantonius/license-handler?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=eliasis-framework/license-handler&amp;utm_campaign=Badge_Grade) [![Build Status](https://travis-ci.org/eliasis-framework/license-handler.svg?branch=master)](https://travis-ci.org/eliasis-framework/license-handler) [![PSR2](https://img.shields.io/badge/PSR-2-1abc9c.svg)](http://www.php-fig.org/psr/psr-2/) [![PSR4](https://img.shields.io/badge/PSR-4-9b59b6.svg)](http://www.php-fig.org/psr/psr-4/) [![codecov](https://codecov.io/gh/eliasis-framework/license-handler/branch/master/graph/badge.svg)](https://codecov.io/gh/eliasis-framework/license-handler)

[English version](README.md)

Gestión de licencias y aplicaciones.

---

- [Requisitos](#requisitos)
- [Instalación](#instalación)
- [Métodos disponibles](#métodos-disponibles)
- [Cómo empezar](#cómo-empezar)
- [Uso](#uso)
- [Base de datos](#base-de-datos)
- [Tests](#tests)
- [Tareas pendientes](#-tareas-pendientes)
- [Contribuir](#contribuir)
- [Licencia](#licencia)
- [Copyright](#copyright)

---

## Requisitos

Este plugin es soportado por versiones de **PHP 5.6** o superiores y es compatible con versiones de **HHVM 3.0** o superiores.

## Instalación 

La mejor forma de instalar este plugin es a través de [Composer](http://getcomposer.org/download/).

Para instalar **License Handler**, simplemente escribe:

    $ composer require eliasis-framework/license-handler

El comando anterior sólo instalará los archivos necesarios, si prefieres **descargar todo el código fuente** puedes utilizar:

    $ composer require eliasis-framework/license-handler --prefer-source

También puedes **clonar el repositorio** completo con Git:

    $ git clone https://github.com/eliasis-framework/license-handler.git

## Métodos disponibles

Métodos disponibles en este plugin:

### Aplicaciones

#### - Agregar aplicación:

```php
$application->add($name, $type, $category, $active);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $name | Nombre de la aplicación. | string | Sí |
| $type | Tipo de aplicación. | string | Sí |
| $category | Categoría para la aplicación. | string | Sí |
| $active | Estado de la aplicación. | boolean| Sí |

**@return** (int) → ID de aplicación insertada.

#### - Actualizar aplicación:

```php
$application->update($id, $name, $type, $category, $active);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $id | ID de la aplicación. | string | Sí |
| $name | Nombre de la aplicación. | string | Sí |
| $type | Tipo de aplicación. | string | Sí |
| $category | Categoría para la aplicación. | string | Sí |
| $active | Estado de la aplicación. | boolean| Sí |

**@return** (int) → Filas afectadas.

### Sitios

#### - Agregar sitio:

```php
$site->add($domain, $host, $ip, $authorized);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $domain | Dominio del sitio. | string | Sí |
| $host | Host del sitio. | string | Sí |
| $ip | Dirección IP del sitio. | string | Sí |
| $authorized | Autorizado?. | boolean| Sí |

**@return** (int) → Site inserted ID.

#### - Actualizar sitio:

```php
$site->update($id, $domain, $host, $ip, $authorized);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $id | Site ID. | string | Sí |
| $domain | Dominio del sitio. | string | Sí |
| $host | Host del sitio. | string | Sí |
| $ip | Dirección IP del sitio. | string | Sí |
| $authorized | Autorizado?. | boolean| Sí |

**@return** (int) → ID del sitio insertado.

### Licencia

#### - Generar clave de licencia:

```php
$license->generateKey($characters, $segments);
```

| Atributo | Descripción | Tipo de dato | Requerido | Por defecto
| --- | --- | --- | --- | --- |
| $characters | Número de caracteres por segmentos. | int | No | 5 |
| $segments | Número de segmentos. | int | No | 5 |

**@return** (string) → Clave de licencia.

#### - Agregar licencia:

```php
$license->add($appID, $siteID, $key, $state, $expire);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $appID | ID de la aplicación en la base de datos. | int | Sí |
| $siteID | ID del sitio en la base de datos. | int | Sí |
| $key | Clave de licencia. | string | Sí |
| $state | Estado de licencia. | bool | Sí |
| $expire | Fecha de expiración de la licencia. | string| Sí |

**@return** (int) → ID de la licencia insertada.

#### - Actualizar licencia:

```php
$license->update($id, $appID, $siteID, $key, $state, $expire);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $id | License ID. | string | Sí |
| $appID | ID de la aplicación en la base de datos. | int | Sí |
| $siteID | ID del sitio en la base de datos. | int | Sí |
| $key | Clave de licencia. | string | Sí |
| $state | Estado de licencia. | bool | Sí |
| $expire | Fecha de expiración de la licencia. | string| Sí |

**@return** (int) → Filas afectadas.

#### - Verificar si existe la licencia:

```php
$license->keyExists($license);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $license | Clave de licencia. | string | Sí |

**@return** (boolean)

### Opciones

#### - Agregar opción:

```php
$option->add($licenseID, $name, $value);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $licenseID | ID de la licencia en la base de datos. | string | Sí |
| $name | Nombre de la opción. | string | Sí |
| $value | Valor de la opción. | string | Sí |

**@return** (int) → ID de la opción insertada.

#### - Actualizar opción:

```php
$option->update($id, $licenseID, $name, $value);
```

| Atributo | Descripción | Tipo de dato | Requerido
| --- | --- | --- | --- |
| $id | ID de la opción. | string | Sí |
| $licenseID | ID de la licencia en la base de datos. | string | Sí |
| $name | Nombre de la opción. | string | Sí |
| $value | Valor de la opción. | string | Sí |

**@return** (int) → Filas afectadas.

## Cómo empezar

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

### Aplicaciones

#### - Agregar aplicación:

```php
$appID = $application->add('app-name', 'plugin', 'WordPress', 1);
```

#### - Actualizar aplicación:

```php
$application->update($appID, 'new-app-name', 'module', 'Prestashop', 1);
```

### Sitios

#### - Agregar sitio:

```php
$siteID = $site->add(
    'domain.com', 
    'host.domain.com',
    '87.142.85.70', 1
);
```

#### - Actualizar sitio:

```php
$site->update(
    $siteID, 
    'new-domain.com', 
    'host.new-domain.com', 
    '87.142.85.70', 1
);
```

### Licencia

#### - Generar clave de licencia:

```php
$license = $license->generateKey(); // 3FGSV-BZ49N-U79EA-S96ZY-MFQ63

$license = $license->generateKey(5, 5); // 3FGSV-BZ49N-U79EA-S96ZY-MFQ63

$license = $license->generateKey(4, 4); // 3FGS-BZ4N-U7EA-S9ZY

$license = $license->generateKey(6, 5); // SF4W2H-FEJKZ5-PU7KAD-N77486-BKMJSW

$license = $license->generateKey(4, 2); // FT3Q-EBT5
```

#### - Agregar licencia:

```php
$licenseID = $license->add(1, 1, $key, $license, '+1day');

$licenseID = $license->add(1, 1, $key, $license, '+10days');

$licenseID = $license->add(1, 1, $key, $license, '+1week');

$licenseID = $license->add(1, 1, $key, $license, '+1month');

$licenseID = $license->add(1, 1, $key, $license, '+2months');

$licenseID = $license->add(1, 1, $key, $license, '+1year');

$licenseID = $license->add(1, 1, $key, $license, '+2years');
```

#### - Actualizar licencia:

```php
$license->update(1, 1, $key, $license, '+3weeks');
```

#### - Check if license exists:

```php
$license->keyExists('SF4W2H-FEJKZ5-PU7KAD-N77486-BKMJSW');
```

### Opciones

#### - Agregar opción:

```php
$option->add($licenseID, 'lang', 'es-ES');
```

#### - Actualizar opción:

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

Para ejecutar las [pruebas](tests) necesitarás [Composer](http://getcomposer.org/download/) y seguir los siguientes pasos:

    $ git clone https://github.com/eliasis-framework/license-handler.git
    
    $ cd license-handler

    $ composer install

Ejecutar pruebas unitarias con [PHPUnit](https://phpunit.de/):

    $ composer phpunit

Ejecutar pruebas de estándares de código [PSR2](http://www.php-fig.org/psr/psr-2/) con [PHPCS](https://github.com/squizlabs/PHP_CodeSniffer):

    $ composer phpcs

Ejecutar pruebas con [PHP Mess Detector](https://phpmd.org/) para detectar inconsistencias en el estilo de codificación:

    $ composer phpmd

Ejecutar todas las pruebas anteriores:

    $ composer tests

## ☑ Tareas pendientes

- [ ] Hacer funcionar PHPUnit en Travis CI.
- [ ] Agregar métodos de obtención (getter).
- [ ] Añadir nueva funcionalidad.
- [ ] Mejorar pruebas.
- [ ] Mejorar documentación.
- [ ] Refactorizar código para las reglas de estilo de código deshabilitadas. Ver [phpmd.xml](phpmd.xml) y [.php_cs.dist](.php_cs.dist).

## Contribuir

Si deseas colaborar, puedes echar un vistazo a la lista de
[issues](https://github.com/eliasis-framework/license-handler/issues) o [tareas pendientes](#-tareas-pendientes).

**Pull requests**

* [Fork and clone](https://help.github.com/articles/fork-a-repo).
* Ejecuta el comando `composer install` para instalar dependencias.
  Esto también instalará las [dependencias de desarrollo](https://getcomposer.org/doc/03-cli.md#install).
* Ejecuta el comando `composer fix` para estandarizar el código.
* Ejecuta las [pruebas](#tests).
* Crea una nueva rama (**branch**), **commit**, **push** y envíame un
  [pull request](https://help.github.com/articles/using-pull-requests).

## Repositorio

La estructura de archivos de este repositorio se creó con [PHP-Skeleton](https://github.com/Josantonius/PHP-Skeleton).

## Licencia

Este proyecto está licenciado bajo **licencia MIT**. Consulta el archivo [LICENSE](LICENSE) para más información.

## Copyright

2016 - 2018 Josantonius, [josantonius.com](https://josantonius.com/)

Si te ha resultado útil, házmelo saber :wink:

Puedes contactarme en [Twitter](https://twitter.com/Josantonius) o a través de mi [correo electrónico](mailto:hello@josantonius.com).