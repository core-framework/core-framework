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
 * Class DI
 * @package Core\DI
 */
class DI
{
    /**
     * @var array Array of service objects definitions
     */
    protected $services = [];
    /**
     * @var array Array of shared service instances
     */
    protected $sharedInstances = [];

    /**
     * Method to register services
     *
     * @param $name
     * @param $definition
     * @param bool $shared
     * @return mixed
     * @throws \ErrorException
     */
    public function register($name, $definition, $shared = true)
    {
        if (!is_string($name)) {
            throw new \ErrorException("Service name must be a valid string.");
        }

        if (!is_bool($shared)) {
            throw new \ErrorException("Inncorrect parameter type.");
        }

        $this->services[$name] = new Service($name, $definition, $shared);

        return $this->services[$name];
    }


    /**
     * Returns if service is shared or not
     *
     * @param $name
     * @param $shared
     * @return mixed
     * @throws \ErrorException
     */
    public function setShared($name, $shared)
    {
        if (!$this->services[$name]) {
            throw new \ErrorException("Service must be registered first.");
        }

        $this->services[$name]->setShared($shared);

        return $this->services[$name];
    }

    /**
     * Set service implementation definition
     *
     * @param $name
     * @param $definition
     * @return mixed
     * @throws \ErrorException
     */
    public function setDefinition($name, $definition)
    {
        if (!$this->services[$name]) {
            throw new \ErrorException("Service must be registered first.");
        }

        $this->services[$name]->setDefinition($definition);

        return $this->services[$name];
    }

    /**
     * Lazy load the given service object
     *
     * @param $name
     * @return object
     * @throws \ErrorException
     */
    public function get($name)
    {
        if (!is_string($name)) {
            throw new \ErrorException("Service name must be a valid string");
        }

        if (!$this->serviceExists($name)) {
            throw new \ErrorException("Service of type $name not found. Service $name must be registered before use.");
        }

        $definition = $this->services[$name]->getDefinition();
        $arguments = $this->services[$name]->getArguments();
        $shared = $this->services[$name]->getShared();

        if (!empty($this->sharedInstances[$name]) && $shared === true) {
            return $this->sharedInstances[$name];
        }

        if ($definition instanceof \Closure) {

            if ($shared) {
                $this->sharedInstances[$name] = $definition();
                return $this->sharedInstances[$name];
            }

            return $definition();

        } elseif (is_object($definition)) {

            if ($shared) {
                $this->sharedInstances[$name] = $definition;
                return $this->sharedInstances[$name];
            }
            return $definition;

        } elseif (is_string($definition) && class_exists($definition)) {

            $r = new \ReflectionClass($definition);

            if (is_null($arguments)) {

                if ($shared) {
                    $this->sharedInstances[$name] = $r->newInstance();
                    return $this->sharedInstances[$name];
                }

                return $r->newInstance();

            } else {

                $arguments = $this->checkIfIsDependent($arguments);

                if ($shared) {
                    $this->sharedInstances[$name] = $r->newInstanceArgs($arguments);
                    return $this->sharedInstances[$name];
                }

                return $r->newInstanceArgs($arguments);

            }
        } else {
            throw new \ErrorException(
                "Definition must either be a namespaced class or a Closure returning an object or a namespaced class."
            );
        }


    }


    /**
     * Return true if given service exists, else false
     *
     * @param $name
     * @return bool
     */
    public function serviceExists($name)
    {
        return !empty($this->services[$name]) ? true : false;
    }


    /**
     * Checks and returns dependencies passed as argument
     *
     * @param $arguments
     * @return array
     * @throws \ErrorException
     */
    public function checkIfIsDependent($arguments)
    {
        if (!is_array($arguments)) {
            throw new \ErrorException("Argument(s) must be an Array.");
        }

        if (empty($arguments)) {
            throw new \ErrorException("Argument(s) cannot be empty.");
        }

        $returnArguments = [];

        foreach ($arguments as $key => $val) {
            if (is_string($val) && (class_exists($val) || $this->serviceExists($val))) {
                $returnArguments[] = $this->get($val);
            } else {
                $returnArguments[] = $val;
            }
        }

        return $returnArguments;

    }

    /**
     * Magic sleep method for serialization
     *
     * @return array
     */
    public function __sleep()
    {
        return ['sharedInstances'];
    }

}

