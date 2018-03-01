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
final class LicenseTest extends TestCase
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'test_licenses';

    /**
     * App instance.
     *
     * @var object
     */
    protected $app;

    /**
     * License controller instance.
     *
     * @var object
     */
    protected $license;

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

        $this->license = $plugin->getControllerInstance('License');

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
                           ->where(['lic_id = 1'])
                           ->execute();

        $this->assertSame($result[0]->lic_id, '1');
        $this->assertSame($result[0]->app_id, '1');
        $this->assertSame($result[0]->site_id, '1');
        $this->assertSame($result[0]->lic_state, '0');

        $regExp = '/[A-Z\d-]{29}/';

        preg_match_all($regExp, $result[0]->lic_key, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);

        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->lic_expire
            ) !== false
        );
        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->updated
            ) !== false
        );
        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->created
            ) !== false
        );
    }

    /**
     * Should insert elements into the database.
     */
    public function testShouldInsertElementsIntoTheDatabase()
    {
        $id = $this->license->add(1, 1, 'Q5SHK-BZ49N-U79EA-S96ZY-MFQ63', 1, '+10days');

        $this->assertSame($id, 2);

        $result = $this->db->select()
                           ->from($this->table)
                           ->where(['lic_id = 2'])
                           ->execute();

        $this->assertSame($result[0]->app_id, '1');
        $this->assertSame($result[0]->site_id, '1');
        $this->assertSame($result[0]->lic_state, '1');

        $regExp = '/[A-Z\d-]{29}/';

        preg_match_all($regExp, $result[0]->lic_key, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);

        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->lic_expire
            ) !== false
        );
        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->updated
            ) !== false
        );
        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->created
            ) !== false
        );
    }

    /**
     * Should replace elements into the database.
     */
    public function testShouldReplaceElementsIntoTheDatabase()
    {
        $rows = $this->license->update(2, 1, 1, '3FGSV-BZ49N-U79EA-S96ZY-MFQ63', 0, '+8days');

        $this->assertSame($rows, 1);

        $result = $this->db->select()
                           ->from($this->table)
                           ->where(['lic_id = 2'])
                           ->execute();

        $this->assertSame($result[0]->app_id, '1');
        $this->assertSame($result[0]->site_id, '1');
        $this->assertSame($result[0]->lic_state, '0');

        $regExp = '/[A-Z\d-]{29}/';

        preg_match_all($regExp, $result[0]->lic_key, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);

        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->lic_expire
            ) !== false
        );
        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->updated
            ) !== false
        );
        $this->assertTrue(
            \DateTime::createFromFormat(
                'Y-m-d G:i:s',
                $result[0]->created
            ) !== false
        );
    }

    /**
     * Should validate if a license exists in the database.
     */
    public function testShouldValidateIfLicenseExistsOnDatabase()
    {
        $this->assertTrue(
            $this->license->keyExists('3FGSV-BZ49N-U79EA-S96ZY-MFQ63')
        );

        $this->assertFalse(
            $this->license->keyExists('')
        );
    }

    /**
     * Should generate licenses in a specific format by default.
     *
     * Example: 3FGSV-BZ49N-U79EA-S96ZY-MFQ63
     */
    public function testShouldGenerateLicensesInSpecificFormatByDefault()
    {
        $license = $this->license->generateKey();

        $regExp = '/[A-Z\d-]{29}/';

        preg_match_all($regExp, $license, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);
    }

    /**
     * Should generate licenses by customizing the format.
     */
    public function testShouldGenerateLicensesByCustomizingTheFormat()
    {
        // 3FGS-BZ4N-U7EA-S9ZY

        $license = $this->license->generateKey(4, 4);

        preg_match_all('/[A-Z\d-]{19}/', $license, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);

        // SF4W2H-FEJKZ5-PU7KAD-N77486-BKMJSW

        $license = $this->license->generateKey(6, 5);

        preg_match_all('/[A-Z\d-]{34}/', $license, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);

        // FT3Q-EBT5

        $license = $this->license->generateKey(4, 2);

        preg_match_all('/[A-Z\d-]{9}/', $license, $matches, PREG_SET_ORDER, 0);

        $this->assertSame(count($matches), 1);
    }

    /**
     * Should set license expiration date.
     */
    public function testShouldSetLicenseExpirationDate()
    {
        $time = '+1day';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%aday');
        $this->assertSame($time, $elapsed);

        $time = '+10days';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%adays');
        $this->assertSame($time, $elapsed);

        $time = '+1week';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%adays');
        $this->assertSame('+7days', $elapsed);

        $time = '+1month';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%mmonth');
        $this->assertSame($time, $elapsed);

        $time = '+2months';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%mmonths');
        $this->assertSame($time, $elapsed);

        $time = '+1year';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%yyear');
        $this->assertSame($time, $elapsed);

        $time = '+2years';
        $expirationDate = $this->license->setExpirationDate($time);
        $interval = (new \DateTime())->diff(new \DateTime($expirationDate));
        $elapsed = $interval->format('+%yyears');
        $this->assertSame($time, $elapsed);
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
