<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Scripts;

use Core\Helper\helper;

class corecmd
{
    private static $IOStream;
    private static $pdoDrivers = [
        'cubrid',
        'mssql',
        'firebird',
        'ibm',
        'informix',
        'mysql',
        'sqlsrv',
        'oracle',
        'oci',
        'odbc',
        'pgsql',
        'sqlite',
        '4D'
    ];

    public function __construct($args, $count)
    {
        unset($args[0]);
        $shortopts = "dh";
        $longopts = ["dev", "help"];
        $options = getopt($shortopts, $longopts);

        $this::$IOStream = new IOStream();

        if (sizeof($args) === 0 || (isset($options['h']) || isset($options['help']))) {

            $this->showHelp();

        } elseif ($args[1] === 'install') {
            if (isset($args[2]) && $args[2] === '--dev') {
                $this->install(true);
            } else {
                $this->install();
            }
        }
    }

    private function showHelp()
    {
        $usage = "Console:cyan [--global-options]:white command:cyan [options]:white [--command-options]:white";
        $options = [
            'install' => [
                'info' => "To install this Framework",
                'ex' => "console:cyan install:cyan [--dev]:white",
                'args' => "--dev",
                'reqArgs' => false,
            ],
            'addpage' => [
                'info' => "To add page to App [or] Project [or] site",
                'ex' => "console:cyan addpage:cyan [pagename]:white",
                'args' => ["route", "pageName", "pageTitle", "argReq", "argDefault", "controller"],
                'reqArgs' => true
            ]

        ];

        $this::$IOStream->writeln("Usage", 'green', null, "%s:" . PHP_EOL);
        $this::$IOStream->writeColoredLn($usage);
        $this::$IOStream->writeln('');
        $this::$IOStream->writeln("Commands", 'green', null, "%s:" . PHP_EOL);
        foreach ($options as $key => $val) {
            $this::$IOStream->writeln($key, 'cyan', null, "%20s:" . PHP_EOL);
            $this::$IOStream->writeln($val['info'], 'white', null, "\t%-1s" . PHP_EOL);
            $this::$IOStream->writeColoredLn($val['ex'], "\t%-1s" . PHP_EOL);
            $this::$IOStream->writeln('');
        }
    }

    public static function install($dev = false)
    {
        $devTxt = $dev ? 'dev' : 'normal';

        self::$IOStream->writeln("Installing Core in " . $devTxt . " mode ...", 'green');
        self::createAlias();
        self::createConf();

    }

    private function symResources(){
        
    }

    private function createAlias()
    {
        $aliases = '
            shopt -s expand_aliases
            alias corecon=' . __DIR__ . DS . "Console" . '
        ';
        exec($aliases);
    }

    private function createConf()
    {
        $confSource = _pROOT . "src" . DS . "Core" . DS . "bin" . DS . "config.pak";
        $confDest = _pROOT . "config";
        $confFile = $confDest . DS . "global.conf.php";

        if (!is_readable($confFile)) {
            $accumilate['pdoDriver'] = self::$IOStream->askAndValidata(
                "Enter PDO Driver to use : ",
                function ($input) {
                    if (in_array($input, self::$pdoDrivers)) {
                        return true;
                    } else {
                        return false;
                    }
                },
                "of type " . helper::serialize(self::$pdoDrivers),
                'mysql'
            );

            $accumilate['host'] = self::$IOStream->ask('Enter host ip', '127.0.0.1');
            $accumilate['db'] = self::$IOStream->ask('Enter database name', 'coredb');
            $accumilate['user'] = self::$IOStream->ask('Enter database user', 'root');
            $accumilate['pass'] = self::$IOStream->ask('Enter database password', null);
            self::$IOStream->writeln("Creating conf file...");

            mkdir($confDest, 0755, true);
            helper::copyr($confSource, $confDest);
            helper::chmodDir($confDest, 0644);

            $conf = require_once $confFile;

            foreach ($conf as $key => $val) {
                $conf[$key] = $accumilate[$key];
            }

            $check = file_put_contents($confFile, '<?php return ' . var_export($conf, true) . ";\n");

            if ($check) {
                self::$IOStream->writeln("Conf file Created Successfully");
            } else {
                self::$IOStream->showErr("Error writing configuration file - " . $confFile);
            }
        } else {
            self::$IOStream->writeln("Conf file exists! Continuing setup..");
        }

    }


}