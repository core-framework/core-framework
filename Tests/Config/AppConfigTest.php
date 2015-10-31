<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 13/10/15
 * Time: 11:27 AM
 */

namespace Tests\Config;


use Core\Config\AppConfig;

class AppConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var $config AppConfig
     */
    public $config;
    public static $editableConf = '/config/override.conf.php';

    public function setUp()
    {
        $this->config = new AppConfig();
    }

    public function tearDown()
    {
        $perms = substr(decoct(fileperms(_ROOT . static::$editableConf)),2);
        chmod(_ROOT . static::$editableConf, 0777);
        $data = '<?php return ' . var_export(array(), true) . ";\n ?>";
        file_put_contents(_ROOT . static::$editableConf, $data);
        chmod(_ROOT . static::$editableConf, octdec($perms));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionOnCreation()
    {
        new AppConfig('');
    }

    public function testSetUpUsingArray()
    {
        $config = new AppConfig(array('Test' => array('testArr')));
        $this->assertInstanceOf('\\Core\\Config\\AppConfig', $config);
        $this->assertArrayHasKey('Test', AppConfig::$allConf);
    }

    public function testAddConf()
    {
        AppConfig::addConf('addArr', array('testKey' => 'testVal'));
        $this->assertArrayHasKey('addArr', AppConfig::$allConf);
    }

    public function testSetConf()
    {
        AppConfig::setConf(array('newArr' => array('testKey' => 'testVal')));
        $this->assertArrayHasKey('newArr', AppConfig::$allConf);
        $this->assertArrayNotHasKey('addArr', AppConfig::$allConf);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Given argument must be a readable file path.
     */
    public function testExceptionOnSetFile()
    {
        AppConfig::setFile("");
    }

    public function testSetFile()
    {
        AppConfig::setFile(_ROOT . "/config/framework.conf.php");
        $this->assertArrayHasKey('$global', AppConfig::$allConf);
        $this->assertArrayHasKey('$db', AppConfig::$allConf);
        $this->assertArrayHasKey('$routes', AppConfig::$allConf);
    }

    public function testSetEditableConfFile()
    {
        $editablePath = _ROOT . "/config/override.conf.php";
        $this->config->setEditableConfFile($editablePath);
        $this->assertEquals($editablePath, AppConfig::$confEditablePath);
    }

    public function testStore()
    {
        AppConfig::store(['storedArr' => 'storedVal']);
        $this->assertFileExists(AppConfig::$confEditablePath);

        $contents = AppConfig::getFileContent(AppConfig::$confEditablePath);
        $this->assertArrayHasKey('storedArr', $contents);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Nothing to save!
     */
    public function testStoreThrowsExceptionOnNoOrEmptyArgument()
    {
        AppConfig::store();
        AppConfig::store([]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Given argument must be an Array.
     */
    public function testStoreThrowsExceptionOnStringArgument()
    {
        AppConfig::store('string');
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Editable config file not provided.
     */
    public function testStoreThrowsExceptionWhenEditableFileNotSet()
    {
        AppConfig::$confEditablePath = null;
        AppConfig::store(['storedArr' => 'storedVal']);
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Provided config file is not readable.
     */
    public function testStoreThrowsExceptionWhenEditableFileNotReadable()
    {
        AppConfig::$confEditablePath = "/config/override.conf.php";
        AppConfig::store(['storedArr' => 'storedVal']);
    }

    public function testGetFileContentAllwaysReturnsArray()
    {
        $content = AppConfig::getFileContent('/config/override.conf.php');
        $this->assertInternalType('array', $content);
    }

    public function testGetFileContentWorksWithValidFile()
    {
        $content = AppConfig::getFileContent(_ROOT . '/config/framework.conf.php');
        $this->assertInternalType('array', $content);
        $this->assertArrayHasKey('$global', $content);
    }

    public function testPutFileContentWorksWithValidFileAndArgument()
    {
        AppConfig::putFileContent(_ROOT . static::$editableConf, ['putArr' => ['putKey' => 'putVal']]);

        $content = include _ROOT . static::$editableConf;
        $this->assertArrayHasKey('putArr', $content);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Content to put in file must be an Array.
     */
    public function testPutFileContentThrowsExceptionOnStringArgument()
    {
        AppConfig::putFileContent(_ROOT . static::$editableConf, 'someString');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Nothing to put in file.
     */
    public function testPutFileContentThrowsExceptionOnEmptyArray()
    {
        AppConfig::putFileContent(_ROOT . static::$editableConf, []);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Given file not readable Or writable.
     */
    public function testPutFileContentThrowsExceptionOnInvalidFile()
    {
        AppConfig::putFileContent('/someFile.php', ['putArr' => ['putKey' => 'putVal']]);
    }
}