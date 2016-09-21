<?php

class CheckList {

    private $base;

    public function __construct()
    {
        $this->base = new Base();
    }

    public static function runTests(){
        $instance = new CheckList();
        $instance->chk_284492();
        die();
    }

    public static function start(){
        $mantis = substr(debug_backtrace()[1]['function'],4,strlen(debug_backtrace()[1]['function']));
        Base::log("START TESTING MANTIS $mantis","msg");
    }

    public static function end($status){
        $mantis = substr(debug_backtrace()[1]['function'],4,strlen(debug_backtrace()[1]['function']));

        if(!isset($status["message_type"])){
            $status["message_type"] = "error";
        }

        if($status["error"]){
            Base::log($status["message"],$status["message_type"]);
        }

        if(!$status["error"]){
            if(in_array($status["message_type"],Config::getInstance()->getConfig()["log_level"])){
                Base::log($status["message"],$status["message_type"]);
            }

            Base::log("MANTIS $mantis END SUCCESS","success");
        }

    }

    public function chk_284492(){
        self::start();

        $docType = "CE";
        $docNumber = "7856289347";

        $status = $this->base->loginAdmin();
        $this->base->redirect("loginCustomer");

        //Check if is admin loggedIn
        $status = $this->base->isAdminLoginSuccess();

        if($status["error"] == false) {

            //Login as customer
            $this->base->webdriver->findElementBy(LocatorStrategy::cssSelector, '#email')->sendKeys(array($docNumber));
            $this->base->webdriver->findElementBy(LocatorStrategy::cssSelector, '#send2')->click();

            sleep(5);

            $registerDocNumber = $this->base->webdriver->findElementBy(LocatorStrategy::cssSelector, '#document_number')->getText();
            if ($registerDocNumber == $docNumber) {
                $status = array(
                    "message" => "LOGIN DOCUMENT NUMBER AND REGISTER DOCUMENT MATCHS",
                    "error" => false
                );
            }
        }

        self::end($status);
    }

}