<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 11/01/15
 * Time: 10:44 AM
 */

namespace Core\Tests\CLI;


use Core\DI\DI;
use Core\Scripts\CLI;

class CLITest extends \PHPUnit_Framework_TestCase {

    private $iostream;

    private $config;

    private $output;
    /**
     * @var CLI
     */
    private $cli;

    public static $verbose;

    protected function setUp()
    {
        parent::setUp();

        define('DS', DIRECTORY_SEPARATOR);
        chdir(__DIR__ . DS . ".." . DS . ".." . DS);
        $this->vendor = $vendor = getcwd() . DS . "vendor";
        if (is_dir($vendor)) {
            $rootDir = getcwd();
            define('_ROOT', $rootDir);
            define('_isPROJECT', true);
        } else {
            chdir(".." . DS . ".." . DS);
            $vendor = getcwd() . DS . "vendor";
            if ($vendor) {
                $rootDir = getcwd();
                define('_ROOT', $rootDir);
                define('_isPROJECT', false);
            } else {
                throw new \ErrorException("Vendor path not found");
            }
        }

        require_once _ROOT . DS . "src" . DS . "Core" . DS . "inc" . DS . "clibootstrap.php";
        $this->cli = DI::get('CLI');
    }

    public function testCLIConstruct()
    {
        $this->assertInstanceOf('Core\\Scripts\\CLI', $this->cli);
    }

    public function testToolName()
    {
        $this->assertEquals("Console", $this->cli->getToolName());
    }

    public function testUsage()
    {
        $this->assertEquals("Console [globalOptions] command [arguments || [options]]", $this->cli->getUsage());
    }

    public function testVersion()
    {
        $this->assertEquals("0.0.1", $this->cli->getVersion());
    }

    public function testToolNameAfterChange()
    {
        $this->cli->setToolName('someToolname');
        $this->assertEquals('someToolname', $this->cli->getToolName());
    }

    public function testUsageAfterChange()
    {
        $this->cli->setUsage('Some usage [method]');
        $this->assertEquals('Some usage [method]', $this->cli->getUsage());
    }

    public function testVersionAfterChange()
    {
        $this->cli->setVersion('v1.0.2');
        $this->assertEquals('v1.0.2', $this->cli->getVersion());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Argument command name.
     *
     * @throws \ErrorException
     */
    public function testCommandEmpty()
    {
        $this->cli->getCommand();
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing Argument Option name.
     *
     * @throws \ErrorException
     */
    public function testOptionEmpty()
    {
        $this->cli->getOptions();
    }

    /**
     * @dataProvider testAddCommandData
     *
     * @param $name
     * @param $description
     * @param $definition
     */
    public function testAddCommand($name, $description, $definition)
    {
        $this->cli->addCommand($name, $description, $definition);

        $this->assertEquals($name, $this->cli->commands[$name]->getName());
        $this->assertEquals($description, $this->cli->commands[$name]->getDescription());
        $this->assertEquals($definition, $this->cli->commands[$name]->getDefinition());
    }

    public function testAddCommandData()
    {
        return array(
            array('help', 'Outputs "HELP!!"', function(){ $this->output = "HELP!!"; }),
            array('test', 'Outputs "HELP!!"', get_class($this)."::testCommandClosure")
        );
    }

    public function testCommandClosure()
    {
        $this->output = "HELP!!";
    }

    /**
     * @dataProvider testSetOptionsData
     *
     * @param $name
     * @param $shortName
     * @param $description
     * @param $definition
     */
    public function testCliSetOptions($name, $shortName, $description, $definition)
    {
        $this->cli->setOptions($name, $shortName, $description, $definition);

        $this->assertEquals($name, $this->cli->getOptions($name)->getName());
        $this->assertEquals($shortName, $this->cli->getOptions($name)->getShortName());
        $this->assertEquals($description, $this->cli->getOptions($name)->getDescription());
        $this->assertEquals($definition, $this->cli->getOptions($name)->getDefinition());
    }

    public function testSetOptionsData()
    {
        return array(
            array('verbose', 'V', "increase verbosity", function () {
                $this::$verbose = true;
            })

        );
    }
}
