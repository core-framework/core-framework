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


/**
 * Class to handle the input output stream for the console commands
 *
 * @package Core\Console
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class IOStream extends ConsoleStyles
{
    /**
     * @var resource Input stream
     */
    protected static $input = STDIN;
    /**
     * @var resource Output stream
     */
    protected static $output = STDOUT;
    /**
     * @var resource Error stream
     */
    protected static $error = STDERR;
    /**
     * @var $argv mixed Global argv cli argument holder
     */
    protected static $argv;
    /**
     * @var int Number of times to repeat an output
     */
    private static $repeat;

    /**
     * @param null $argv
     */
    public function __construct($argv = null)
    {
        parent::__construct();

        if (is_null($argv)) {
            static::$argv = $_SERVER['argv'];
        } else {
            static::$argv = $argv;
        }
    }

    public function getArgv()
    {
        return static::$argv;
    }

    public function getStream($type)
    {
        if (isset(self::$$type))
            return self::$$type;
    }

    /**
     * Destructor for IOStream
     */
    public function __destruct()
    {
        fclose(static::$input);
        fclose(static::$output);
        fclose(static::$error);
    }

    /**
     * Takes msg as a parameter and validates and returns the input. Returns false if input is not valid
     *
     * @param $msg - The question or message
     * @param $callback - anonymous function to validate input. It should returns true if valid or false if not valid
     * @param $format - To prompt the user of the valid format.
     * @param null $default - default accepted value. if set and input is null then this value will be returned (qn or msg will not be repeated in this case)
     * @param int $repeat - The no. of times to ask the again, if input is invalid, before throwing an error
     * @return mixed - returns the input
     */
    public function askAndValidate($msg, $callback, $format, $default = null, $repeat = 2)
    {
        for ($i = $repeat; $i >= 0; $i--) {
            $resp = $this->ask($msg, $default);
            $valid = $callback($resp);
            static::$repeat = $repeat;

            if ($valid && $this::$repeat !== 0) {
                return $resp;
            } elseif (!$valid && static::$repeat !== 0 || (!$valid && static::$repeat !== 0 && empty($default))) {
                self::writeln("Sorry input must be " . $format, "yellow");
                continue;
            } elseif (!$valid && static::$repeat === 0 && !empty($default)) {
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

        return false;
    }

    /**
     * Outputs the given message and returns the value. If options ($opt) are set then its will return false if input value does not match one of the given options. Typically used for simple yes | no questions
     *
     * @param $message - The message to output or question to ask
     * @param null $default - The default value to return if input is null
     * @param null $options - The set of input options (input must match one of the options)
     * @return bool|string - returns the input value
     */
    public function ask($message, $default = null, $options = null)
    {
        if (!is_string($message)) {
            throw new \InvalidArgumentException("Message must be a string");
        }
        if (!is_null($default) && !is_string($default)) {
            throw new \InvalidArgumentException("default must be a string");
        }
        if (!is_null($options) && (!is_array($options) || count($options) > 2)) {
            throw new \InvalidArgumentException("option must be an array and not greater then length 2");
        }

        $coloredMsg = $this->getColoredString($message, 'green');

        if (!empty($options)) {
            fprintf(static::$output, "%s : [" . $options[0] . "/" . $options[1] . "] ", $coloredMsg);
        } elseif(!empty($default)) {
            fprintf(static::$output, "%s : [" . $default . "] ", $coloredMsg);
        } else {
            fprintf(static::$output, "%s : ", $coloredMsg);
        }

        $input = trim(fgets(static::$input), "\n");

        if (empty($input)) {
            return $default;
        }

        if (is_null($options)) {
            return $input;
        }

        if (strtolower($input) === strtolower($options[0]) || strtolower($input) === strtolower($options[1])) {
            return $input;
        } else {
            throw new \InvalidArgumentException("Input must be either {$options[0]} or {$options[1]}");
        }
    }

    /**
     * Prints error message with specific formatting
     *
     * @param $msg
     * @param $exception
     * @throws \ErrorException
     */
    public function showErr($msg, $exception = null)
    {
        $format = "\n%s\n\n";
        $lines = [];

        $lines[] = " ";
        if ($exception instanceof \Exception) {
            $lines[] = "[" . $exception->getCode() . "][" . get_class($exception) . "]";
        } elseif (!is_null($exception)) {
            $lines[] = "[" . (string) $exception . "]";
        }
        $lines[] = $msg;
        $lines[] = " ";

        $formattedLinesArr = $this->addPadding($lines, 5);
        $formattedLinesArr = $this->addPadding($formattedLinesArr, 5, STR_PAD_LEFT);
        $coloredLinesArr = $this->getColoredLines($formattedLinesArr, 'white', 'red', 'bold');
        $styledLines = implode(PHP_EOL, $coloredLinesArr);

        fprintf(static::$output, $format, $styledLines);

    }

    /**
     * Output text
     *
     * @param $text
     * @param null $foreColor
     * @param null $backColor
     * @param string $format
     */
    public function write($text, $foreColor = null, $backColor = null, $format = "%s")
    {
        $coloredMsg = $text;
        if (!empty($foreColor) || !empty($backColor)) {
            $coloredMsg = $this->getColoredString($text, $foreColor, $backColor);
        }

        if (!empty($format)) {
            print sprintf($format, $coloredMsg);
        } else {
            print sprintf("%s", $coloredMsg);
        }
    }

    /**
     * Outputs a single line
     *
     * @param $msg - message to output
     * @param null $foreColor - the text color
     * @param null $backColor - the background color
     * @param int $options - Display options like bold, underscore, blink, etc;
     */
    public function writeln($msg, $foreColor = null, $backColor = null, $options = null)
    {
        $coloredMsg = $msg;
        $format = "%s\n";

        if (!empty($foreColor) || !empty($backColor)) {
            $coloredMsg = $this->getColoredString($msg, $foreColor, $backColor, $options);
        }

        $formattedMsg = sprintf($format, $coloredMsg);

        fprintf(static::$output, $formattedMsg);
    }

    /**
     * For multiple choice based questions or messages
     *
     * @param $introMsg - the question or message to output
     * @param array $list - the list of choices to display
     * @param null $repeat - the no. of times to repeat the question
     * @return bool|mixed|string
     * @throws \ErrorException
     */
    public function choice($introMsg, array $list, $repeat = null)
    {
        $return = false;
        if (!is_string($introMsg)) {
            throw new \ErrorException("Argument introMsg must be a string");
        }
        if (!is_null($repeat) && !is_int($repeat)) {
            throw new \ErrorException("Argument repeat must be an integer");
        }

        $msg = "Your Choice No(s). (can be multiple comma separated Nos.)";
        $opt = [];
        $this->writeln($introMsg, 'yellow');
        foreach ($list as $i => $v) {
            array_push($opt, $i);
            $this->writeColoredLn("[" . $i . "]:yellow " . $v . ":green");
        }


        if (empty($repeat)) {

            $coloredMsg = $this->getColoredString('Your Choice :', 'green');
            fprintf(static::$output, "%s : [0-". (sizeof($list) - 1) ."]", $coloredMsg);

            $input = trim(fgets(static::$output), "\n");

            if (empty($input) && (int) $input !== 0) {
                $this->showErr("No option given exiting...");
                return false;
            }

        } else {
            $callback = (function ($input) {
                $i = (int)$input;
                if (isset($opt[$i])) {
                    return true;
                } else {
                    return false;
                }
            });
            $input = $this->askAndValidate($msg, $callback, "input must be one of the choices", $repeat);
        }

        if (strpos($input, ",")) {
            $return = explode(",", $input);
            foreach($return as $i => $v) {
                $return[$i] = (int) $v;
                if ((int) $v > sizeof($list) || (int) $v < 0) {
                    $this->showErr("Input value must be in range 0 - ".sizeof($list));
                    return false;
                }
            }
        } elseif (is_bool($input)) {
            $this->showErr('Invalid Input provided');
        } else {
            $return = (int) $input;
        }

        return $return;
    }

    /**
     * To output a multi-colored line. Each string to be colored must be a separate word (spaced string) and the color is determined buy the color specified by :color after string. Ex: 'some:green random:yellow string:red'
     *
     * @param $line - the message (with color specification) to output
     * @param null $format - the output format
     */
    public function writeColoredLn($line, $format = null)
    {
        $decoratedLine = "";
        $arr = explode(' ', $line);
        foreach ($arr as $txt) {
            //$split = explode(':', $txt);
            $split = preg_split('~\\\\.(*SKIP)(*FAIL)|\:~s', $txt);
            $split = str_replace('\:', ':', $split);
            $decoratedLine .= " " . $this->getColoredString($split[0], $split[1]);
        }
        $format = empty($format) ? "%s" . PHP_EOL : $format;
        $decoratedLine = rtrim($decoratedLine, " ");
        $this->writeln($decoratedLine, null, null, $format);
    }

} 
