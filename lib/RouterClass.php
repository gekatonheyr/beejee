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

    public function __construct($uri, $settings)
    {
        $this->uri = urldecode(trim($uri, '/'));

        $routes = $settings['routes'];
        $this->route = $settings['default_route'];
        $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
        $this->controller =$settings['default_controller'];
        $this->action = $settings['default_action'];

        $path_parts = explode('?', $this->uri);

        if (in_array(strtolower(current($path_parts)), array_keys($routes))) {
            $this->route = strtolower(current($path_parts));
            $this->method_prefix = isset($routes[$this->route]) ? $routes[$this->route] : '';
            array_shift($path_parts);
        }

        if (current($path_parts)) {
            $this->controller = strtolower(current($path_parts));
            array_shift($path_parts);
        }

        if (current($path_parts)){
            $this->action = strtolower(current($path_parts));
            array_shift($path_parts);
        }

        $this->params = $path_parts;
    }

}