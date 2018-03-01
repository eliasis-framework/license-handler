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
class Launcher extends Controller
{
    /**
     * Available database controllers.
     *
     * @since 1.0.1
     *
     * @var string
     */
    public $controllers = ['Application', 'Site', 'License', 'Option'];

    /**
     * Main method.
     */
    public function init()
    {
        if (Plugin::LicenseHandler()->getState() !== 'active') {
            return;
        }

        $this->setDefaultTimezone();
    }

    /**
     * Activation hook.
     */
    public function activation()
    {
        foreach ($this->controllers as $controller) {
            Plugin::LicenseHandler()->getControllerInstance(
                $controller,
                'controller'
            )->createTable();
        }
    }

    /**
     * Uninstallation hook.
     *
     * @since 1.0.1
     */
    public function uninstallation()
    {
        foreach (array_reverse($this->controllers) as $controller) {
            Plugin::LicenseHandler()->getControllerInstance(
                $controller,
                'controller'
            )->dropTable();
        }
    }

    /**
     * Sanitize and validate data.
     *
     * @since 1.0.1
     *
     * @return mixed
     */
    public function validate($type, $data)
    {
        switch ($type) {
            case 'ip':
                $data = filter_var($data, FILTER_VALIDATE_IP) ? $data : '';
                break;
            case 'str':
                $data = filter_var($data, FILTER_SANITIZE_STRING);
                break;
            case 'int':
                $data = filter_var($data, FILTER_VALIDATE_INT);
                break;
            case 'url':
                $data = filter_var($data, FILTER_SANITIZE_URL);
                break;
            case 'float':
                $data = filter_var($data, FILTER_VALIDATE_FLOAT);
                break;
            case 'bool':
                $data = filter_var($data, FILTER_VALIDATE_BOOLEAN);
                break;
            default:
        }

        return $data;
    }

    /**
     * Set default timezone.
     */
    public static function setDefaultTimezone()
    {
        date_default_timezone_set(
            Plugin::LicenseHandler()->getOption('datetime', 'timezone')
        );
    }
}
