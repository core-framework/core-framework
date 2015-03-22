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

namespace Core\Views;

/**
 * Interface viewInterface
 * @package Core\Views
 */
interface viewInterface {

    /**
     * Initiates view template Engine
     */
    public function init();

    /**
     * Assigns new public parameters with given value
     *
     * @param $var
     * @param $val
     */
    public function set($var, $val);

    /**
     * Loads the debug html with data to be displayed
     *
     * @param $bool
     */
    public function setDebugMode($bool);

    /**
     * Set Template directory
     *
     * @param $path
     */
    public function addTemplateDir($path);

    /**
     * Set template variables
     *
     * @param $var
     * @param $val
     */
    public function setTemplateVars($var, $val);

    /**
     * Set template file to render
     *
     * @param $tpl
     */
    public function setTemplate($tpl);

    /**
     * Set header of http response
     *
     * @param $val
     */
    public function setHeader($val);

    /**
     * Disables the view render method
     */
    public function disable();

    /**
     * Renders the final html output
     *
     * @return bool
     */
    public function render();

}