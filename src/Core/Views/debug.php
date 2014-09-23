<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$total_time = round(microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'], 3);

$cpu = sys_getloadavg();

return $html = '<div style="padding: 10px; position: fixed; left: 0px; bottom: 0px; height: 37px; width: 100%; background: #dcdcdc; z-index: 99999; box-shadow: 0px -1px 5px rgba(0,0,0,0.4);" >' .
    '<span style="padding: 10px 5px;">core.mem = ' . xdebug_memory_usage() . '</span>' .
    '<span style="padding: 10px 5px;">core.mem_peak = ' . xdebug_peak_memory_usage() . '</span>' .
    '<span style="padding: 10px 5px;">core.cpu_usage = [0] => ' . $cpu[0] . ' [1] => ' . $cpu[1] . ' [2] =>' . $cpu[2] . '</span>' .
    '<span style="padding: 10px 5px;">core.exec_time = ' . $total_time . ' seconds </span>' .
    '</div>';