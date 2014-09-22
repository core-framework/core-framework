<?php

ini_set('session.save_path', '/tmp');
ini_set('session.use_cookies', 1);
ini_set('session.cookie_lifetime', 1440);
//ini_set('session.cookie_domain', 'coreframework'); //change Domain as required


$sess_id = session_id();
if (empty($sess_id)) {
    session_start();
}

define('_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('_SRC_DIR', "src");
define('_CORE', _ROOT . DS . _SRC_DIR . DS . "Core");
define('DS', DIRECTORY_SEPARATOR);

$loader = require_once _ROOT . DS . "vendor" . DS . "autoload.php";

use Core\core;

$core = new core(true);
$core->forceApc = false;
$core->registerApp('demoapp\\', DS . 'demoapp' . DS);
$core->Load();

session_write_close();

?>