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
 * Class to handle color formatting of outputs on a console or command line
 *
 * @package Core\Console
 * @version $Revision$
 * @license http://creativecommons.org/licenses/by-sa/4.0/
 * @link http://coreframework.in
 * @author Shalom Sam <shalom.s@coreframework.in>
 */
class ConsoleStyles
{
    public static $availableForegroundColors = array(
        'black' => array('set' => 30, 'unset' => 39),
        'dark_gray' => array('set' => '1;30', 'unset' => 39),
        'light_gray' => array('set' => 37, 'unset' => 39),
        'red' => array('set' => 31, 'unset' => 39),
        'light_red' => array('set' => '1;31', 'unset' => 39),
        'green' => array('set' => 32, 'unset' => 39),
        'light_green' => array('set' => '1;32', 'unset' => 39),
        'yellow' => array('set' => 33, 'unset' => 39),
        'blue' => array('set' => 34, 'unset' => 39),
        'light_blue' => array('set' => '1;34', 'unset' => 39),
        'magenta' => array('set' => 35, 'unset' => 39),
        'light_magenta' => array('set' => '1;35', 'unset' => 39),
        'cyan' => array('set' => 36, 'unset' => 39),
        'light_cyan' => array('set' => '1;36', 'unset' => 39),
        'white' => array('set' => 37, 'unset' => 39),
        'default' => array('set' => 39, 'unset' => 39),
    );
    public static $availableBackgroundColors = array(
        'black' => array('set' => 40, 'unset' => 49),
        'red' => array('set' => 41, 'unset' => 49),
        'green' => array('set' => 42, 'unset' => 49),
        'yellow' => array('set' => 43, 'unset' => 49),
        'blue' => array('set' => 44, 'unset' => 49),
        'magenta' => array('set' => 45, 'unset' => 49),
        'cyan' => array('set' => 46, 'unset' => 49),
        'white' => array('set' => 47, 'unset' => 49),
        'default' => array('set' => 49, 'unset' => 49),
    );
    public static $availableOptions = array(
        'bold' => array('set' => 1, 'unset' => 22),
        'underscore' => array('set' => 4, 'unset' => 24),
        'blink' => array('set' => 5, 'unset' => 25),
        'reverse' => array('set' => 7, 'unset' => 27),
        'conceal' => array('set' => 8, 'unset' => 28),
    );

    /**
     * @var array An array of possible(pre defined) foreground colors
     */
    private $foreground_colors = array();
    /**
     * @var array An array of possibles(pre defined) background colors
     */
    private $background_colors = array();

    private $columns;

    /**
     * Class constructor
     */
    public function __construct()
    {

    }

    /**
     * Returns the colored (and padded) string
     *
     * @param $string
     * @param null $foreground_color
     * @param null $background_color
     * @param int $options
     * @return string
     */
    public function getColoredString($string, $foreground_color = null, $background_color = null, $options = null)
    {
        $setCodes = array();
        $unsetCodes = array();

        // Check if given foreground color found
        if ($foreground_color !== null && isset(static::$availableForegroundColors[$foreground_color])) {
            $setCodes[] = static::$availableForegroundColors[$foreground_color]['set'];
            $unsetCodes[] = static::$availableForegroundColors[$foreground_color]['unset'];
        } elseif ($foreground_color !== null && !isset(static::$availableForegroundColors[$foreground_color])) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid foreground color specified: "%s". Expected one of (%s)',
                $foreground_color,
                implode(', ', array_keys(static::$availableForegroundColors))
            ));
        }

        // Check if given background color found
        if ($background_color !== null && isset(static::$availableBackgroundColors[$background_color])) {
            $setCodes[] = static::$availableBackgroundColors[$background_color]['set'];
            $unsetCodes[] = static::$availableBackgroundColors[$background_color]['unset'];
        } elseif ($background_color !== null && !isset(static::$availableBackgroundColors[$background_color])) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid background color specified: "%s". Expected one of (%s)',
                $background_color,
                implode(', ', array_keys(static::$availableBackgroundColors))
            ));
        }

        // Check if given option is available
        if ($options !== null && isset(static::$availableOptions[$options])) {
            $setCodes[] = static::$availableOptions[$options]['set'];
            $unsetCodes[] = static::$availableOptions[$options]['unset'];
        } elseif ($options !== null && !isset(static::$availableOptions[$options])) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid option specified: "%s". Expected one of (%s)',
                $options,
                implode(', ', array_keys(static::$availableOptions))
            ));
        }

        if (0 === count($setCodes)) {
            return $string;
        }

        return sprintf("\033[%sm%s\033[%sm", implode(';', $setCodes), $string, implode(';', $unsetCodes));
    }

    public function getColoredLines($lines, $foreColor, $backColor, $options)
    {
        foreach($lines as $i => &$line) {
            $line = $this->getColoredString($line, $foreColor, $backColor, $options);
        }

        return $lines;
    }

    /**
     * Returns all foreground color names
     *
     * @return array
     */
    public function getForegroundColors()
    {
        return array_keys($this->foreground_colors);
    }

    /**
     * Returns all background color names
     *
     * @return array
     */
    public function getBackgroundColors()
    {
        return array_keys($this->background_colors);
    }

    public function getMaxLength($lines, $paddingAmount = 10)
    {
        $padding = 0;
        if (is_array($lines)) {
            foreach ($lines as $i => $msg) {
                if (strlen($msg) > $padding) {
                    $padding = strlen($msg) + $paddingAmount;
                }
            }
        }
        return $padding;
    }

    public function addPadding($lines, $padding = 0, $direction = STR_PAD_RIGHT)
    {
        $strLenWPadding = $this->getMaxLength($lines, $padding);

        if (is_array($lines)) {
            foreach ($lines as $i => &$line) {
                $line = str_pad($line, $strLenWPadding, " ", $direction);
            }
        }

        return $lines;
    }

    public function getColumns()
    {
        if (!isset($this->columns)) {
            $this->columns = exec('/usr/bin/env tput cols');
        }
        return $this->columns;
    }
}
