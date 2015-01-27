<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 29/12/14
 * Time: 9:36 AM
 */

namespace Core\Scripts;


use Core\CacheSystem\Cache;
use Core\DI\DI;
use Core\Helper\Helper;

class Core extends CLI
{
    private $environment = "production";

    private $appName;

    private $appDirPath;

    private $frontEndManager = "bower";

    private $bowerPath;

    private $supportedFEs = ['bower'];

    private $bowerCommonPackages = [
        'jquery' => 'latest',
        'angular' => '1.3.8',
        'bootstrap' => '',
        'es5-shim' => '4.0.5',
        'json3' => '3.3.2',
        'angular-ui-router' => 'latest',
        'angular-bootstrap' => 'latest',
        'modernizr' => 'latest',
        'font-awesome' => 'latest',
        'requirejs' => 'latest',
        'underscore' => 'latest',
        'angular-translate' => 'latest',
    ];

    private $nodeIsInstalled = false;

    private $bowerIsInstalled = false;

    /**
     * @var array Contains an array of pdo drivers
     */
    private $pdoDrivers = [
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

    private $apacheUser;

    private $apacheUserGroup;

    private $httpdConfPath;

    private $vhostConfPath;

    /**
     * CLI application constructor
     *
     * @throws \ErrorException
     */
    public function __construct()
    {
        $this->bowerPath = _ROOT . DS . "bower.json";
        parent::__construct(DI::get('IOStream'), DI::get('Config'));
    }

    public function showHelp() {
        $this->printSign();
        parent::showHelp();
    }

    /**
     * Prints the CoreFramework CLI sign
     */
    private function printSign()
    {
        $this->io->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );
        $this->io->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );
        $this->io->writeln(
            '                                                                                                                                                        '
        );
        $this->io->writeln(
            " ______     ______     ______     ______        ______   ______     ______     __    __     ______     __     __     ______     ______     __  __    ",
            'yellow'
        );
        $this->io->writeln(
            "/\\  ___\\   /\\  __ \\   /\\  == \\   /\\  ___\\      /\\  ___\\ /\\  == \\   /\\  __ \\   /\\ \"-./  \\   /\\  ___\\   /\\ \\  _ \\ \\   /\\  __ \\   /\\  == \\   /\\ \\/ /    ",
            'yellow'
        );
        $this->io->writeln(
            "\\ \\ \\____  \\ \\ \\/\\ \\  \\ \\  __<   \\ \\  __\\      \\ \\  __\\ \\ \\  __<   \\ \\  __ \\  \\ \\ \\-./\\ \\  \\ \\  __\\   \\ \\ \\/ \".\\ \\  \\ \\ \\/\\ \\  \\ \\  __<   \\ \\  _\"-.  ",
            'yellow'
        );
        $this->io->writeln(
            " \\ \\_____\\  \\ \\_____\\  \\ \\_\\ \\_\\  \\ \\_____\\     \\ \\_\\    \\ \\_\\ \\_\\  \\ \\_\\ \\_\\  \\ \\_\\ \\ \\_\\  \\ \\_____\\  \\ \\__/\".~\\_\\  \\ \\_____\\  \\ \\_\\ \\_\\  \\ \\_\\ \\_\\ ",
            'yellow'
        );
        $this->io->writeln(
            "  \\/_____/   \\/_____/   \\/_/ /_/   \\/_____/      \\/_/     \\/_/ /_/   \\/_/\\/_/   \\/_/  \\/_/   \\/_____/   \\/_/   \\/_/   \\/_____/   \\/_/ /_/   \\/_/\\/_/ ",
            'yellow'
        );
        echo "                                                                                                                                                     ";
        $this->io->writeln(
            '                                                                                                                                                        '
        );
        $this->io->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );
        $this->io->writeln(
            '@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@',
            'green'
        );

        $this->io->writeln('Core Framework Console (c) Shalom Sam <shalom.s@coreframework.in>', 'green');
    }

    public function install($appName = "demoapp", $dev = false)
    {
        if ($dev === true) {
            $this->environment = "development";
        }

        $this->appName = $appName;
        $this->appDirPath = _ROOT . DS . $appName;
        $this->printSign();
        $this->io->writeln("version: " . $this->getVersion());
        $this->createAlias();
        $this->checkNodeIsInstalled();
        $this->checkBowerIsInstalled();

        if ($appName !== 'demoapp') {
            $this->addCliConf('core.appList', $appName);
            $this->getFrontEndManager();
        }

        switch ($this->frontEndManager) {

            case 'bower':
                $this->getBowerDependencies();
                $this->bower('install');
                $this->symResources($appName);
                $this->setupApp($appName);
                break;

            // TODO : add support for other front-end dependency management systems
            // case 'yeoman':
            //    $this->installYeoMan();
            //    break;
        }

        $this->createCacheFolder();
        $this->createSmartyCache();
        $this->io->writeln("Application setup successfully!", 'green');
    }

    /**
     * creates an alias for access to the Console cli script/commands
     */
    public function createAlias()
    {
        $console = __DIR__ . DS . "Console";
        $aliases = "alias core=$console";
        if (!exec($aliases) && $this::$verbose === true) {
            $this->io->showErr("Failed to create alias");
        }
    }

    /**
     * Returns true if node.js is installed, else false
     *
     * @return bool
     */
    private function checkNodeIsInstalled()
    {
        $output = shell_exec('node -v');
        if (strpos($output, "command not found") !== false) {
            $this->io->showErr(
                "Core Framework requires Node.js for setting up your applications Front-End. Please install Node.js and try again."
            );
            return false;
        } else {
            $this->nodeIsInstalled = true;
            return true;
        }
    }

    /**
     * Returns true if bower is installed, else false
     *
     * @return bool
     */
    private function checkBowerIsInstalled()
    {
        $output = shell_exec('bower -v');

        if (strpos($output, "command not found") !== false) {
            if ($this->nodeIsInstalled === true) {
                try {
                    echo exec('npm install -g bower');
                } catch (\Exception $e) {
                    $this->io->showErr($e->getMessage());
                    return false;
                }
                $this->bowerIsInstalled = true;
            } else {
                $this->io->showErr(
                    "Core Framework requires Node.js for setting up your applications Front-End. Please install Node.js and try again."
                );
                return false;
            }
        }

        return true;
    }

    /**
     * Returns the front-end manager for App
     *
     * @return string
     */
    private function getFrontEndManager()
    {
        $cliConf = $this->config->getCliConfig();
        if (!isset($cliConf['frontEndManager'])) {
            $choice = $this->io->choice(
                "Which front-end dependecy management system would you like to use",
                $this->supportedFEs
            );
            $this->frontEndManager = $this->supportedFEs[$choice];
            $this->config->setCliConfig("core.{$this->appName}.frontEndManager", $this->frontEndManager);
        } elseif (count($this->supportedFEs) === 1) {
            $this->frontEndManager = $this->supportedFEs[0];
        } else {
            $this->frontEndManager = $cliConf['frontEndManager'];
        }

        return $this->frontEndManager;
    }

    /**
     * Gets front-end dependencies
     *
     * @throws \ErrorException
     */
    private function getBowerDependencies()
    {
        if ($this->appName === 'demoapp') {
            return;
        }

        $bowerJson = file_get_contents($this->bowerPath);
        $bower = json_decode($bowerJson, true);
        $this->io->writeln("Currently installed front-end packages are :", 'green');

        foreach ($bower['dependencies'] as $name => $version) {
            if (!empty($version)) {
                $version = "version: {$version}";
            }
            $this->io->writeln("* {$name} {$version}");
        }
        $response = $this->io->ask("Would you like to add more front-end dependencies?", "No", ['Yes', 'No']);
        if (strtolower($response) === 'yes') {
            $commonPackages = array_keys($this->bowerCommonPackages);
            $choices = $this->io->choice("Which of the below dependencies would you like to add", $commonPackages);
            $wantedPackages = [];
            if (is_array($choices)) {
                foreach ($choices as $choice) {
                    array_push($wantedPackages, $commonPackages[$choice]);
                }
            } else {
                $choices = (int)$choices;
                $wantedPackages[] = $commonPackages[$choices];
            }

            $this->addDependenciesFile($wantedPackages);
        }
    }

    /**
     * Adds dependencies.json
     *
     * @param $dependencies
     */
    private function addDependenciesFile(array $dependencies)
    {
        if ($this->appName === 'demoapp') {
            return;
        }

        if (empty($this->appName)) {
            $this->getAppNameFromUser();
        }

        $dependencyPath = _ROOT . DS . $this->appName . DS . "dependencies.json";

        if (!is_readable($dependencyPath) && !is_file($dependencyPath)) {
            @touch($dependencyPath);
        } else {
            chmod($dependencyPath, 0777);
        }

        $dependencyJson = file_get_contents($dependencyPath);
        $dependencyObj = [];

        if (!empty($dependencyJson)) {
            if ($this::$verbose === true) {
                $this->io->writeln("Adding to dependencies.json");
            }
            $dependencyObj = json_decode($dependencyJson, true);
        } else {
            if ($this::$verbose === true) {
                $this->io->writeln("Creating dependencies.json");
            }
            $dependencyObj['name'] = $this->appName;
            $dependencyObj['version'] = $this->getVersion();
        }

        $dependencyArr = $dependencyObj['dependencies'];
        foreach ($dependencies as $dependency) {
            if (isset($dependencyArr->$dependency)) {
                $this->io->writeln("dependency {$dependency} already exists", 'yellow');
            } else {
                $dependencyArr[$dependency] = $this->bowerCommonPackages[$dependency];
            }
        }
        $dependencyObj['dependencies'] = $dependencyArr;
        $dependencyJson = json_encode($dependencyObj);
        chmod($dependencyPath, 0777);
        if (file_put_contents($dependencyPath, $dependencyJson) === false) {
            $this->io->showErr("Unable to write file {$dependencyPath}");
            exit;
        }
        chmod($dependencyPath, 0655);

        $this->addDependeciesToBower();
    }

    /**
     * Gets the appName from user
     */
    private function getAppNameFromUser()
    {
        $callback = (function ($input) {
            $appPath = _ROOT . DS . $input;
            if (is_dir($appPath)) {
                return true;
            } else {
                return false;
            }
        });
        $this->appName = $this->io->askAndValidate(
            "Please enter the appName of the application",
            $callback,
            "Must be an existing appName, with existing app directory"
        );

        $this->appDirPath = _ROOT . DS . $this->appName;
    }

    /**
     * Writes dependencies in dependencies.json to main bower.json
     *
     * @throws \ErrorException
     */
    private function addDependeciesToBower()
    {
        $bowerJson = file_get_contents($this->bowerPath);
        $dependencyPath = _ROOT . DS . $this->appName . DS . "dependencies.json";
        chmod($dependencyPath, 0777);
        if (!is_readable($dependencyPath)) {
            throw new \ErrorException("dependecies.json file is not readable");
        }
        $dependecyJson = file_get_contents($dependencyPath);
        $dependecyObj = json_decode($dependecyJson, true);
        $bowerObj = json_decode($bowerJson, true);

        $dependencyArr = $bowerObj['dependencies'];
        foreach ($dependecyObj['dependencies'] as $name => $version) {
            $dependencyArr[$name] = $version;
        }
        $bowerObj['dependencies'] = $dependencyArr;
        $bowerJson = json_encode($bowerObj, JSON_PRETTY_PRINT);
        chmod($this->bowerPath, 0777);
        if (file_put_contents($this->bowerPath, $bowerJson) === false) {
            $this->io->showErr("Unable to write file {$this->bowerPath}");
        }
        chmod($this->bowerPath, 0655);
    }

    /**
     * For bower install & update
     *
     * @param $command
     */
    private function bower($command)
    {
        echo exec("bower --allow-root {$command}") . "\n";
    }

    /**
     * Creates symlinks for front-end resources
     *
     * @param $appName
     */
    public function symResources($appName = null)
    {
        if (empty($appName)) {
            $this->getAppNameFromUser();
        }
        $this->io->writeln("Attempting to sym links resources from Bower -> $appName", "green");
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
                    @rmdir($appScripts);
                } elseif (is_file($appScripts) || is_readable($appScripts)) {
                    @unlink($appScripts);
                }
                if (is_dir($appStyles)) {
                    @rmdir($appStyles);
                } elseif (is_file($appStyles) || is_readable($appStyles)) {
                    @unlink($appStyles);
                }

                if (is_dir($bowerDir . $packName . DS . "dist") &&
                    is_dir($bowerDir . $packName . DS . "dist" . DS . "css") &&
                    is_dir($bowerDir . $packName . DS . "dist" . DS . "js") &&
                    is_dir($bowerDir . $packName . DS . "dist" . DS . "fonts")
                ) {

                    $return = @symlink($bowerDir . $packName . DS . "dist" . DS . "js" . DS, $appScripts);
                    $return2 = @symlink($bowerDir . $packName . DS . "dist" . DS . "css" . DS, $appStyles);

                    if ($return === true) {
                        $this->io->writeln("Symlink created for $appScripts ..", 'green');
                    } elseif ($return2 === true) {
                        $this->io->writeln("Symlink created for $appStyles ..", 'green');
                    } elseif ($return === false) {
                        $this->io->writeln("Unable to create Symlink for $appScripts ..", 'yellow');
                    } elseif ($return2 === false) {
                        $this->io->writeln("Unable to create Symlink for $appStyles ..", 'yellow');
                    }

                    $fonts = new \DirectoryIterator($bowerDir . $packName . DS . "dist" . DS . "fonts" . DS);
                    foreach ($fonts as $font) {
                        if (!$font->isDir() && !$font->isDot()) {
                            $fontFilename = $font->getFilename();
                            $fontFile = $appDir . "styles" . DS . "fonts" . DS . $fontFilename;
                            $return = @symlink(
                                $bowerDir . $packName . DS . "dist" . DS . "font" . DS . $fontFilename,
                                $fontFile
                            );

                            if ($return === true) {
                                $this->io->writeln("Symlink created for $fontFile ..", 'green');
                            } else {
                                $this->io->writeln("Unable to create Symlink for $fontFile ..", 'yellow');
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
                                $return = @symlink($bowerDir . $packName . DS . "dist" . DS, $appScripts);
                                $path = 'appScripts';
                            } elseif ($fileExt === 'css') {
                                $return = @symlink($bowerDir . $packName . DS . "dist" . DS, $appStyles);
                                $path = 'appStyles';
                            }

                            if ($return === true) {
                                $this->io->writeln("Symlink created for " . $$path . "..", 'green');
                            } else {
                                $this->io->writeln("Unable to create Symlink for " . $$path . " ..", 'yellow');
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
    public function setupApp($appName)
    {
        if (empty($appName)) {
            $this->getAppNameFromUser();
        }

        $this->io->writeln("Setting up App - {$appName}");
        $appDirPath = $this->appDirPath;
        if ($this->frontEndManager === "bower") {
            if (!is_readable($appDirPath)) {
                @mkdir($appDirPath, 0755);
                @mkdir($appDirPath . DS . "Templates", 0755);
                @copy(
                    _ROOT . DS . "demoapp" . DS . "Templates" . DS . "root.tpl",
                    $appDirPath . DS . "Templates" . DS . "root.tpl"
                );
                @chmod($appDirPath . DS . "Templates" . DS . "root.tpl", 0755);
                @mkdir($appDirPath . DS . "Templates" . DS . "common", 0755);
                Helper::copyr(
                    _ROOT . DS . "demoapp" . DS . "Templates" . DS . "common",
                    $appDirPath . DS . "Templates" . DS . "common"
                );
                @mkdir($appDirPath . DS . "Templates" . DS . "errors", 0755);
                Helper::copyr(
                    _ROOT . DS . "demoapp" . DS . "Templates" . DS . "errors",
                    $appDirPath . DS . "Templates" . DS . "errors"
                );
                @mkdir($appDirPath . DS . "Templates" . DS . "root", 0755);
                Helper::copyr(
                    _ROOT . DS . "demoapp" . DS . "Templates" . DS . "root",
                    $appDirPath . DS . "Templates" . DS . "root"
                );

                $this->createConf($appName);
                $this->createIndex($appName);
                $this->createHtaccess($appName);

            } else {
                $this->io->writeln("App Directory by $appName already exists", "yellow");
                $this->createIndex($appName);
                $this->createHtaccess($appName);
                $this->createConf($appName);
            }
        }


        $this->io->writeln("You can setup virtual hosts using the following command -", 'green');
        $consolePath = _ROOT . DS . "src" . DS . "Core" . DS . "Scripts" . DS . "Console";
        $name = empty($this->appName) ? '{appDirName}' : $this->appName;
        $this->io->writeColoredLn(
            "sudo:yellow $consolePath:cyan setupHost:cyan $name:white"
        );
        $this->io->writeln(" ");
        $this->io->writeln("OR You can start a localhost server using the following command -", 'green');
        $this->io->writeColoredLn("php:yellow -S:white 127.0.0.8\\:8000:yellow -t:white {$name}/:cyan");
    }

    /**
     * Create Conf files
     *
     * @param $appName
     * @throws \Exception
     */
    public function createConf($appName = null)
    {
        if (empty($appName)) {
            $this->getAppNameFromUser();
        }

        if ($this::$verbose === true) {
            $this->io->writeln("Creating config files for {$this->appName}");
        }

        $confSource = __DIR__ . DS . "pak" . DS . "config.pak";
        $appDirPath = _ROOT . DS . $appName;
        $confDest = $appDirPath . DS . "config";
        $confFile = $confDest . DS . "global.conf.php";
        $routesConf = $confDest . DS . "routes.conf.php";

        if (!is_readable($confFile) || !is_readable($routesConf)) {

            $accumilate['pdoDriver'] = $this->io->askAndValidate(
                "Enter PDO Driver to use ",
                function ($input) {
                    if (in_array($input, $this->pdoDrivers)) {
                        return true;
                    } else {
                        return false;
                    }
                },
                "of type " . Helper::serialize($this->pdoDrivers),
                'mysql'
            );

            $accumilate['host'] = $this->io->ask('Enter host ip', '127.0.0.1');
            $accumilate['db'] = $this->io->ask('Enter database name', 'coredb');
            $accumilate['user'] = $this->io->ask('Enter database user', 'root');
            $accumilate['pass'] = $this->io->ask('Enter database password', null);

            if ($this::$verbose) {
                $this->io->writeln("Creating conf file...");
            }

            if (!is_dir($confDest)) {
                @mkdir($confDest, 0755, true);
            }

            Helper::copyr($confSource, $confDest);
            Helper::chmodDirFiles($confDest, 0655);

            $conf = require_once $confFile;

            foreach ($conf as $key => $val) {
                $conf[$key] = $accumilate[$key];
            }

            $check = file_put_contents($confFile, '<?php return ' . var_export($conf, true) . ";\n");

            if ($check) {
                $this->io->writeln("Conf file Created Successfully");
            } else {
                $this->io->showErr("Error writing configuration file - " . $confFile);
                exit;
            }
        } elseif ($this::$verbose === true) {
            $this->io->writeln("Conf files exists! Continuing setup..", "yellow");
        }

    }

    /**
     * Creates app Index file
     *
     * @param $appName
     * @return bool
     */
    public function createIndex($appName = null)
    {
        if (empty($appName)) {
            $this->getAppNameFromUser();
        }

        $index = __DIR__ . DS . "pak" . DS . "index.pak";
        $appDirPath = _ROOT . DS . $appName . DS;
        $newIndex = $appDirPath . "index.php";
        $contents = file_get_contents($index);
        $newContents = preg_replace('/\{appName\}/', $appName, $contents);

        if (is_readable($newIndex)) {

            if ($this::$verbose === true) {
                $this->io->write("Merging current index with original index file", 'green');
            }
            $this->merge2Files($index, $newIndex);

        } else {
            if ($this::$verbose === true) {
                $this->io->writeln("Creating app's index.php file...", "green");
            }
            if (touch($newIndex) === false) {
                $this->io->showErr("Unable to create file - {$newIndex}");
                return false;
            }
            if (file_put_contents($newIndex, $newContents) === false) {
                $this->io->showErr("Failed to create index file!!");
                return false;
            } else {
                $this->io->writeln("Index file created successfully!", 'green');
                return true;
            }
        }

    }

    /**
     * Merges $orgFile into $existingFile, both $orgFile & $existingFile must be valid readable (full)file paths
     *
     * @param $orgFile
     * @param $existingFile
     */
    public function merge2Files($orgFile, $existingFile)
    {
        $fileArr1 = file($orgFile);
        $fileArr2 = file($existingFile);
        $diffs = array_diff($fileArr1, $fileArr2);
        $diffContent = $fileArr1;

        foreach ($diffs as $index => $diff) {
            array_splice($diffContent, $index - 1, 0, "<<<<< Edited (your) content" . PHP_EOL);
            array_splice($diffContent, $index, 0, $fileArr2[$index]);
            array_splice($diffContent, $index + 1, 0, "===========" . PHP_EOL);
            array_splice($diffContent, $index + 2, 0, $fileArr1[$index]);
            array_splice($diffContent, $index + 3, 0, ">>>>> Original content" . PHP_EOL);
        }
        chmod($existingFile, 0755);
        if (file_put_contents($existingFile, $diffContent) === false) {
            $this->io->showErr("Unable write file {$existingFile}");
            exit;
        } elseif (sizeof($diffs) > 0) {
            $this->io->showErr("Merge conflict in $existingFile");
            $this->io->writeln("Continuing ....", 'green');
        } elseif ($this::$verbose === true) {
            $this->io->writeln("{$existingFile} Merged successfully!", 'green');
        }
        chmod($existingFile, 0655);
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
            $this->getAppNameFromUser();
        }

        $htaccess = __DIR__ . DS . "pak" . DS . ".htaccess.pak";
        $appDir = _ROOT . DS . $appName . DS;
        $newHtaccess = $appDir . ".htaccess";
        $htaccessContents = file_get_contents($htaccess);

        if (is_readable($newHtaccess)) {
            if ($this::$verbose === true) {
                $this->io->writeln("Merging current htaccess file with original htaccess file");
            }
            $this->merge2Files($htaccess, $newHtaccess);
        }

        if (touch($newHtaccess) === false) {
            $this->io->showErr("Unable to create .htaccess file for {$this->appName}");
        }

        if (file_put_contents($newHtaccess, $htaccessContents) === false) {
            $this->io->showErr("Failed to create .htaccess file!!");
            return false;
        } elseif ($this::$verbose === true) {
            $this->io->writeln(".htaccess file created successfully!", 'green');
            return true;
        }

    }


    /**
     * Create cache folder, if exist changes the owner of the folder to right apache user
     */
    private function createCacheFolder()
    {
        $httpdConfPath = $this->findHttpdConf();

        if (gettype($httpdConfPath) === 'string') {

            exec('egrep "^User|^Group|^SuexecUserGroup" ' . $httpdConfPath, $output);

            $tmp = explode(" ", $output[0]);
            $apacheUser = $tmp[1];
            $this->apacheUser = $apacheUser;

            $tmp = explode(" ", $output[1]);
            $apacheGroup = $tmp[1];
            $this->apacheUserGroup = $apacheGroup;

            if ($apacheUser === '${APACHE_RUN_USER}' && $apacheGroup === '${APACHE_RUN_GROUP}') {
                $httpdPathArr = explode(DS, $httpdConfPath);
                array_pop($httpdPathArr);
                $httpdDir = implode(DS, $httpdPathArr);
                $envvars = $httpdDir . DS . "envvars";

                if (is_readable($envvars)) {
                    exec('egrep "^export APACHE_RUN_USER|export APACHE_RUN_GROUP" ' . $envvars, $output);

                    foreach ($output as $line) {
                        if (strpos($line, 'export APACHE_RUN_USE') > -1) {
                            $tmp1 = explode("=", $line);
                            $this->apacheUser = $apacheUser = $tmp1[1];

                        } elseif (strpos($line, 'export APACHE_RUN_GROUP') > -1) {
                            $tmp2 = explode("=", $line);
                            $this->apacheUserGroup = $apacheGroup = $tmp2[1];
                        }
                    }

                }

                if (empty($this->apacheUser) && empty($this->apacheUserGroup)) {
                    $this->apacheUser = $this->io->ask("Please enter the Apache User name");
                    $this->apacheUserGroup = $this->io->ask(
                        "Please enter the Apache User Group",
                        $this->apacheUser
                    );
                }
            }

            $cacheDir = _ROOT . DS . "src" . DS . "Core" . DS . "cache" . DS;

            if ($this::$verbose === true) {
                $this->io->writeln("creating cache folder", 'green');
            }

            if (!is_dir($cacheDir)) {
                mkdir($cacheDir, 0777);
                chown($cacheDir, $apacheUser);
            } else {
                if ($this::$verbose === true) {
                    $this->io->writeln("Setting up cache folder", 'green');
                }
                if( chown($cacheDir, $apacheUser) === false ) {
                    exec('sudo chown ' . $apacheUser . ' ' . $cacheDir);
                }
                if( chmod($cacheDir, 0777) === false ) {
                    exec('sudo chmod 0777 ' . $cacheDir);
                }
            }
        }
    }


    /**
     * Finds apache conf file path
     *
     * @return bool|string
     */
    private function findHttpdConf()
    {
        if (!empty($this->httpdConfPath)) {
            return $this->httpdConfPath;
        }

        $cliConf = $this->config->getCliConfig();
        if (isset($cliConf['core']['httpdConfPath'])) {
            return $cliConf['core']['httpdConfPath'];
        }

        exec('apachectl -V', $respArr);
        foreach ($respArr as $item) {
            if (strpos($item, "SERVER_CONFIG_FILE") !== false) {
                $arr = explode("=", $item);
                $httpdConfPath = trim($arr[1], '"');
            }
        }

        if (empty($httpdConfPath) || !is_dir($httpdConfPath)) {
            $this->io->writeln("Cannot find httpd.conf!", "yellow");
            $rep = $this->io->ask("Please enter full path to httpd.conf ");
            if (is_file($rep)) {
                $this->httpdConfPath = $rep;
                $this->addCliConf('core.httpdConfPath', $rep);
                return $rep;
            } else {
                $this->io->showErr("Valid File not provided!");
                return false;
            }
        } else {
            $this->httpdConfPath = $httpdConfPath;
            $this->addCliConf('core.httpdConfPath', $httpdConfPath);
            return $httpdConfPath;
        }
    }

    /**
     * Creates smarty cache directories
     */
    private function createSmartyCache()
    {
        if ($this::$verbose === true) {
            $this->io->writeln('Creating smarty cache..', 'green');
        }

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
    public function addHosts($domain, $ip)
    {
        if (empty($domain) || empty($ip)) {
            $this->io->showErr("Domain and ip must be provided");
            exit;
        }
        $hostFile = $this->getHostsFile();
        $hostTpl = "{ip}\tdev.{userDomain}\n";
        $hostNewContent = str_replace('{userDomain}', $domain, $hostTpl);
        $hostNewContent = str_replace('{ip}', $ip, $hostNewContent);
        $hostContent = file_get_contents($hostFile);
        $h = fopen($hostFile, 'a');
        $return = fwrite($h, ($hostContent != "" ? "\n" . $hostNewContent : $hostNewContent));
        fclose($h);
        if ($return !== false) {
            $this->io->writeln("Hosts file successfully updated!", 'green');
        } else {
            $this->io->writeln("Warning: could not update hosts file.", 'yellow');
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
            $resp = $this->io->askAndValidate(
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
    public function removeVhost($appName, $removeVhost = true, $removeHostEntry = true)
    {
        if (empty($appName)) {
            $this->io->showErr("appName cannot be empty!");
            exit;
        }
        $appName = strtolower($appName);
        $hostFile = $this->getHostsFile();
        $httpdConfFile = $this->findHttpdConf();
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
                $this->io->writeln(
                    "Entries for $appName have been removed from $httpdConfFile successfully",
                    'green'
                );
            } else {
                $this->io->showErr("Could not find vhost entry for $appName in $httpdConfFile");
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
                $this->io->writeln("Entries for $appName have been removed from $hostFile successfully", 'green');
            } else {
                $this->io->writeln("Could not fine vhost entry for $appName in $hostFile", 'yellow');
            }

        }

    }

    /**
     * Add virtual host entery to httpd-vhosts.conf if found else httpd.conf
     *
     * @param $domain
     * @param $ip
     */
    public function addVhost($domain, $ip)
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
        $httpdConfPath = $this->findHttpdConf();
        $vhostConfFile = $this->getVhostPath($httpdConfPath);
        $oldContent = file_get_contents($vhostConfFile);
        $handle = fopen($vhostConfFile, 'a');
        $return = fwrite($handle, ($oldContent != "" ? "\n" . $newContent : $newContent));
        fclose($handle);
        if ($return !== false) {
            $this->io->writeln("Vhost entry added successfully.", 'green');
        } else {
            $this->io->writeln("Warning: failed to write vhost/httpd.conf file", 'yellow');
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
        if (!empty($this->vhostConfPath)) {
            return $this->vhostConfPath;
        }

        $cliConf = $this->config->getCliConfig();
        if (isset($cliConf['core']['vHostPath'])) {
            return $cliConf['core']['vHostPath'];
        }

        if (empty($httpdConf)) {
            if (!empty($this->httpdConfPath)) {
                $httpdConf = $this->httpdConfPath;
            } else {
                $httpdConf = $this->findHttpdConf();
                if (gettype($httpdConf) !== 'string') {
                    $this->io->showErr("HttpdConf file not provided");
                    exit;
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
            $this->vhostConfPath = $vhostPath;
            $this->addCliConf('core.vHostPath', $vhostPath);
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
    public function addConfigVars($key, $val)
    {
        $this->io->writeln("Adding values - $key = $val");

        $globalConfig = $this->config->getGlobalConfig();
        $globalConfig[$key] = $val;

        $r = $this->config->store($globalConfig, $this->config->globalConfPath);
        if ($r === true) {
            $this->io->writeln("Config added successfully.");
        } else {
            $this->io->showErr("failed to add the values to file");
        }
    }

    /**
     * Clear all cache
     */
    public function clearCache()
    {
        /** @var Cache $cache */
        $cache = DI::get('Cache');
        $cache->clearCache();
        $this->io->writeln("Cache successfully cleared!", 'green');
    }
}