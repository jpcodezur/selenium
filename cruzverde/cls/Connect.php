<?php

class Connect{

    public static $instance;
    private $mysqli;

    private function __construct(){
        $this->mysqli = new Mysqli();
    }

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new Connect();
        }

        return self::$instance;
    }

    public function query($query){

    }

}