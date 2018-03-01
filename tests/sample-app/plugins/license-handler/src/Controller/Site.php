<?php
/**
 * Licensing and applications manager.
 *
 * @authorizedor    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - License Handler
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/license-handler.git
 * @since     1.0.0
 */
namespace Eliasis\Plugins\LicenseHandler\Controller;

use Eliasis\Complement\Type\Plugin;
use Eliasis\Framework\Controller;

/**
 * Plugin main controller.
 */
class Site extends Controller
{
    /**
     * Create table.
     */
    public function createTable()
    {
        $this->model->createTable();

        $data = Plugin::LicenseHandler()->getOption('rows', $this->model->table);

        foreach ($data as $values) {
            $this->update(...$values);
        }
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
        return $this->model->add($domain, $host, $ip, $authorized);
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
        return $this->model->update($id, $domain, $host, $ip, $authorized);
    }

    /**
     * Delete table.
     *
     * @return bool true|false
     */
    public function dropTable()
    {
        return $this->model->dropTable();
    }
}
