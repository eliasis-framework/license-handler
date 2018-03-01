<?php
/**
 * Licensing and applications manager.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - License Handler
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/license-handler.git
 * @since     1.0.0
 */
namespace Eliasis\Plugins\LicenseHandler\Model;

use Eliasis\Complement\Type\Plugin;
use Eliasis\Framework\Model;
use Josantonius\Database\Database;

/**
 * Plugin main model.
 */
class Application extends Model
{
    /**
     * Database table name.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $table = 'applications';

    /**
     * Database prefix.
     *
     * @since 1.0.1
     *
     * @var array
     */
    public $columns;

    /**
     * Database prefix.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $prefix;

    /**
     * Database engine.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $engine;

    /**
     * Database charset.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $charset;

    /**
     * Model construct.
     */
    public function __construct()
    {
        $plugin = Plugin::LicenseHandler();

        $db = $plugin->getOption('db');

        $this->prefix = $db['prefix'];
        $this->engine = $db['engine'];
        $this->charset = $db['charset'];

        $this->columns = $plugin->getOption('table', $this->table);

        $this->changeDatabaseConnection($db['id']);
    }

    /**
     * Create table.
     *
     * @return bool
     */
    public function createTable()
    {
        $params = [
            $this->columns['id'] => 'INT(9) AUTO_INCREMENT PRIMARY KEY',
            $this->columns['name'] => 'VARCHAR(80) NOT NULL UNIQUE',
            $this->columns['type'] => 'VARCHAR(80) NOT NULL',
            $this->columns['category'] => 'VARCHAR(80) NOT NULL',
            $this->columns['state'] => 'INT(1) NOT NULL',
            $this->columns['updated'] => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            $this->columns['created'] => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ];

        return $this->db->create($params)
                        ->table($this->prefix . $this->table)
                        ->engine($this->engine)
                        ->charset($this->charset)
                        ->execute();
    }

    /**
     * Insert row.
     *
     * @param string $name     → application name
     * @param string $type     → application type
     * @param string $category → application category
     * @param bool   $state    → active or inactive
     *
     * @return int → id inserted
     */
    public function add($name, $type, $category, $state)
    {
        $data = [
            $this->columns['name'] => '?',
            $this->columns['type'] => '?',
            $this->columns['category'] => '?',
            $this->columns['state'] => '?',
        ];

        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('str', $name),   'str'];
        $statements[] = [2, $launcher->validate('str', $type),   'str'];
        $statements[] = [3, $launcher->validate('str', $category), 'str'];
        $statements[] = [4, $launcher->validate('bool', $state), 'bool'];

        $query = $this->db->insert($data, $statements)
                          ->from($this->prefix . $this->table);

        return $query->execute('id');
    }

    /**
     * Replace a row if it exists or insert a new row.
     *
     * @param int    $id       → application id
     * @param string $name     → application name
     * @param string $type     → application type
     * @param string $category → application category
     * @param bool   $state    → active or inactive
     *
     * @return int → rows affected
     */
    public function update($id, $name, $type, $category, $state)
    {
        $data = [
            $this->columns['id'] => '?',
            $this->columns['name'] => '?',
            $this->columns['type'] => '?',
            $this->columns['category'] => '?',
            $this->columns['state'] => '?',
        ];

        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('int', $id),     'int'];
        $statements[] = [2, $launcher->validate('str', $name),   'str'];
        $statements[] = [3, $launcher->validate('str', $type),   'str'];
        $statements[] = [4, $launcher->validate('str', $category), 'str'];
        $statements[] = [5, $launcher->validate('bool', $state), 'bool'];

        $query = $this->db->replace($data, $statements)
                          ->from($this->prefix . $this->table);

        return $query->execute('rows');
    }

    /**
     * Delete requests table.
     *
     * @return bool
     */
    public function dropTable()
    {
        $query = $this->db->drop()
                          ->table($this->prefix . $this->table);

        return $query->execute();
    }
}
