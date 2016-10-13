<?php

class Router
{
    private $route;
    private $controller;
    private $action;
    private $params;
    private $method_prefix;

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getMethodPrefix()
    {
        return $this->method_prefix;
    }

    public function __construct($uri, Config $config)
    {
        $this->uri = urldecode(trim($uri, '/'));

        $routes = $config->getSetting('routes');
        $this->route = $config->getSetting('default_route');
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->language = $config->getSetting('default_language');
        $this->controller =$config->getSetting('default_controller');
        $this->action = $config->getSetting('default_action');

        $uri_parts = explode('?', $this->uri);

    }
}