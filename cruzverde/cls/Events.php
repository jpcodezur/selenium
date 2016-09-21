<?php

class Events extends Base{

    public static $instance;


    public function __construct(){
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if(!self::$instance){
            self::$instance = new Events();
        }
        return self::$instance;
    }

    public function goToUrl($webDriver,$pUrl,$scope = "frontend"){
        $webDriver->get(Config::getInstance()->getConfig()["base_url"] . Config::getInstance()->getConfig()["urls"][$scope][$pUrl]);
        sleep(5);
    }

}