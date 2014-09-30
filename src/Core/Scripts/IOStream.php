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


class IOStream extends cmdcolors
{
    protected $input;
    protected $output;
    protected $error;
    private $repeat;

    public function __construct()
    {
        parent::__construct();
        $this->input = fopen('php://stdin', 'r');
        $this->output = fopen('php://output', 'w');
        $this->error = fopen('php://stderr', 'w');
    }

    public function __destruct()
    {
        fclose($this->input);
        fclose($this->output);
        fclose($this->error);
    }

    public function askAndValidata($msg, $callback, $format, $default = null, $repeat = 2)
    {
        for ($i = $repeat; $i >= 0; $i--) {
            $resp = $this->ask($msg, $default);
            $valid = $callback($resp);
            $this->repeat = $repeat;

            if ($valid && $this->repeat !== 0) {
                return $resp;
            } elseif (!$valid && $this->repeat !== 0 || (!$valid && $this->repeat !== 0 && empty($default))) {
                self::writeln("Sorry input must be " . $format, "yellow");
                continue;
            } elseif (!$valid && $this->repeat === 0 && !empty($default)) {
                return $default;
            } else {
                if (!$format) {
                    $this->showErr("Valid input not provided ");
                } else {
                    $this->showErr("Valid input not provided must be " . $format);
                }
                return false;
            }
        }
    }

    public function ask($msg, $default = null, $opt = null)
    {
        $coloredMsg = $this->getColoredString($msg, 'green');
        if (!empty($default)) {
            fprintf($this->output, "%s : [" . $default . "] ", $coloredMsg);
        } else {
            fprintf($this->output, "%s : ", $coloredMsg);
        }

        $input = trim(fgets($this->input), "\n");

        if (!empty($opt) || !empty($default)) {
            if (empty($input) && !empty($default)) {
                return $default;
            } elseif (in_array($input, $opt) && is_array($opt)) {
                return $input;
            } elseif (!is_array($opt)) {
                $this->showErr("Option must be of type array");
                return true;
            } else {
                return false;
            }
        } else {
            return $input;
        }
    }

    public function showErr($msg)
    {
        $coloredMsg = $this->getColoredString($msg, 'white', 'red');
        fprintf($this->output, "\n %s \n", $coloredMsg);
    }

    public function writeln($msg, $foreColor = null, $backColor = null, $format = null)
    {
        $coloredMsg = $msg;

        if (!empty($foreColor)) {
            $coloredMsg = $this->getColoredString($msg, $foreColor, $backColor);
        }

        if (!empty($format)) {
            fprintf($this->output, $format, $coloredMsg);
        } else {
            fprintf($this->output, " %s \n", $coloredMsg);
        }
    }

    public function choice($introMsg, array $list, $repeat = null)
    {
        $opt = [];
        self::writeln($introMsg, 'yellow');
        foreach ($list as $i => $v) {
            array_push($opt,$i);
            self::writeColoredLn("[" . $i . "]:yellow " . $v . ":green");
        }
        if(empty($repeat)){
            self::ask("Your Choice ", '1', $opt);
        }else{
            $callback = (function($input){
                $i = (int) $input;
                if(isset($opt[$i])){
                    return true;
                }else{
                    return false;
                }
            });
            self::askAndValidata("Your Choice ", $callback, "input must be one of the choices", 3);
        }

    }

    public function writeColoredLn($line, $format = null)
    {
        $decoratedLine = "";
        $arr = explode(' ', $line);
        foreach ($arr as $txt) {
            $split = explode(':', $txt);
            $decoratedLine .= " " . $this->getColoredString($split[0], $split[1]);
        }
        $format = empty($format) ? "%s \n" : $format;
        $decoratedLine = rtrim($decoratedLine, " ");
        $this->writeln($decoratedLine, null, null, $format);
    }
} 