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

use Core\DI\DI;

define('_SRC_DIR', "src");
define('_CORE', _ROOT . DS . _SRC_DIR . DS . "Core");
define('DS', DIRECTORY_SEPARATOR);

$loader = require_once _ROOT . DS . "vendor" . DS . "autoload.php";


$di = new DI();
$di->register('Cache', '\\Core\\CacheSystem\\Cache');
$di->register('Config', '\\Core\\Config\\Config');
$di->register('Helper', '\\Core\\Helper\\Helper');
$di->register('Request', '\\Core\\Request\\Request');
$di->register('Route', '\\Core\\Routes\\Routes')
    ->setArguments(array('Request', 'Config'));
$di->register('View', '\\Core\\Views\\View')
    ->setArguments(array('Smarty'));
$di->register('Smarty', '\\Smarty')
    ->setDefinition(function(){
            return new Smarty();
        });
