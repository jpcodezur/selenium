<?php

class Config{
    public static $instance;
    private $config;

    public function getConfig(){
        return $this->config;
    }

    private function __construct(){
        $this->config = include "config/params.php";
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new Config();
        }

        return self::$instance;
    }

}