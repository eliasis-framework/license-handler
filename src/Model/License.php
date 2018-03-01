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
class License extends Model
{
    /**
     * Database table name.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $table = 'licenses';

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

        $data['apps'] = 'applications';
        $data['sites'] = 'sites';

        $data['app-id'] = $plugin->getOption('table', $data['apps'], 'id');
        $data['site-id'] = $plugin->getOption('table', $data['sites'], 'id');

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
            $this->columns['app-id'] => 'INT(9) NOT NULL',
            $this->columns['site-id'] => 'INT(9) NOT NULL',
            $this->columns['key'] => 'VARCHAR(29) NOT NULL UNIQUE',
            $this->columns['state'] => 'INT(1) NOT NULL',
            $this->columns['expire'] => 'DATETIME NOT NULL',
            $this->columns['updated'] => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            $this->columns['created'] => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ];

        $actions = 'ON DELETE CASCADE ON UPDATE CASCADE';

        return $this->db->create($params)
                        ->table($this->prefix . $this->table)
                        ->foreing($this->columns['app-id'])
                        ->reference($this->columns['app-id'])
                        ->on($this->prefix . $this->columns['apps'])
                        ->foreing($this->columns['site-id'])
                        ->reference($this->columns['site-id'])
                        ->on($this->prefix . $this->columns['sites'])
                        ->actions($actions)
                        ->engine($this->engine)
                        ->charset($this->charset)
                        ->execute();
    }

    /**
     * Insert row.
     *
     * @param int    $appID  → application table id
     * @param int    $siteID → site table id
     * @param string $key    → license key
     * @param bool   $state  → license state
     * @param string $expire → license expiration date
     *
     * @return int → id inserted
     */
    public function add($appID, $siteID, $key, $state, $expire)
    {
        $data = [
            $this->columns['app-id'] => '?',
            $this->columns['site-id'] => '?',
            $this->columns['key'] => '?',
            $this->columns['state'] => '?',
            $this->columns['expire'] => '?',
        ];

        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('int', $appID),  'int'];
        $statements[] = [2, $launcher->validate('int', $siteID), 'int'];
        $statements[] = [3, $launcher->validate('str', $key),    'str'];
        $statements[] = [4, $launcher->validate('bool', $state), 'bool'];
        $statements[] = [5, $launcher->validate('str', $expire), 'str'];

        $query = $this->db->insert($data, $statements)
                          ->from($this->prefix . $this->table);

        return $query->execute('id');
    }

    /**
     * Replace a row if it exists or insert a new row.
     *
     * @param int    $id     → license id
     * @param int    $appID  → application table id
     * @param int    $siteID → site table id
     * @param string $key    → license key
     * @param bool   $state  → license state
     * @param string $expire → license expiration date
     *
     * @return int → rows affected
     */
    public function update($id, $appID, $siteID, $key, $state, $expire)
    {
        $data = [
            $this->columns['id'] => '?',
            $this->columns['app-id'] => '?',
            $this->columns['site-id'] => '?',
            $this->columns['key'] => '?',
            $this->columns['state'] => '?',
            $this->columns['expire'] => '?',
        ];

        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('int', $id),     'int'];
        $statements[] = [2, $launcher->validate('int', $appID),  'int'];
        $statements[] = [3, $launcher->validate('int', $siteID), 'int'];
        $statements[] = [4, $launcher->validate('str', $key),    'str'];
        $statements[] = [5, $launcher->validate('bool', $state), 'bool'];
        $statements[] = [6, $launcher->validate('str', $expire), 'str'];

        $query = $this->db->replace($data, $statements)
                          ->from($this->prefix . $this->table);

        return $query->execute('rows');
    }

    /**
     * Check if license exists.
     *
     * @param string $license → license key
     *
     * @return bool true|false
     */
    public function keyExists($license)
    {
        $launcher = Plugin::LicenseHandler()->getControllerInstance('Launcher');

        $statements[] = [1, $launcher->validate('str', $license), 'str'];

        $clauses = [$this->columns['key'] . '= ?'];

        $query = $this->db->select($this->columns['key'])
                          ->from($this->prefix . $this->table)
                          ->where($clauses, $statements)
                          ->limit(1);

        return $query->execute('rows') === 1;
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
