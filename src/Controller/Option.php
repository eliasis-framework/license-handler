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
namespace Eliasis\Plugins\LicenseHandler\Controller;

use Eliasis\Complement\Type\Plugin;
use Eliasis\Framework\Controller;

/**
 * Plugin main controller.
 */
class Option extends Controller
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
     * @param int    $licenseID → license table id
     * @param string $name      → option name
     * @param string $value     → option value
     *
     * @return int → id inserted
     */
    public function add($licenseID, $name, $value)
    {
        return $this->model->add($licenseID, $name, $value);
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
        return $this->model->update($id, $licenseID, $name, $value);
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
