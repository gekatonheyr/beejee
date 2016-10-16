<?php

class Database
{
    private $connection;

    public function __construct($settings)
    {
        if(!($this->connection = mysqli_connect($settings['db_host'], $settings['db_user'], $settings['db_password'], $settings['db_name']))){
            die("Can't establish connection. Reason: ".mysqli_connect_error());
        }
        $this->connection->query("set names {$settings['charset']}");
    }

    public function query($str)
    {
        if ( !$this->connection ){
            return false;
        }

        $result = $this->connection->query(mysqli_escape_string($str));

        if (mysqli_error($this->connection)){
            throw new Exception(mysqli_error($this->connection));
        }

        if (is_bool($result) ){
            return $result;
        }

        $returned_data = array();
        while($row = mysqli_fetch_assoc($result) ){
            $returned_data[] = $row;
        }
        return $returned_data;
    }
}