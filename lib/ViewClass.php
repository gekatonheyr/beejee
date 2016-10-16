<?php

class View
{
    private $data;
    private $view_path;

    public function getDefaultViewPath($router)
    {
        if(!$router){
            throw new Exception("You have not created router object yet.");
        }
        $controller_dir = $router->getController();
        $template_name = $router->getMethodPrefix().$router->getAction().'.html';

        return VIEWS_PATH.DS.$controller_dir.DS.$template_name;
    }

    public function __construct($router, $data=array(), $view_path = null)
    {
        if(!$router){
            throw new Exception("You have not created router object yet.");
        }

        if(!$view_path){
            $view_path = $this->getDefaultViewPath($router);
        }
        if ( !file_exists($view_path) ){
            throw new Exception('Template file is not found in path: '.$view_path);
        }
        $this->view_path = $view_path;
        $this->data = $data;
    }

    public function render(){
        $data = $this->data;
        $content = array();

        ob_start();
        include($this->view_path);
        $content['body'] = ob_get_clean();
        foreach($data as $key=>$value){
            $content[$key] = $value;
        }

        return $content;
    }
}