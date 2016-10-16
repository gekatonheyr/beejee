<?php

function __autoload($class_name){
    $lib_path = ROOT.DS.'lib'.DS.ucfirst(strtolower($class_name)).'Class.php';
    $controllers_path = ROOT.DS.'controllers'.DS.str_replace('controller', '', ucfirst(strtolower($class_name))).'Controller.php';
    $model_path = ROOT.DS.'models'.DS.ucfirst(strtolower($class_name)).'.php';

    if ( file_exists($lib_path) ){
        require_once($lib_path);
    } elseif ( file_exists($controllers_path) ){
        require_once($controllers_path);
    } elseif ( file_exists($model_path) ){
        require_once($model_path);
    } else {
        throw new Exception('Failed to include class: '.$class_name);
    }
}