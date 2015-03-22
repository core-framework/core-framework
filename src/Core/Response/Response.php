<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @package Aura.Web
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Core\Response;

class BasesResponse
{

    protected $cache;

    protected $content;

    protected $cookies;

    protected $headers;

    protected $redirect;

    protected $status;

    public function __construct($status, $headers, $cookies, $content, $cache, $redirect)
    {
        $this->status = $status;
        $this->headers = $headers;
        $this->cookies = $cookies;
        $this->content = $content;
        $this->cache = $cache;
        $this->redirect = $redirect;
    }

    /**
     *
     * Read-only access to property objects.
     *
     * @param string $key The name of the property object to read.
     *
     * @return mixed The property object.
     *
     */
    public function __get($key)
    {
        return $this->$key;
    }
}