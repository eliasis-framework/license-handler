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
class Site extends Model
{
    /**
     * Database table name.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $table = 'sites';

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
            $this->columns['domain'] => 'VARCHAR(255) NOT NULL',
            $this->columns['host'] => 'VARCHAR(255) NOT NULL UNIQUE',
            $this->columns['ip'] => 'VARCHAR(15)  NOT NULL UNIQUE',
            $this->columns['authorized'] => 'INT(1) NOT NULL',
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
     * @param string $domain     → site domain
     * @param string $host       → site host
     * @param string $ip         → site ip
     * @param bool   $authorized → site authorized
     *
     * @return int → id inserted
     */
    public function add($domain, $host, $ip, $authorized)
    {
        $data = [
            $this->columns['domain'] => '?',
            $this->columns['host'] => '?',
            $this->columns['ip'] => '?',
            $this->columns['authorized'] => '?',
        ];

        $statements[] = [1, $domain, 'str'];
        $statements[] = [2, $host,   'str'];
        $statements[] = [3, $ip,     'str'];
        $statements[] = [4, $authorized,   'bool'];

        $query = $this->db->insert($data, $statements)
                          ->from($this->prefix . $this->table);

        return $query->execute('id');
    }

    /**
     * Replace a row if it exists or insert a new row.
     *
     * @param int    $id         → site id
     * @param string $domain     → site domain
     * @param string $host       → site host
     * @param string $ip         → site ip
     * @param bool   $authorized → site authorized
     *
     * @return int → rows affected
     */
    public function update($id, $domain, $host, $ip, $authorized)
    {
        $data = [
            $this->columns['id'] => '?',
            $this->columns['domain'] => '?',
            $this->columns['host'] => '?',
            $this->columns['ip'] => '?',
            $this->columns['authorized'] => '?',
        ];

        $statements[] = [1, $id,     'int'];
        $statements[] = [2, $domain, 'str'];
        $statements[] = [3, $host,   'str'];
        $statements[] = [4, $ip,     'str'];
        $statements[] = [5, $authorized,   'bool'];

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
