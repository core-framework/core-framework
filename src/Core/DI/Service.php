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

namespace Core\DI;

/**
 * Class Service
 * @package Core\DI
 */
class Service implements serviceInterface
{
    /**
     * @var string Service name
     */
    protected $name;
    /**
     * @var \Closure|string Service definition
     */
    protected $definition;
    /**
     * @var mixed Arguments to passed to definition
     */
    protected $arguments;
    /**
     * @var string Method to for class instantiation, if it is different from default constructor method
     */
    protected $method;
    /**
     * @var mixed Arguments to be passed to the given method
     */
    protected $methodArgs;
    /**
     * @var bool If service instance is shared
     */
    protected $shared;


    /**
     * Creates a service instance with the given params
     *
     * @param string $name
     * @param \Closure|string $definition
     * @param bool $shared
     * @throws \ErrorException
     */
    public function __construct($name, $definition, $shared = false)
    {
        if (!is_string($name)) {
            throw new \ErrorException("name must be a valid string.");
        }

        $this->name = $name;
        $this->definition = $definition;
        $this->shared = $shared;
    }

    /**
     * Returns the definition of the service
     *
     * @return callable|string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Sets the definition of the service
     *
     * @param mixed $definition
     */
    public function setDefinition($definition)
    {
        $this->definition = $definition;
    }

    /**
     * Returns whether service instance is shared
     *
     * @return bool
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * Sets whether service instances are shared
     *
     * @param bool $bool
     * @throws \ErrorException
     */
    public function setShared($bool)
    {
        if (!is_bool($bool)) {
            throw new \ErrorException("Argument provided must be a boolean value.");
        }

        $this->shared = $bool;
    }

    /**
     * Returns the previously set service arguments
     *
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * Sets arguments to be passed to service constructor
     *
     * @param array $args
     */
    public function setArguments(array $args)
    {
        $this->arguments = $args;
    }

    /**
     * Returns the method set for the service
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Sets the method for class instantiation
     *
     * @param string $method
     * @throws \ErrorException
     */
    public function setMethod($method)
    {
        if (!is_string($method)) {
            throw new \ErrorException("Method name must be of type string.");
        }
        $this->method = $method;
    }

    /**
     * Returns the set method arguments
     *
     * @return mixed
     */
    public function getMethodArgs()
    {
        return $this->methodArgs;
    }

    /**
     * Sets the method arguments
     *
     * @param mixed $methodArgs
     */
    public function setMethodArgs($methodArgs)
    {
        $this->methodArgs = $methodArgs;
    }

} 
