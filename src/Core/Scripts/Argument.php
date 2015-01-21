<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 07/01/15
 * Time: 8:05 PM
 */

namespace Core\Scripts;


/**
 * Class Argument
 * @package Core\Scripts
 */
class Argument {

    /**
     * @var
     */
    protected $name;
    /**
     * @var
     */
    protected $required;
    /**
     * @var
     */
    protected $description;

    /**
     * Argument constructor
     *
     * @param $name
     * @param $required
     * @param null $description
     */
    function __construct($name, $required = true, $description = null)
    {
        $this->name = $name;
        $this->required = $required;
        $this->description = $description;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * @param mixed $required
     */
    public function setRequired($required)
    {
        $this->required = $required;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }


}