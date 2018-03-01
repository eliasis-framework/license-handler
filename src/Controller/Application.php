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
class Application extends Controller
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
     * @param string $name     → application name
     * @param string $type     → application type
     * @param string $category → application category
     * @param bool   $active   → active or inactive
     *
     * @return int → id inserted
     */
    public function add($name, $type, $category, $active)
    {
        return $this->model->add($name, $type, $category, $active);
    }

    /**
     * Replace a row if it exists or insert a new row.
     *
     * @param int    $id       → application id
     * @param string $name     → application name
     * @param string $type     → application type
     * @param string $category → application category
     * @param bool   $active   → active or inactive
     *
     * @return int → rows affected
     */
    public function update($id, $name, $type, $category, $active)
    {
        return $this->model->update($id, $name, $type, $category, $active);
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
