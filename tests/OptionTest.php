<?php
/**
 * Licensing and applications manager.
 *
 * @author    Josantonius <hello@josantonius.com>
 * @copyright 2017 - 2018 (c) Josantonius - License Handler
 * @license   https://opensource.org/licenses/MIT - The MIT License (MIT)
 * @link      https://github.com/eliasis-framework/license-handler.git
 * @since     1.0.1
 */
namespace Eliasis\Plugins\LicenseHandler;

use Eliasis\Complement\Type\Plugin;
use Eliasis\Framework\App;
use Josantonius\Database\Database;
use PHPUnit\Framework\TestCase;

/**
 * Tests class for License Handler Eliasis plugin.
 */
final class OptionTest extends TestCase
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'test_options';

    /**
     * App instance.
     *
     * @var object
     */
    protected $app;

    /**
     * Option controller instance.
     *
     * @var object
     */
    protected $option;

    /**
     * Launcher instance.
     *
     * @var object
     */
    protected $launcher;

    /**
     * Root path.
     *
     * @var string
     */
    protected $root;

    /**
     * Database connection.
     *
     * @var object
     */
    protected $db;

    /**
     * Set up.
     */
    public function setUp()
    {
        parent::setUp();

        $this->app = new App();
        $this->root = $_SERVER['DOCUMENT_ROOT'];

        $app = $this->app;
        $app::run($this->root);

        $this->db = Database::getConnection('app');

        $plugin = Plugin::LicenseHandler();

        $this->option = $plugin->getControllerInstance('Option');

        $this->launcher = $plugin->getControllerInstance('Launcher');
    }

    /**
     * Check if it is an instance of.
     */
    public function testIsInstanceOf()
    {
        $this->assertInstanceOf('Eliasis\Framework\App', $this->app);
        $this->assertInstanceOf('Josantonius\Database\Database', $this->db);
        $this->assertInstanceOf(
            'Eliasis\Plugins\LicenseHandler\Controller\Launcher',
            $this->launcher
        );
    }

    /**
     * A table should be created when install the plugin.
     */
    public function testTableShouldBeCreatedWhenInstallThePlugin()
    {
        $rows = $this->db->query("SELECT count(*)
                                  FROM information_schema.tables
                                  WHERE table_schema = '{$GLOBALS['DB_NAME']}'
                                  AND table_name = '$this->table'");

        $result = array_values((array) $rows[0]);

        $this->assertSame((int) $result[0], 1);
    }

    /**
     * Should create a row with default fields.
     */
    public function testShouldCreateRowWithDefaultFields()
    {
        $result = $this->db->select()
                           ->from($this->table)
                           ->where(['option_id = 1'])
                           ->execute();

        $this->assertSame($result[0]->option_id, '1');
        $this->assertSame($result[0]->lic_id, '1');
        $this->assertSame($result[0]->option_name, 'lang');
        $this->assertSame($result[0]->option_value, 'es-ES');
    }

    /**
     * Should insert elements into the database.
     */
    public function testShouldInsertElementsIntoTheDatabase()
    {
        $id = $this->option->add(1, 'lang', 'es-ES');

        $this->assertSame($id, 2);

        $result = $this->db->select()
                           ->from($this->table)
                           ->where(['option_id = 2'])
                           ->execute();

        $this->assertSame($result[0]->option_id, '2');
        $this->assertSame($result[0]->lic_id, '1');
        $this->assertSame($result[0]->option_name, 'lang');
        $this->assertSame($result[0]->option_value, 'es-ES');
    }

    /**
     * Should replace elements into the database.
     */
    public function testShouldReplaceElementsIntoTheDatabase()
    {
        $rows = $this->option->update(2, 1, 'lang', 'en-EN');

        $this->assertSame($rows, 1);

        $result = $this->db->select()
                           ->from($this->table)
                           ->where(['option_id = 2'])
                           ->execute();

        $this->assertSame($result[0]->option_id, '2');
        $this->assertSame($result[0]->lic_id, '1');
        $this->assertSame($result[0]->option_name, 'lang');
        $this->assertSame($result[0]->option_value, 'en-EN');
    }

    /**
     * A table should be deleted when uninstall the plugin.
     */
    public function testTableShouldBeDeletedWhenUninstallThePlugin()
    {
        Plugin::LicenseHandler()->doAction('uninstallation');

        $rows = $this->db->query("SELECT count(*)
                                  FROM information_schema.tables
                                  WHERE table_schema = '{$GLOBALS['DB_NAME']}'
                                  AND table_name = '$this->table'");

        $result = array_values((array) $rows[0]);

        $this->assertSame((int) $result[0], 0);
    }
}
