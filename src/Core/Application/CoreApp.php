<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/02/15
 * Time: 10:37 AM
 */

namespace Core\Application;

/**
 * Class CoreApp
 * @package Core\Application
 */
class CoreApp extends BaseCoreApp
{

}

spl_autoload_register(['Core\\Application\\CoreApp', 'autoload'], true, true);