<?php

namespace Core\Console;

class Options
{

    protected $name;
    protected $shortName;
    protected $description;
    protected $definition;
    protected $isRequired;

    /**
     * @param $name
     * @param null $shortName
     * @param null $description
     * @param null $definition
     * @param null|bool $isRequired Permitted values are null|true|false null=no value, false=has value but not required & true=has value and required
     * @throws \ErrorException
     */
    function __construct($name, $shortName = null, $description = null, $definition = null, $isRequired = null)
    {
        if (!is_string($name) || empty($name)) {
            throw new \ErrorException("Parameter name must be a valid string");
        }
        if (!is_null($shortName) && (!is_string($shortName) || empty($shortName))) {
            throw new \ErrorException("Parameter shortName must be a valid string");
        }
        if (!is_null($description) && (!is_string($description) || empty($description))) {
            throw new \ErrorException("Parameter description must be a valid string");
        }
        if (!is_null($definition) && (!is_callable($definition) && !($definition instanceof \Closure))) {
            throw new \ErrorException("Parameter definition must be a callable string or Closure");
        }
        if (!is_null($isRequired) && !is_bool($isRequired)) {
            throw new \ErrorException("Parameter isRequired must be either null|true|false.");
        }

        $this->name = $name;
        $this->shortName = $shortName;
        $this->description = $description;
        $this->definition = $definition;
        $this->isRequired = $isRequired;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * @param $shortName
     * @return $this
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * @param mixed $definition
     */
    public function setDefinition($definition)
    {
        $this->definition = $definition;
    }

    /**
     * @return mixed
     */
    public function getIsRequired()
    {
        return $this->isRequired;
    }

    /**
     * @param mixed $isRequired
     */
    public function setIsRequired($isRequired)
    {
        $this->isRequired = $isRequired;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        if ($this->isRequired === null) {
            return "";
        } elseif ($this->isRequired === true) {
            return Command::REQUIRED;
        } else {
            return Command::OPTIONAL;
        }
    }

}