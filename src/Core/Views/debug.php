<?php
/**
 * This file is part of the Core Framework package.
 *
 * (c) Shalom Sam <shalom.s@coreframework.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$total_time = microtime(true) - $_SERVER['REQUEST_TIME_FLOAT'];
$total_time_ms = round($total_time * 1000);

//$cpu = sys_getloadavg();
$memory = memory_get_usage(true);
$peak = memory_get_peak_usage(true);

$memory_mb = bytesToMb($memory);
$peak_mb = bytesToMb($peak);

function bytesToKb($bytes)
{
    return $bytes / 1024;
}

function bytesToMb($bytes)
{
    return bytesToKb($bytes) / 1024;
}

return $html = '<div class="debugWrp minimize-wrap right" >' .
    '<div class="debugBox minimize-content" >' .
    '<div class="pull-left"><img src="/images/CoreFramework-B-Logo.png" width="200" /></div>' .
    '<div class="pull-left">memory: <span class="label label-default">' . $memory_mb . ' MB</span></div>' .
    '<div class="pull-left">peak: <span class="label label-default">' . $peak_mb . ' MB</span></div>' .
    '<div class="pull-left">time: <span class="label label-default">' . $total_time_ms . ' ms</span></div>' .
    '</div>' .
    '<div class="btnWrp pull-right"><a href="#" class="minimize glyphicon glyphicon-chevron-right"></a></div>' .
    '</div>';