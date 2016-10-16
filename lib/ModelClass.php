<?php

class Model
{
    protected $db;

    public function __construct($app)
    {
        $this->db = $app->getDb();
    }
}