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


/**
 * Class to handle the input output stream for the console commands
 *
 * @package Core\Scripts
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class IOStream extends cmdcolors
{
    /**
     * @var resource Input stream
     */
    protected $input;
    /**
     * @var resource Output stream
     */
    protected $output;
    /**
     * @var resource Error stream
     */
    protected $error;
    /**
     * @var int Number of times to repeat an output
     */
    private $repeat;

    /**
     * Constructor for IOStream
     */
    public function __construct()
    {
        parent::__construct();
        $this->input = fopen('php://stdin', 'r');
        $this->output = fopen('php://output', 'w');
        $this->error = fopen('php://stderr', 'w');
    }

    /**
     * Destructor for IOStream
     */
    public function __destruct()
    {
        fclose($this->input);
        fclose($this->output);
        fclose($this->error);
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

    /**
     * Outputs the given message and returns the value. If options ($opt) are set then its will return false if input value does not match one of the given options. Typically used for simple yes | no questions
     *
     * @param $msg - The message to output or question to ask
     * @param null $default - The default value to return if input is null
     * @param null $opt - The set of input options (input must match one of the options)
     * @return bool|string - returns the input value
     */
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
                return false;
            } else {
                return false;
            }
        } else {
            return $input;
        }
    }

    /**
     * Prints error message with specific formatting
     *
     * @param $msg - error message to display
     */
    public function showErr($msg)
    {
        $coloredMsg = $this->getColoredString($msg, 'white', 'red');
        fprintf($this->output, PHP_EOL."%20.40s".PHP_EOL, $coloredMsg);
    }

    /**
     * Outputs a single line
     *
     * @param $msg - message to output
     * @param null $foreColor - the text color
     * @param null $backColor - the background color
     * @param null $format - text output format
     */
    public function writeln($msg, $foreColor = null, $backColor = null, $format = null)
    {
        $coloredMsg = $msg;

        if (!empty($foreColor)) {
            $coloredMsg = $this->getColoredString($msg, $foreColor, $backColor);
        }

        if (!empty($format)) {
            fprintf($this->output, $format, $coloredMsg);
        } else {
            fprintf($this->output, "%s".PHP_EOL, $coloredMsg);
        }
    }

    /**
     * For multiple choice based questions or messages
     *
     * @param $introMsg - the question or message to output
     * @param array $list - the list of choices to display
     * @param null $repeat - the no. of times to repeat the question
     */
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
            $split = explode(':', $txt);
            $decoratedLine .= " " . $this->getColoredString($split[0], $split[1]);
        }
        $format = empty($format) ? "%s".PHP_EOL : $format;
        $decoratedLine = rtrim($decoratedLine, " ");
        $this->writeln($decoratedLine, null, null, $format);
    }
} 