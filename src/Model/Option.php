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
class Option extends Model
{
    /**
     * Database table name.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $table = 'options';

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

        $this->changeDatabaseConnection($db['id']);

        $data = $plugin->getOption('table', $this->table);

        $data['licenses'] = 'licenses';

        $data['lic-id'] = $plugin->getOption('table', $data['licenses'], 'id');

        $this->columns = $data;
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
            $this->columns['lic-id'] => 'INT(9) NOT NULL',
            $this->columns['name'] => 'VARCHAR(180) NOT NULL',
            $this->columns['value'] => 'LONGTEXT NOT NULL'
        ];

        $actions = 'ON DELETE CASCADE ON UPDATE CASCADE';

        return $this->db->create($params)
                        ->table($this->prefix . $this->table)
                        ->foreing($this->columns['lic-id'])
                        ->reference($this->columns['lic-id'])
                        ->on($this->prefix . $this->columns['licenses'])
                        ->actions($actions)
                        ->engine($this->engine)
                        ->charset($this->charset)
                        ->execute();
    }

    /**
     * Add option.
     *
     * @param int    $licenseID → license table id
     * @param string $name      → option name
     * @param string $value     → option value
     *
     * @return int → id inserted
     */
    public function add($licenseID, $name, $value)
    {
        $data = [
            $this->columns['lic-id'] => '?',
            $this->columns['name'] => '?',
            $this->columns['value'] => '?',
        ];

        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('int', $licenseID), 'int'];
        $statements[] = [2, $launcher->validate('str', $name),  'str'];
        $statements[] = [3, $launcher->validate('str', $value),  'str'];

        $query = $this->db->insert($data, $statements)
                          ->from($this->prefix . $this->table);

        return $query->execute('id');
    }

    /**
     * Replace a row if it exists or insert a new row.
     *
     * @param int    $id        → setting table id
     * @param int    $licenseID → license table id
     * @param string $name      → option name
     * @param string $value     → option value
     *
     * @return int → rows affected
     */
    public function update($id, $licenseID, $name, $value)
    {
        $data = [
            $this->columns['id'] => '?',
            $this->columns['lic-id'] => '?',
            $this->columns['name'] => '?',
            $this->columns['value'] => '?',
        ];

        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('int', $id),        'int'];
        $statements[] = [2, $launcher->validate('int', $licenseID), 'int'];
        $statements[] = [3, $launcher->validate('str', $name),  'str'];
        $statements[] = [4, $launcher->validate('str', $value),  'str'];

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
