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
        if(file_exists($config_filename) and is_readable($config_filename)){
            $config_handle = fopen($config_filename, "r");
        }
        if(!$config_handle){
            throw new Exception("Can't open config.cfg file. Terminating script.");
        }

        while(!feof($config_handle)){
            $param_string = trim(fgets($config_handle));

            if($param_string == ''){
                continue;
            }

            $param_array = explode('::', $param_string);
            if(count($param_array) != 2){
                die("Something is wrong with parameters in config.cfg file. Check it please by path: $config_filename");
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
        if(array_key_exists($key, $this->settings)){
            die("Something trying to set parameter '$key' which already set to '$value'. Please contact developer to fix this.");
        }
        $key_type = gettype($key);
        $value_type = gettype($value);
        if($key_type != 'string' || $value_type != 'string'){
            die("Parameters and their values has to be string type, but the given one has: {$key_type} for key and {$value_type} for value.
                Please contact developer to fix this.");
        }
        if(str_replace(array("{","}"), '', $value) != $value){
            $value_array = json_decode($value, true);
            $this->settings[$key] = $value_array;
            return $this;
        }
        $this->settings[$key] = $value;
        return $this;
    }

    /**
     * @return array
     */
    public function getAllSettings()
    {
        return $this->settings;
    }
}