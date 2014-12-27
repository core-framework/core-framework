<?php
/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Core\Scripts;

use Core\CacheSystem\Cacheable;
use Core\CacheSystem\Cache;
use Core\Config\Config;
use Core\Helper\Helper;

/**
 * Class that runs the console commands
 *
 * @package Core\Scripts
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class corecmd implements Cacheable
{
    /**
     * @var string Contains the current defined application name
     */
    public static $appName;
    /**
     * @var string The Domain Name of the Web App.
     */
    public static $domainName;
    /**
     * @var string Path to application directory
     */
    public static $appDir;
    /**
     * @var bool Defines if running in development mode
     */
    public static $dev = false;
    /**
     * @var IOStream Contains the IOStream object
     */
    private static $IOStream;
    /**
     * @var array Contains an array of pdo drivers
     */
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
    /**
     * @var string httpd.conf file path
     */
    private static $httpdConfPath;
    /**
     * @var string Path to the vhost conf file
     */
    private static $vhostConfPath;
    /**
     * @var string Apache user
     */
    private static $apacheUser;
    /**
     * @var string Apache user group
     */
    private static $apacheUserGroup;
    /**
     * @var cache Contains the cache object
     */
    private static $cache;
    /**
     * @var Config
     */
    private static $config;

    /**
     * corecmd Constructor
     *
     * @param $args
     * @param $count
     */
    public function __construct($args, $count)
    {
        error_reporting(E_ERROR);
        unset($args[0]);
        $shortopts = "dh";
        $longopts = ["dev", "help"];
        $options = getopt($shortopts, $longopts);

        $this::$IOStream = new IOStream();
        $this::$cache = new Cache();
        $this::$config = new Config();


        if (sizeof($args) === 0 || (isset($options['h']) || isset($options['help']))) {

            $this->showHelp();

        } elseif ($args[1] === 'install') {

            if (isset($args[2]) && $args[2] === '--dev') {
                $this->install(true);
            } else {
                $this->install();
            }

        } elseif ($args[1] === 'addHostFileEntry') {
            self::addHosts($args[2], $args[3]);

        } elseif ($args[1] === 'removeVhost') {

            if ($args[3] === '--vhost') {
                self::removeVhost($args[2], true, false);
            } elseif ($args[3] === '--hosts') {
                self::removeVhost($args[2], false, true);
            } else {
                self::removeVhost($args[2]);
            }

        } elseif ($args[1] === 'addConfigVars') {

            self::addConfigVars($args[2], $args[3]);

        } elseif (method_exists($this, $args[1])) {
            $size = sizeof($args);
            $method = $args[1];
            if ($size > 2) {
                unset($args[1]);
                $sArgs = Helper::serialize($args);
                self::$method($sArgs);
            } else {
                self::$method($args[2]);
            }
        } elseif (isset($args[1]) && method_exists($this, $args[1])) {
            self::$args[1]();
        }
    }

    /**
     * Prints the help section
     */
    private function showHelp()
    {
        $this->printSign();
        $usage = "Console:cyan ( ||:white corecon:cyan ) [--global-options]:white command:cyan [options]:white [--command-options]:white";
        $note = "corecon will be available if during app setup the alias was created successfully";
        $options = [
            'install' => [
                'info' => "To install this Framework",
                'ex' => "Console:cyan install:cyan [--dev]:white",
                'args' => "--dev",
                'reqArgs' => false,
            ],
            'setupApp' => [
                'info' => "To setup up app identified by appName (where appName is provided by the user) i.e. create htaccess, create index , create symlinks to front-end resources",
                'ex' => "Console:cyan setupApp:cyan [appName]:white",
                'args' => "appName",
                'reqArgs' => true,
            ],
            'symResources' => [
                'info' => "Creates symlinks of front-end bower components to app directory under specific style or scripts or fonts folders. Ex: The front-end component jquery will be available in path appName/scripts/jquery (urlpath: yourdomain.com/scripts/jquery/jquery.min.js)",
                'ex' => "Console:cyan symResources:cyan [appName]:white",
                'args' => "appName",
                'reqArgs' => true,
            ],
            'addHosts' => [
                'info' => "Adds an entry to the hosts file with provided parameters(Domain & ip)",
                'ex' => "sudo:yellow Console:cyan addHosts:cyan [ip]:white [domain]:white",
                'args' => ["domain", "ip"],
                'reqArgs' => true,
            ],
            'addVhost' => [
                'info' => "Adds a virtual host. The vhost entry is added to the httpd-vhosts.conf file if found else its added to the httpd.conf file",
                'ex' => "sudo:yellow Console:cyan addVhost:cyan [ip]:white [domain]:white",
                'args' => ["ip", "domain"],
                'reqArgs' => true,
            ],
            'setupHost' => [
                'info' => "Sets up local host for the app. Its a cumulative of addHosts and addVhost",
                'ex' => "sudo:yellow Console:cyan setupHost:cyan [ip]:white [domain]:white",
                'args' => ["ip", "domain"],
                'reqArgs' => true,
            ]
            //TODO: `addpage` feature to be added in next iterations
            //'addpage' => [
            //  'info' => "To add page to App [or] Project [or] site",
            //  'ex' => "console:cyan addpage:cyan [pagename]:white",
            //  'args' => ["route", "pageName", "pageTitle", "argReq", "argDefault", "controller"],
            //  'reqArgs' => true
            //]
        ];

        $this::$IOStream->writeln("Usage", 'green', null, "%s:" . PHP_EOL);
        $this::$IOStream->writeColoredLn($usage);
        $this::$IOStream->writeln($note, "green");
        $this::$IOStream->writeln('');
        $this::$IOStream->writeln("Commands", 'green', null, "%s:" . PHP_EOL);
        foreach ($options as $key => $val) {
            $this::$IOStream->writeln($key, 'cyan', null, "%20s:" . PHP_EOL);
            $this::$IOStream->writeln($val['info'], 'white', null, "\t%-1s" . PHP_EOL);
            $this::$IOStream->writeColoredLn($val['ex'], "\t%-1s" . PHP_EOL);
            $this::$IOStream->writeln('');
        }
    }

    /**
     * Prints core framework signature
     */
    private function printSign()
    {
        self::$IOStream->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );
        self::$IOStream->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );
        self::$IOStream->writeln(
            '                                                                                                                                                        '
        );
        self::$IOStream->writeln(
            " ______     ______     ______     ______        ______   ______     ______     __    __     ______     __     __     ______     ______     __  __    ",
            'yellow'
        );
        self::$IOStream->writeln(
            "/\\  ___\\   /\\  __ \\   /\\  == \\   /\\  ___\\      /\\  ___\\ /\\  == \\   /\\  __ \\   /\\ \"-./  \\   /\\  ___\\   /\\ \\  _ \\ \\   /\\  __ \\   /\\  == \\   /\\ \\/ /    ",
            'yellow'
        );
        self::$IOStream->writeln(
            "\\ \\ \\____  \\ \\ \\/\\ \\  \\ \\  __<   \\ \\  __\\      \\ \\  __\\ \\ \\  __<   \\ \\  __ \\  \\ \\ \\-./\\ \\  \\ \\  __\\   \\ \\ \\/ \".\\ \\  \\ \\ \\/\\ \\  \\ \\  __<   \\ \\  _\"-.  ",
            'yellow'
        );
        self::$IOStream->writeln(
            " \\ \\_____\\  \\ \\_____\\  \\ \\_\\ \\_\\  \\ \\_____\\     \\ \\_\\    \\ \\_\\ \\_\\  \\ \\_\\ \\_\\  \\ \\_\\ \\ \\_\\  \\ \\_____\\  \\ \\__/\".~\\_\\  \\ \\_____\\  \\ \\_\\ \\_\\  \\ \\_\\ \\_\\ ",
            'yellow'
        );
        self::$IOStream->writeln(
            "  \\/_____/   \\/_____/   \\/_/ /_/   \\/_____/      \\/_/     \\/_/ /_/   \\/_/\\/_/   \\/_/  \\/_/   \\/_____/   \\/_/   \\/_/   \\/_____/   \\/_/ /_/   \\/_/\\/_/ ",
            'yellow'
        );
        echo "                                                                                                                                                     ";
        self::$IOStream->writeln(
            '                                                                                                                                                        '
        );
        self::$IOStream->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );
        self::$IOStream->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );

        self::$IOStream->writeln('Core Framework Console (c) Shalom Sam <shalom.s@coreframework.in>', 'green');
        self::$IOStream->writeln('Version : 1.0.0', 'green');
    }

    /**
     * Runs commands to install the coreFramework for use by your web app
     *
     * @param bool $dev
     */
    public static function install($dev = false)
    {
        self::printSign();
        self::$dev = $dev;
        $devTxt = $dev ? 'dev' : 'normal';
        self::$IOStream->writeln("Installing Core in " . $devTxt . " mode ...", 'green');
        self::createAlias();
        self::symResources('demoapp');
        self::setupApp('demoapp');
        $resp = self::$IOStream->ask("Do you want to setup your app now", 'yes', ['yes', 'no']);
        if ($resp === 'yes') {
            $appName = self::$IOStream->ask("Enter your App name");
            if(empty($appName)) {
                self::$IOStream->showErr("App name cannot be empty!");
                exit;
            }
            self::setupApp($appName);
        }

        self::createCacheFolder();
        self::createSmartyCache();
        self::$IOStream->writeln("Application setup successfully!", 'green');
    }

    /**
     * creates an alias for access to the Console cli script/commands
     */
    private function createAlias()
    {
        $console = __DIR__ . DS . "Console";
        $aliases = "alias corecon=$console";
        exec($aliases);
    }

    /**
     * Creates symlinks for front-end resources
     *
     * @param $appName
     */
    public static function symResources($appName)
    {
        self::$appName = $appName;
        if (empty($appName)) {
            $callback = (function ($input) {
                $appPath = _ROOT . DS . $input;
                if (is_dir($appPath)) {
                    return true;
                } else {
                    return false;
                }
            });
            self::$appName = $appName = self::$IOStream->askAndValidate(
                "Please enter the appName of the application to create symlinks for ",
                $callback,
                "Must be an existing appName"
            );
        }
        self::$IOStream->writeln("Attempting to sym links resources from Bower -> $appName", "green");
        $appDir = _ROOT . DS . $appName . DS;
        $bowerDir = _ROOT . DS . "bower_components" . DS;
        if (!is_dir($appDir . "images" . DS)) {
            mkdir($appDir . "images" . DS, 0755);
        }
        if (!is_dir($appDir . "scripts" . DS)) {
            mkdir($appDir . "scripts" . DS, 0755);
        }
        if (!is_dir($appDir . "styles" . DS)) {
            mkdir($appDir . "styles" . DS, 0755);
        }
        if (!is_dir($appDir . "styles" . DS . "fonts")) {
            mkdir($appDir . "styles" . DS . "fonts" . DS, 0755);
        }

        $dir = new \DirectoryIterator($bowerDir);
        foreach ($dir as $resource) {
            $packName = $resource->getFilename();
            if ($resource->isDir() && !$resource->isDot()) {

                $appStyles = $appDir . "styles" . DS . $packName;
                $appScripts = $appDir . "scripts" . DS . $packName;

                if (is_dir($appScripts)) {
                    rmdir($appScripts);
                } elseif (is_file($appScripts) || is_readable($appScripts)) {
                    unlink($appScripts);
                }
                if (is_dir($appStyles)) {
                    rmdir($appStyles);
                } elseif (is_file($appStyles) || is_readable($appStyles)) {
                    unlink($appStyles);
                }

                if (is_dir($bowerDir . $packName . DS . "dist") &&
                    is_dir($bowerDir . $packName . DS . "dist" . DS . "css") &&
                    is_dir($bowerDir . $packName . DS . "dist" . DS . "js") &&
                    is_dir($bowerDir . $packName . DS . "dist" . DS . "fonts")
                ) {

                    $return = symlink($bowerDir . $packName . DS . "dist" . DS . "js" . DS, $appScripts);
                    $return2 = symlink($bowerDir . $packName . DS . "dist" . DS . "css" . DS, $appStyles);

                    if ($return === true) {
                        self::$IOStream->writeln("Symlink created for $appScripts ..", 'green');
                    } elseif ($return2 === true) {
                        self::$IOStream->writeln("Symlink created for $appStyles ..", 'green');
                    } elseif ($return === false) {
                        self::$IOStream->writeln("Unable to create Symlink for $appScripts ..", 'yellow');
                    } elseif ($return2 === false) {
                        self::$IOStream->writeln("Unable to create Symlink for $appStyles ..", 'yellow');
                    }

                    $fonts = new \DirectoryIterator($bowerDir . $packName . DS . "dist" . DS . "fonts" . DS);
                    foreach ($fonts as $font) {
                        if (!$font->isDir() && !$font->isDot()) {
                            $fontFilename = $font->getFilename();
                            $fontFile = $appDir . "styles" . DS . "fonts" . DS . $fontFilename;
                            $return = symlink(
                                $bowerDir . $packName . DS . "dist" . DS . "font" . DS . $fontFilename,
                                $fontFile
                            );

                            if ($return === true) {
                                self::$IOStream->writeln("Symlink created for $fontFile ..", 'green');
                            } else {
                                self::$IOStream->writeln("Unable to create Symlink for $fontFile ..", 'yellow');
                            }
                        }
                    }

                } elseif (is_dir($bowerDir . $packName . DS . "dist") && !(is_dir(
                            $bowerDir . $packName . DS . "dist" . DS . "css"
                        ) && !is_dir($bowerDir . $packName . DS . "dist" . DS . "js"))
                ) {
                    $distDir = $bowerDir . $packName . DS . "dist" . DS;
                    $file = new \DirectoryIterator($distDir);
                    foreach ($file as $res) {
                        if (!$res->isDot() && !$res->isDir()) {
                            $fileExt = $res->getFileInfo()->getExtension();
                            $return = false;
                            $path = '';
                            if ($fileExt === 'js') {
                                $return = symlink($bowerDir . $packName . DS . "dist" . DS, $appScripts);
                                $path = 'appScripts';
                            } elseif ($fileExt === 'css') {
                                $return = symlink($bowerDir . $packName . DS . "dist" . DS, $appStyles);
                                $path = 'appStyles';
                            }

                            if ($return === true) {
                                self::$IOStream->writeln("Symlink created for " . $$path . "..", 'green');
                            } else {
                                self::$IOStream->writeln("Unable to create Symlink for " . $$path . " ..", 'yellow');
                            }

                        }
                    }
                }
            }
        }

    }

    /**
     * Creates Conf files, index file, htaccess, and sumlinks to front-end resources
     *
     * @throws \Exception
     */
    public static function setupApp($appName = 'demoapp')
    {

        if (empty($appName) && $appName !== 'demoapp') {

            $callback = (function ($input) {
                if (preg_match(
                    '/^[a-zA-Z\.]{4,}$/',
                    $input
                )) {
                    return true;
                } else {
                    return false;
                }
            });
            self::$domainName = $domainName = self::$IOStream->askAndvalidate(
                "Enter the Domain name of your web application (sub domains are allowed)",
                $callback,
                "Input must be a valid Domain name (sub domains are allowed)"
            );

            $appName = str_replace('.', '-', $domainName);
        }


        self::$appName = $appName;
        self::$appDir = $appDir = _ROOT . DS . $appName;
        if (!is_readable($appDir)) {
            mkdir($appDir, 0755);
            mkdir($appDir . DS . "Templates", 0755);
            copy(
                _ROOT . DS . "demoapp" . DS . "Templates" . DS . "root.tpl",
                $appDir . DS . "Templates" . DS . "root.tpl"
            );
            chmod($appDir . DS . "Templates" . DS . "root.tpl", 0755);
            mkdir($appDir . DS . "Templates" . DS . "common", 0755);
            Helper::copyr(
                _ROOT . DS . "demoapp" . DS . "Templates" . DS . "common",
                $appDir . DS . "Templates" . DS . "common"
            );
            mkdir($appDir . DS . "Templates" . DS . "errors", 0755);
            Helper::copyr(
                _ROOT . DS . "demoapp" . DS . "Templates" . DS . "errors",
                $appDir . DS . "Templates" . DS . "errors"
            );
            mkdir($appDir . DS . "Templates" . DS . "root", 0755);
            Helper::copyr(
                _ROOT . DS . "demoapp" . DS . "Templates" . DS . "root",
                $appDir . DS . "Templates" . DS . "root"
            );

            self::createConf($appDir);
            self::createIndex($appName);
            self::createHtaccess($appName);
            self::symResources($appName);

        } else {
            self::$IOStream->writeln("App Directory by $appName already exists", "yellow");
            self::$IOStream->writeln("Recreating app's index.php file...", "yellow");
            self::createIndex($appName);
            self::$IOStream->writeln("Recreating app's .htaccess file...", "yellow");
            self::createHtaccess($appName);
            self::$IOStream->writeln("Recreating app's conf files...", "yellow");
            self::createConf($appDir);
        }

        self::$IOStream->writeln("You can setup virtual hosts using the following command -", 'yellow');
        $consolePath = _ROOT . DS . "src" . DS . "Core" . DS . "Scripts" . DS . "Console";
        $name = empty(self::$appName) ? '{appDirName}' : self::$appName;
        self::$IOStream->writeColoredLn(
            "sudo:yellow $consolePath:cyan setupHost:cyan $name:white"
        );
    }

    /**
     * Create Conf files
     *
     * @param $appDir
     * @throws \Exception
     */
    public static function createConf($appDir)
    {
        $confSource = __DIR__ . DS . "pak" . DS . "config.pak";
        $confDest = _ROOT . DS . $appDir . DS . "config";
        $confFile = $confDest . DS . "global.conf.php";
        $routesConf = $confDest . DS . "routes.conf.php";

        if (!is_readable($confFile) || !is_readable($routesConf)) {
            $accumilate['pdoDriver'] = self::$IOStream->askAndvalidate(
                "Enter PDO Driver to use : ",
                function ($input) {
                    if (in_array($input, self::$pdoDrivers)) {
                        return true;
                    } else {
                        return false;
                    }
                },
                "of type " . Helper::serialize(self::$pdoDrivers),
                'mysql'
            );

            $accumilate['host'] = self::$IOStream->ask('Enter host ip', '127.0.0.1');
            $accumilate['db'] = self::$IOStream->ask('Enter database name', 'coredb');
            $accumilate['user'] = self::$IOStream->ask('Enter database user', 'root');
            $accumilate['pass'] = self::$IOStream->ask('Enter database password', null);
            self::$IOStream->writeln("Creating conf file...");

            if (!is_dir($confDest)) {
                mkdir($confDest, 0755, true);
            }

            Helper::copyr($confSource, $confDest);
            Helper::chmodDirFiles($confDest, 0644);

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
            self::$IOStream->writeln("Conf files exists! Continuing setup..");
        }

    }

    /**
     * Creates app Index file
     *
     * @param $appName
     * @return bool
     */
    private function createIndex($appName)
    {
        if (empty($appName)) {
            self::$IOStream->showErr("appName cannot be empty!");
            exit;
        }
        $index = __DIR__ . DS . "pak" . DS . "index.pak";
        $appDir = _ROOT . DS . $appName . DS;
        $newIndex = $appDir . "index.php";
        $contents = file_get_contents($index);
        $newContents = preg_replace('/\{appName\}/', $appName, $contents);
        if (is_readable($newIndex)) {
            unlink($newIndex);
        }
        touch($newIndex);
        $return = file_put_contents($newIndex, $newContents);
        if ($return !== false) {
            self::$IOStream->writeln("Index file created successfully!", 'green');
            return true;
        } else {
            self::$IOStream->showErr("Failed to create .htaccess file!!");
            return false;
        }
    }

    /**
     * Creates the .htaccess file for the app
     *
     * @param $appName
     * @return bool
     */
    private function createHtaccess($appName)
    {
        if (empty($appName)) {
            self::$IOStream->showErr("appName cannot be empty!");
            exit;
        }
        $htaccess = __DIR__ . DS . "pak" . DS . ".htaccess.pak";
        $appDir = _ROOT . DS . $appName . DS;
        $newHtaccess = $appDir . ".htaccess";
        $htaccessContents = file_get_contents($htaccess);
        if (is_readable($newHtaccess)) {
            unlink($newHtaccess);
        }
        touch($newHtaccess);
        $return = file_put_contents($newHtaccess, $htaccessContents);

        if ($return !== false) {
            self::$IOStream->writeln(".htaccess file created successfully!", 'green');
            return true;
        } else {
            self::$IOStream->showErr("Failed to create .htaccess file!!");
            return false;
        }
    }

    /**
     * Create cache folder, if exist changes the owner of the folder to right apache user
     */
    private function createCacheFolder()
    {
        $httpdConfPath = self::findHttpdConf();

        if (gettype($httpdConfPath) === 'string') {

            exec('egrep "^User|^Group|^SuexecUserGroup" ' . $httpdConfPath, $output);

            $tmp = explode(" ", $output[0]);
            $apacheUser = $tmp[1];
            self::$apacheUser = $apacheUser;

            $tmp = explode(" ", $output[1]);
            $apacheGroup = $tmp[1];
            self::$apacheUserGroup = $apacheGroup;

            if ($apacheUser === '${APACHE_RUN_USER}' && $apacheGroup === '${APACHE_RUN_GROUP}') {
                $httpdPathArr = explode(DS, $httpdConfPath);
                array_pop($httpdPathArr);
                $httpdDir = implode(DS, $httpdPathArr);
                $envvars = $httpdDir . DS . "envvars";
                if (is_readable($envvars)) {
                    exec('egrep "^export APACHE_RUN_USER|export APACHE_RUN_GROUP" ' . $envvars, $output);
			
		    foreach($output as $line) {
                        if(strpos($line, 'export APACHE_RUN_USE') > -1) {
                            $tmp1 = explode("=", $line);
                            self::$apacheUser = $apacheUser = $tmp1[1];

                        } elseif (strpos($line, 'export APACHE_RUN_GROUP') > -1) {
                            $tmp2 = explode("=", $line);
                            self::$apacheUserGroup = $apacheGroup = $tmp2[1];
                        }
                    }

                } 

		if (empty(self::$apacheUser) && empty(self::$apacheUserGroup)) {
                    self::$apacheUser = self::$IOStream->ask("Please enter the Apache User name");
                    self::$apacheUserGroup = self::$IOStream->ask(
                        "Please enter the Apache User Group",
                        self::$apacheUser
                    );
                }
            }

            $cacheDir = _ROOT . DS . "src" . DS . "Core" . DS . "cache" . DS;

            self::$IOStream->writeln("creating cache folder", 'green');
            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0777);
                chown($cacheDir, $apacheUser . ":" . $apacheGroup);
            } else {
                self::$IOStream->writeln("Setting up cache folder", 'green');
                chown($cacheDir, $apacheUser . ":" . $apacheGroup);
                chmod($cacheDir, 0777);
            }
        }
    }

    /**
     * Finds the coorect file to add virtual host to.
     *
     * @return bool|string
     */
    private function findHttpdConf()
    {

        if (!empty(self::$httpdConfPath)) {
            return self::$httpdConfPath;
        }

        exec('apachectl -V', $respArr);
        foreach ($respArr as $item) {
            if (strpos($item, "SERVER_CONFIG_FILE") !== false) {
                $arr = explode("=", $item);
                $httpdConfPath = trim($arr[1], '"');
            }
        }

        if (empty($httpdConfPath) || !is_dir($httpdConfPath)) {
            self::$IOStream->writeln("Cannot find httpd.conf!", "yellow");
            $rep = self::$IOStream->ask("Please enter full path to httpd.conf ");
            if (is_file($rep)) {
                self::$httpdConfPath = $rep;
                return $rep;
            } else {
                self::$IOStream->showErr("Valid File not provided!");
                return false;
            }
        } else {
            self::$httpdConfPath = $httpdConfPath;
            return $httpdConfPath;
        }
    }

    /**
     * Creates smarty cache directories
     */
    private function createSmartyCache()
    {
        self::$IOStream->writeln('Creating smarty cache..', 'green');
        $smartyCacheDir = _ROOT . DS . "src" . DS . "Core" . DS . "smarty_cache";
        $smarty_sub_cache = $smartyCacheDir . DS . "cache";
        $smarty_sub_config = $smartyCacheDir . DS . "config";
        $smarty_sub_template = $smartyCacheDir . DS . "templates_c";
        if (!is_dir($smartyCacheDir)) {
            mkdir($smartyCacheDir, 0777);
        } else {
	    chmod($smartyCacheDir, 0777);
	}
        if (!is_dir($smarty_sub_cache)) {
            mkdir($smarty_sub_cache, 0777);
        } else {
	    chmod($smarty_sub_cache, 0777);
	}
        if (!is_dir($smarty_sub_config)) {
            mkdir($smarty_sub_config, 0777);
        } else {
	    chmod($smarty_sub_config, 0777);
	}
        if (!is_dir($smarty_sub_template)) {
            mkdir($smarty_sub_template, 0777);
        } else {
	    chmod($smarty_sub_template, 0777);
	}
    }

    /**
     * Adds an entry to hosts files for the app
     *
     * @param $ip
     * @param $domain
     */
    public static function addHosts($domain, $ip)
    {
        if (empty($domain) || empty($ip)) {
            self::$IOStream->showErr("Domain and ip must be provided");
            exit;
        }
        $hostFile = self::getHostsFile();
        $hostTpl = "{ip}\tdev.{userDomain}\n";
        $hostNewContent = str_replace('{userDomain}', $domain, $hostTpl);
        $hostNewContent = str_replace('{ip}', $ip, $hostNewContent);
        $hostContent = file_get_contents($hostFile);
        $h = fopen($hostFile, 'a');
        $return = fwrite($h, ($hostContent != "" ? "\n" . $hostNewContent : $hostNewContent));
        fclose($h);
        if ($return !== false) {
            self::$IOStream->writeln("Hosts file successfully updated!", 'green');
        } else {
            self::$IOStream->writeln("Warning: could not update hosts file.", 'yellow');
        }
    }

    /**
     * Gets the host file location.
     *
     * @return string
     */
    private function getHostsFile()
    {
        $hostWin = "C:\\Windows\\System32\\drivers\\etc\\hosts";
        $hostOthers = "/etc/hosts";

        if (is_file($hostWin)) {
            $hostFile = $hostWin;
        } elseif (is_file($hostOthers)) {
            $hostFile = $hostOthers;
        } else {
            $callback = (function ($input) {
                if (is_file($input) && is_resource($input)) {
                    return true;
                } else {
                    return false;
                }
            });
            $resp = self::$IOStream->askAndvalidate(
                "Cannot locate hosts file. Please enter fullpath ",
                $callback,
                "Must be a valid file"
            );
            $hostFile = $resp;
        }
        return $hostFile;
    }

    /**
     * Removes (previously added) virtual host entry from vhost.conf/httpd.conf file
     *
     * @param $appName
     * @param bool $removeVhost
     * @param bool $removeHostEntry
     * @return bool
     */
    public static function removeVhost($appName, $removeVhost = true, $removeHostEntry = true)
    {
        if (empty($appName)) {
            self::$IOStream->showErr("appName cannot be empty!");
            exit;
        }
        $appName = strtolower($appName);
        $hostFile = self::getHostsFile();
        $httpdConfFile = self::findHttpdConf();
        if ($removeVhost === true) {
            $fileArr = file($httpdConfFile);
            $start = 0;
            $end = 0;
            $startLine = "##-- Entry start for $appName --";
            $endLine = "##-- Entry end for $appName --";
            foreach ($fileArr as $i => $line) {

                if (strpos($line, $startLine) !== false) {
                    $start = $i;
                }

                if (strpos($line, $endLine) !== false) {
                    $end = $i;
                }
            }

            if ($end !== 0) {
                for ($i = $start; $i <= $end; $i++) {
                    unset($fileArr[$i]);
                }

                $newContents = implode("", $fileArr);
                $h = fopen($httpdConfFile, 'w');
                fwrite($h, $newContents);
                fclose($h);
                self::$IOStream->writeln(
                    "Entries for $appName have been removed from $httpdConfFile successfully",
                    'green'
                );
            } else {
                self::$IOStream->writeln("Could not find vhost entry for $appName in $httpdConfFile", 'yellow');
            }
        }
        if ($removeHostEntry === true) {
            $fa = file($hostFile);
            $f = false;
            $domain = "dev." . $appName;
            foreach ($fa as $i => $line) {
                if (strpos($line, $domain) !== false) {
                    unset($fa[$i]);
                    $f = true;
                }
            }
            if ($f === true) {
                $newContents = implode("", $fa);
                $h = fopen($hostFile, 'w');
                fwrite($h, $newContents);
                fclose($h);
                self::$IOStream->writeln("Entries for $appName have been removed from $hostFile successfully", 'green');
            } else {
                self::$IOStream->writeln("Could not fine vhost entry for $appName in $hostFile", 'yellow');
            }

        }

    }

    public static function update($dev = false)
    {
        self::printSign();
        self::$dev = $dev;
        $devTxt = $dev ? 'dev' : 'normal';
        self::$IOStream->writeln("Installing Core in " . $devTxt . " mode ...", 'green');
        self::createAlias();
        $resp = self::$IOStream->ask("Do you want to setup your app now", 'yes', ['yes', 'no']);
        if ($resp === 'yes') {
            $appName = self::$IOStream->ask("Enter your App name");
            if(empty($appName)) {
                self::$IOStream->showErr("App name cannot be empty!");
                exit;
            }
            self::setupApp($appName);
        }

        self::createCacheFolder();
        self::createSmartyCache();
        self::$IOStream->writeln("Application setup successfully!", 'green');
    }

    /**
     * setup virtual host for app (includes updating hosts and httpd.conf || httpd-vhosts.conf file )
     *
     * @param null $domain
     * @param string $ip
     */
    public static function setupHost($domain = null, $ip = '127.0.0.1')
    {
        $docRoot = _ROOT . DS . $domain . DS;
        if (empty($domain)) {
            $domain = self::$appName;
        }
        $resp = self::$IOStream->ask(
            "Setting up virtual host for Domain dev.$domain bound to document path $docRoot and IP $ip . Would you like to edit ? ",
            "no",
            ['yes', 'no']
        );
        if ($resp === 'yes') {
            $callback = (function ($input) {
                if (is_string($input)) {
                    return true;
                } else {
                    return false;
                }
            });
            $callback2 = (function ($input) {
                if (preg_match("(^[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}\\.[0-9]{1,3}$)", $input)) {
                    return true;
                } else {
                    return false;
                }
            });
            $resp = self::$IOStream->askAndvalidate(
                "Please enter the domain of your choice ",
                $callback,
                "Must be a String",
                "dev.$domain"
            );
            $resp2 = self::$IOStream->askAndvalidate(
                "Please enter the IP of your choice ",
                $callback2,
                "Must be a valid IP",
                '127.0.0.1'
            );

            if (is_string($resp)) {
                $domain = $resp;
            }
            if (is_string($resp2)) {
                $ip = $resp2;
            }
        }

        //Adding vhost
        self::addVhost($domain, $ip);

        //Adding hosts entry
        self::addHosts($domain, $ip);

    }

    /**
     * Add virtual host entery to httpd-vhosts.conf if found else httpd.conf
     *
     * @param $domain
     * @param $ip
     */
    public static function addVhost($domain, $ip)
    {
        $vhostTpl = require_once "vhost.tpl.php";
        $docRoot = _ROOT . DS . $domain;
        $logsPath = _ROOT . DS . 'logs' . DS;
        $errLog = $logsPath . "error_log";
        $accessLog = $logsPath . "access_log";
        if (!is_dir($logsPath)) {
            mkdir($logsPath);
            touch($errLog);
            touch($accessLog);
        }
        $newContent = str_replace('{userDomain}', strtolower($domain), $vhostTpl);
        if (empty($ip) || $ip === '127.0.0.1' || $ip === 'localhost') {
            $newContent = str_replace('{ip}', '*', $newContent);
        } else {
            $newContent = str_replace('{ip}', $ip, $newContent);
        }
        $newContent = str_replace('{documentRoot}', $docRoot, $newContent);
        $newContent = str_replace('{errorLog}', $errLog, $newContent);
        $newContent = str_replace('{accessLog}', $accessLog, $newContent);
        $httpdConfPath = self::findHttpdConf();
        $vhostConfFile = self::getVhostPath($httpdConfPath);
        $oldContent = file_get_contents($vhostConfFile);
        $handle = fopen($vhostConfFile, 'a');
        $return = fwrite($handle, ($oldContent != "" ? "\n" . $newContent : $newContent));
        fclose($handle);
        if ($return !== false) {
            self::$IOStream->writeln("Vhost entry added successfully.", 'green');
        } else {
            self::$IOStream->writeln("Warning: failed to write vhost/httpd.conf file", 'yellow');
        }
    }

    /**
     * Gets the httpd-vhosts.conf file path
     *
     * @param null $httpdConf
     * @return bool|string
     * @throws \ErrorException
     */
    private function getVhostPath($httpdConf = null)
    {
        if (!empty(self::$vhostConfPath)) {
            return self::$vhostConfPath;
        }

        if (empty($httpdConf)) {
            if (!empty($this->httpdConfPath)) {
                $httpdConf = $this->httpdConfPath;
            } else {
                $httpdConf = self::findHttpdConf();
                if (gettype($httpdConf) !== 'string') {
                    throw new \ErrorException("HttpdConf file not provided");
                }
            }
        }
        $arr = file($httpdConf);
        foreach ($arr as $line) {
            if (strpos($line, 'httpd-vhosts.conf') !== false) {
                $arr = explode(" ", $line);

                $vhostPath = trim($arr[1], "\n");
            }
        }
        if (!empty($vhostPath)) {
            self::$vhostConfPath = $vhostPath;
            return $vhostPath;
        } else {
            return false;
        }
    }

    /**
     * Add Config params to file
     *
     * @param $key
     * @param $val
     */
    public static function addConfigVars($key, $val)
    {
        self::$IOStream->writeln("Adding values - $key -> $val");
        $r = self::$config->store($key, $val);
        if ($r === true) {
            self::$IOStream->writeln("done!");
        } else {
            self::$IOStream->writeln("failed to add the values to file");
        }
    }

    /**
     * Clear all cache
     */
    public static function clearCache()
    {
        self::$cache->clearCache();
        self::$IOStream->writeln("Cache successfully cleared!", 'green');
    }

    /**
     * Sleep magic method
     *
     * @return array
     */
    public function __sleep()
    {
        return [
            'appName',
            'appDir',
            'dev',
            'pdoDrivers',
            'httpdConfPath',
            'vhostConfPath',
            'apacheUser',
            'apacheUserGroup'
        ];
    }

    /**
     * Wakeup custom method
     */
    public function __wakeup()
    {
        $this::$IOStream = new IOStream();
        $this::$cache = new cache();
    }

}
