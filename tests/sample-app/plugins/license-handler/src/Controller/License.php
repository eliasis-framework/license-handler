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
class License extends Controller
{
    /**
     * Create table.
     */
    public function createTable()
    {
        $this->model->createTable();

        $data = Plugin::LicenseHandler()->getOption('rows', $this->model->table);

        foreach ($data as $values) {
            $values[3] = $this->generateKey();
            $this->update(...$values);
        }
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
        $exp = $this->setExpirationDate($expire);

        return $this->model->add($appID, $siteID, $key, $state, $exp);
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
     * @return int → id replaced
     */
    public function update($id, $appID, $siteID, $key, $state, $expire)
    {
        $exp = $this->setExpirationDate($expire);

        return $this->model->update($id, $appID, $siteID, $key, $state, $exp);
    }

    /**
     * Set expiration date.
     *
     * @param int $datetime → [+\-] [0] [day/days/week...]
     */
    public function setExpirationDate($datetime)
    {
        $date = new \DateTime($datetime);

        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Set expiration date.
     *
     * @author Matt - matt@webmaster-source.com
     *
     * @link http://www.webmaster-source.com/
     *
     * @param int $characters → characters number by segments
     * @param int $segments   → segments number
     *
     * @return string → license key
     */
    public function generateKey($characters = 5, $segments = 5)
    {
        do {
            $license = '';
            $tokens = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

            for ($i = 0; $i < $segments; $i++) {
                $segment = '';
                for ($j = 0; $j < $characters; $j++) {
                    $segment .= $tokens[mt_rand(0, strlen($tokens) - 1)];
                }
                $license .= $segment;
                if ($i < ($segments - 1)) {
                    $license .= '-';
                }
            }
        } while ($this->keyExists($license) !== false);

        return $license;
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
        return $this->model->keyExists($license);
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
