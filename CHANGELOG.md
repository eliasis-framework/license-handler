# CHANGELOG

## 1.0.1 - 2018-02-28

* Implemented `PHP Mess Detector` to detect inconsistencies in code styles.

* Implemented `PHP Code Beautifier and Fixer` to fixing errors automatically.

* Implemented `PHP Coding Standards Fixer` to organize PHP code automatically according to PSR standards.

* Implemented `PSR-4 autoloader standard` from all library files.

* Implemented `PSR-2 coding standard` from all library PHP files.

* Implemented `PHPCS` to ensure that PHP code complies with `PSR2` code standards.

* Implemented `Codacy` to automates code reviews and monitors code quality over time.

* Implemented `Codecov` to coverage reports.

## 1.0.0 - 2017-07-04

* Added `App\Modules\LicenseHandler\Controller\Exception\LHException` class.
* Added `App\Modules\LicenseHandler\Controller\Exception\LHException->__construct()` method.

* Added `App\Modules\LicenseHandler\Controller\Launcher\Launcher` class.
* Added `App\Modules\LicenseHandler\Controller\Launcher\Launcher->init()` method.
* Added `App\Modules\LicenseHandler\Controller\Launcher\Launcher->getDatabaseId()` method.
* Added `App\Modules\LicenseHandler\Controller\Launcher\Launcher->activation()` method.
* Added `App\Modules\LicenseHandler\Controller\Launcher\Launcher->deactivation()` method.
* Added `App\Modules\LicenseHandler\Controller\Launcher\Launcher->setDefaultTimezone()` method.

* Added `App\Modules\LicenseHandler\Controller\Application\Application` class.
* Added `App\Modules\LicenseHandler\Controller\Application\Application->createTable()` method.
* Added `App\Modules\LicenseHandler\Controller\Application\Application->insert()` method.
* Added `App\Modules\LicenseHandler\Controller\Application\Application->replace()` method.
* Added `App\Modules\LicenseHandler\Controller\Application\Application->dropTable()` method.

* Added `App\Modules\LicenseHandler\Model\Application\Application` class.
* Added `App\Modules\LicenseHandler\Model\Application\Application->__construct()` method.
* Added `App\Modules\LicenseHandler\Model\Application\Application->createTable()` method.
* Added `App\Modules\LicenseHandler\Model\Application\Application->insert()` method.
* Added `App\Modules\LicenseHandler\Model\Application\Application->replace()` method.
* Added `App\Modules\LicenseHandler\Model\Application\Application->dropTable()` method.

* Added `App\Modules\LicenseHandler\Controller\License\License` class.
* Added `App\Modules\LicenseHandler\Controller\License\License->createTable()` method.
* Added `App\Modules\LicenseHandler\Controller\License\License->insert()` method.
* Added `App\Modules\LicenseHandler\Controller\License\License->replace()` method.
* Added `App\Modules\LicenseHandler\Controller\License\License->dropTable()` method.
* Added `App\Modules\LicenseHandler\Controller\License\License->setExpirationDate()` method.
* Added `App\Modules\LicenseHandler\Controller\License\License->generateLicense()` method.
* Added `App\Modules\LicenseHandler\Controller\License\License->licenceExists()` method.

* Added `App\Modules\LicenseHandler\Model\License\License` class.
* Added `App\Modules\LicenseHandler\Model\License\License->__construct()` method.
* Added `App\Modules\LicenseHandler\Model\License\License->createTable()` method.
* Added `App\Modules\LicenseHandler\Model\License\License->insert()` method.
* Added `App\Modules\LicenseHandler\Model\License\License->replace()` method.
* Added `App\Modules\LicenseHandler\Model\License\License->dropTable()` method.
* Added `App\Modules\LicenseHandler\Model\License\License->licenceExists()` method.

* Added `App\Modules\LicenseHandler\Controller\Setting\Setting` class.
* Added `App\Modules\LicenseHandler\Controller\Setting\Setting->createTable()` method.
* Added `App\Modules\LicenseHandler\Controller\Setting\Setting->insert()` method.
* Added `App\Modules\LicenseHandler\Controller\Setting\Setting->replace()` method.
* Added `App\Modules\LicenseHandler\Controller\Setting\Setting->dropTable()` method.

* Added `App\Modules\LicenseHandler\Model\Setting\Setting` class.
* Added `App\Modules\LicenseHandler\Model\Setting\Setting->__construct()` method.
* Added `App\Modules\LicenseHandler\Model\Setting\Setting->createTable()` method.
* Added `App\Modules\LicenseHandler\Model\Setting\Setting->insert()` method.
* Added `App\Modules\LicenseHandler\Model\Setting\Setting->replace()` method.
* Added `App\Modules\LicenseHandler\Model\Setting\Setting->dropTable()` method.

* Added `App\Modules\LicenseHandler\Controller\Site\Site` class.
* Added `App\Modules\LicenseHandler\Controller\Site\Site->createTable()` method.
* Added `App\Modules\LicenseHandler\Controller\Site\Site->insert()` method.
* Added `App\Modules\LicenseHandler\Controller\Site\Site->replace()` method.
* Added `App\Modules\LicenseHandler\Controller\Site\Site->dropTable()` method.

* Added `App\Modules\LicenseHandler\Model\Site\Site` class.
* Added `App\Modules\LicenseHandler\Model\Site\Site->__construct()` method.
* Added `App\Modules\LicenseHandler\Model\Site\Site->createTable()` method.
* Added `App\Modules\LicenseHandler\Model\Site\Site->insert()` method.
* Added `App\Modules\LicenseHandler\Model\Site\Site->replace()` method.
* Added `App\Modules\LicenseHandler\Model\Site\Site->dropTable()` method.

* Added `config/datetime.php` file.
* Added `config/rows.php` file.
* Added `config/set-classes.php` file.
* Added `config/namespaces.php` file.
* Added `config/set-hooks.php` file.
* Added `config/tables.php` file.

* Added `license-handler.php` file.
