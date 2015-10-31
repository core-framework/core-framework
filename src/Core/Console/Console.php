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

namespace Core\Console;


class Console extends CLI
{
    public $apacheUser;
    public $apacheUserGroup;
    public $apacheConfPath;

    public function __construct(IOStream $IOStream, $config = null)
    {
        $this->loadConsole();
        parent::__construct($IOStream, $config);
    }

    public function parse()
    {
        $argv = $this->io->getArgv();
        parent::parse($argv);
    }

    private function loadConsole()
    {
        $this->setVersion('1.0.0');
        $this->setToolName('Reactor');

        $this->addCommand('install', "Install Composer and bower to set up the framework", 'self::install');
    }

    public function showHelp()
    {
        $this->printSign();
        parent::showHelp();
    }


    public function install()
    {
        $this->createCacheFolder();
        $this->createSmartyCache();
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


    /**
     * Create cache folder, if exist changes the owner of the folder to right apache user
     */
    private function createCacheFolder()
    {
        $apacheConfPath = $this->findApacheConf();

        if (gettype($apacheConfPath) === 'string') {

            exec('egrep "^User|^Group|^SuexecUserGroup" ' . $apacheConfPath, $output);

            $tmp = explode(" ", $output[0]);
            $apacheUser = $tmp[1];
            $this->apacheUser = $apacheUser;

            $tmp = explode(" ", $output[1]);
            $apacheGroup = $tmp[1];
            $this->apacheUserGroup = $apacheGroup;

            if ($apacheUser === '${APACHE_RUN_USER}' && $apacheGroup === '${APACHE_RUN_GROUP}') {
                $apachePathArr = explode("/", $apacheConfPath);
                array_pop($apachePathArr);
                $apacheDir = implode("/", $apachePathArr);
                $envvars = $apacheDir . "/envvars";

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

            $cacheDir = _ROOT . "/src/Core/cache/";

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
                if (chown($cacheDir, $apacheUser) === false) {
                    exec('sudo chown ' . $apacheUser . ' ' . $cacheDir);
                }
                if (chmod($cacheDir, 0777) === false) {
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
    private function findApacheConf()
    {
        if (!empty($this->apacheConfPath)) {
            return $this->apacheConfPath;
        }

        if ($this->cache->cacheExists('apacheConfPath')) {
            return $this->cache->getCache('apacheConfPath');
        }

        exec('apachectl -V', $respArr);

        foreach ($respArr as $item) {
            if (strpos($item, "SERVER_CONFIG_FILE") !== false) {
                $arr = explode("=", $item);
                $apacheConfPath = trim($arr[1], '"');
            }
        }

        if (empty($apacheConfPath) || !is_dir($apacheConfPath)) {
            $this->io->writeln("Cannot find your apache conf file!", "yellow");
            $rep = $this->io->ask("Please enter full path to apache conf file:");
            if (is_file($rep)) {
                $this->apacheConfPath = $rep;
                $this->cache->cacheContent('apacheConfPath', $rep, 1000);
                return $rep;
            } else {
                $this->io->showErr("Valid File not provided!");
                return false;
            }
        } else {
            $this->apacheConfPath = $apacheConfPath;
            $this->cache->cacheContent('apacheConfPath', $apacheConfPath, 1000);
            return $apacheConfPath;
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

        $smartyCacheDir = _ROOT . "/storage/smarty_cache";
        $smarty_sub_cache = $smartyCacheDir . "/cache";
        $smarty_sub_config = $smartyCacheDir . "/config";
        $smarty_sub_template = $smartyCacheDir . "/templates_c";

        if (!is_dir($smartyCacheDir)) {
            exec('sudo mkdir ' . $smartyCacheDir);
        } else {
            exec('sudo chmod 0777 ' . $smartyCacheDir);
        }
        if (!is_dir($smarty_sub_cache)) {
            exec('sudo mkdir ' . $smarty_sub_cache);
        } else {
            exec('sudo chmod 0777 ' . $smarty_sub_cache);
        }
        if (!is_dir($smarty_sub_config)) {
            exec('sudo mkdir ' . $smarty_sub_config);
        } else {
            exec('sudo chmod 0777 ' . $smarty_sub_config);
        }
        if (!is_dir($smarty_sub_template)) {
            exec('sudo mkdir ' . $smarty_sub_cache);
        } else {
            exec('sudo chmod 0777 ' . $smarty_sub_config);
        }
    }

}