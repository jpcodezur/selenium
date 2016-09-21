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
        $mantis = self::getMantisId();
        Base::log("START TESTING MANTIS $mantis","msg");
    }

    public static function end($status){
        $mantis = self::getMantisId();
        if(!$status){
            Base::log("ERROR MANTIS $mantis","error");
        }

        Base::log("MANTIS $mantis END SUCCESS","success");
    }

    public static function getMantisId(){
        return substr(debug_backtrace()[1]['function'],4,strlen(debug_backtrace()[1]['function']));
    }

    public function chk_284492(){
        $status = false;
        self::start();

        $docType = "CE";
        $docNumber = "7856289347";

        $status = $this->base->loginAdmin();
        $this->base->redirect("loginCustomer");

        //Check if is admin loggedIn
        $status = $this->base->isAdminLoginSuccess();

        //Login as customer
        $this->base->webdriver->findElementBy(LocatorStrategy::cssSelector, '#email')->sendKeys(array($docNumber));
        $this->base->webdriver->findElementBy(LocatorStrategy::cssSelector, '#send2')->click();

        sleep(5);

        $registerDocNumber = $this->base->webdriver->findElementBy(LocatorStrategy::cssSelector, '#document_number')->getText();
        if($registerDocNumber == $docNumber){
            $status = true;
        }

        self::end($status);
    }

}