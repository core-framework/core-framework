<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 11/01/15
 * Time: 10:44 AM
 */

namespace Core\Tests\CLI;

use Core\Console\CLI;
use Core\Console\IOStream;
use Core\DI\DI;

class CLITest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var $cli \Core\Console\CLI
     */
    public $cli;
    public $io;

    public function setUp()
    {
        $this->io = new IOStream();
        $this->cli = new CLI($this->io);
        parent::setUp();
    }

    public function tearDown()
    {
        DI::reset();
        parent::tearDown();
    }

    /**
     * @covers \Core\Console\CLI::__constructor
     */
    public function testCLIConstructor()
    {
        $cli = new CLI($this->io);
        $this->assertInstanceOf('\\Core\\Console\\CLI', $cli);

        $this->assertInstanceOf('\\Core\\Console\\IOStream', $cli->io);
    }

    /**
     * @covers \Core\Console\CLI::loadConf
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessageRegExp /Config must be an array! Given/
     */
    public function testCLILoadConfThrowsExceptionWhenNotArray()
    {
        $this->cli->loadConf('');
    }

    /**
     * @covers \Core\Console\CLI::loadConf
     */
    public function testIfComponentIsSetWhenProvided()
    {
        $conf = [
            '$components' => [
                'Cache' => \Core\CacheSystem\AppCache::class
            ]
        ];

        $testCLI = new CLI($this->io, $conf);

        $this->assertInstanceOf('\\Core\\CacheSystem\\AppCache', $testCLI->cache);
    }

    /**
     * @covers \Core\Console\CLI::loadConf
     */
    public function testIfThrowsErrorIfCacheComponentIsNotProvided()
    {
        $conf = [
            '$components' => []
        ];

        $testCLI = new CLI($this->io, $conf);

        $this->assertNull($testCLI->cache);
    }

    /**
     * @covers \Core\Console\CLI::loadConf
     */
    public function testIfCommandExistsWhenProvided()
    {
        $conf = [
            '$commands' => [
                0 => [
                    'name' => 'hello:world',
                    'shortName' => '',
                    'description' => 'Simple Hello World Command',
                    'definition' => '\\Core\\Console\\CLI::helloWorld',
                    'arguments' => [
                        'name' => 'name',
                        'isRequired' => false,
                        'description' => 'Your Name'
                    ]
                ]
            ]
        ];

        $testCLI = new CLI($this->io, $conf);
        $this->assertArrayHasKey('hello:world', $testCLI->commands);
        $this->assertInstanceOf('\\Core\\Console\\Command', $testCLI->commands['hello:world']);
        $this->assertInternalType('callable', $testCLI->commands['hello:world']->getDefinition());
    }

    /**
     * @covers \Core\Console\CLI::loadConf
     */
    public function testIfOptionExistsWhenProvided()
    {
        $conf = [
            '$options' => [
                0 => [
                    'name' => 'hello:world',
                    'shortName' => 'H',
                    'description' => 'Simple Hello World Command',
                    'definition' => '\\Core\\Console\\CLI::helloWorld'
                ]
            ]
        ];

        $testCLI = new CLI($this->io, $conf);
        $options = $testCLI->getOptions();
        $this->assertInternalType('array', $options);
        $this->assertArrayHasKey('hello:world', $options);
        $this->assertInstanceOf('\\Core\\Console\\Options', $options['hello:world']);
        $this->assertInternalType('callable', $options['hello:world']->getDefinition());
    }

    /**
     * @covers \Core\Console\CLI::setDefaults
     */
    public function testIfDefaultOptionsAreSet()
    {
        $testCLI = new CLI($this->io);
        $options = $testCLI->getOptions();
        $this->assertArrayHasKey('help', $options);

    }

}
