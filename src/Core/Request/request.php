<?php
/**
 * Created by PhpStorm.
 * User: shalom.s
 * Date: 05/09/14
 * Time: 8:32 AM
 */

namespace Core\Request;


class request
{
    private $path;
    private $method;
    private $getVars;
    private $postVars;
    private $server;
    private $cookies;
    private $illegal = [
        '$',
        '*',
        '"',
        '\'',
        '<',
        '>',
        '^',
        '(',
        ')',
        '[',
        ']',
        '\\',
        '/',
        '!',
        '~',
        '`',
        '{',
        '}',
        '|',
        '%',
        '+',
        '-',
        '?php'
    ];
    private $devMode = false;


    public function __construct($devMode = false)
    {
        $this->devMode = $devMode;
        $this->getServerRequest();
    }

    private function getServerRequest()
    {
        //get method
        $this->method = $_SERVER['REQUEST_METHOD'] ? strtolower($_SERVER['REQUEST_METHOD']) : strtolower(
            $_SERVER['HTTP_X_HTTP_METHOD']
        );
        if (empty($this->method)) {
            $this->method = "get";
        }

        //get POST vars && GET vars sanitized
        foreach ($_GET as $key => $value) {
            //$getVars[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_STRING));
            switch ($key) {
                case 'email':
                    $this->getVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_EMAIL));
                    break;

                case 'phone':
                case 'mobile':
                    $this->getVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_NUMBER_INT));
                    break;

                default:
                    $this->getVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_STRING));
                    break;
            }
        }

        foreach ($_POST as $key => $value) {
            //$postVars[$key] = htmlentities(filter_var($val, FILTER_SANITIZE_STRING));
            switch ($key) {
                case 'email':
                    $this->postVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_EMAIL));
                    break;

                case 'phone':
                case 'mobile':
                    $this->postVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_NUMBER_INT));
                    break;

                default:
                    $this->postVars[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_STRING));
                    break;
            }
        }

        foreach ($_SERVER as $key => $value) {
            $this->server[$key] = $value;
        }

        foreach ($_COOKIE as $key => $value) {
            $this->cookies[$key] = htmlentities(filter_var($value, FILTER_SANITIZE_STRING));
        }

        //path
        str_replace($this->illegal, '', $this->getVars['page']);
        $this->path = isset($this->getVars['page']) && $this->getVars['page'] != 'index.php' ? htmlentities(
            filter_var($_GET['page'], FILTER_SANITIZE_URL)
        ) : '';

    }


    public function getServer()
    {
        return $this->server;
    }

    public function getCookies()
    {
        return $this->cookies;
    }

    public function getRqstMethod()
    {
        return $this->method;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getGetVars()
    {
        return $this->getVars;
    }

    public function getPostVars()
    {
        return $this->postVars;
    }

} 