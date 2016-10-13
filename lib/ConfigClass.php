<?php

class Config
{
    private $settings = array();

    /**
     * Config constructor.
     * @param string $config_filename
     */
    public function __construct($config_filename)
    {
        $config_handle = fopen('..'.DS.'config'.DS.'config', 'w');
        if(!$config_handle){
            die("Can't open config file. Terminating script.");
        }

        while(!feof($config_handle)){
            $param_string = fgets($config_handle);
            if($param_string == ''){
                continue;
            }

            $param_array = explode(':', $param_string);
            if(count($param_array) != 2){
                die("Something is wrong with parameters in config file. Check it please by path: ../config/$config_filename");
            }
            $this->setSetting($param_array[0], $param_array[1]);
        }
    }

    /**
     * @return string
     */
    public function getSetting($key)
    {
        return isset($this->settings[$key]) ? $this->settings[$key] : null;
    }

    /**
     * @params string $key, $value
     * @return mixed
     */
    public function setSetting($key, $value)
    {
        if(array_key_exists($key, $this->settings) || in_array($value, $this->settings)){
            die("Something trying to set parameter '$key' which already set to '$value'. Please contact developer to fix this.");
        }
        $key_type = gettype($key);
        $value_type = gettype($value);
        if($key_type != 'string' || $value_type != 'string'){
            die("Parameters and their values has to be string type, but the given one has: {$key_type} for key and {$value_type} for value.
                Please contact developer to fix this.");
        }
        $this->settings[$key] = $value;
        return $this;
    }
}