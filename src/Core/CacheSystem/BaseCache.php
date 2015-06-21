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

namespace Core\CacheSystem;


/**
 * Class BaseCache
 * @package Core\CacheSystem
 */
abstract class BaseCache
{
    /**
     * @param $key
     * @param $payload
     * @param $ttl
     * @return mixed
     */
    abstract public function cacheContent($key, $payload, $ttl);

    /**
     * @param $key
     * @return mixed
     */
    abstract public function getCache($key);

    /**
     * @param $key
     * @return mixed
     */
    abstract public function cacheExists($key);

    /**
     * @param $key
     * @return mixed
     */
    abstract public function deleteCache($key);

    /**
     * @return mixed
     */
    abstract public function clearCache();

    /**
     * Check if string is $key hash
     *
     * @param string $key
     * @return int
     */
    public function isValidMd5($key = '')
    {
        return preg_match('/^[a-f0-9_]{32}$/', $key);
    }
}