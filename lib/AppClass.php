<?php
class App{
    private $router;
    private $db;

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param mixed $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param mixed $db
     */
    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    public function handle($uri)
    {
        $configuration = new Config(ROOT.DS.'config'.DS.'config.cfg');
        $settings = $configuration->getAllSettings();
        $this->router = new Router($uri, $settings);
        $this->db = new Database($settings);

        $controller_class = ucfirst($this->router->getController()).'Controller';
        $controller_method = strtolower($this->router->getMethodPrefix().$this->router->getAction());

        $layout = $this->router->getRoute();

        $controller_object = new $controller_class($this->router->getParams());
        if(method_exists($controller_object, $controller_method)){
            $view_path = $controller_object->$controller_method($this->router->getParams());
            $view_object = new View($this->router, $controller_object->getData(), $view_path);
            $content = $view_object->render();
        } else {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.' does not exist.');
        }

        $layout_path = VIEWS_PATH.DS.$layout.'.html';
        $layout_view_object = new View($this->router, compact('content'), $layout_path);
        $tmp = $layout_view_object->render();
        echo $tmp['body'];
    }
}