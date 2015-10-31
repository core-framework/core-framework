<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$cli = [
    '$global' => require('global.conf.php'),
    '$db' => require('db.conf.php'),
    '$components' => require('cliComponents.conf.php'),
    '$commands' => require('commands.conf.php'),
    '$options' => require('options.conf.php'),
];

if ($cli['$global']['apcIsLoaded'] && $cli['$global']['apcIsEnabled']) {
    $cli['$global']['hasAPC'] = true;
} else {
    $cli['$global']['hasAPC'] = false;
}

$override = require("override.conf.php");

$cli = array_replace_recursive($cli, $override);

return $cli;