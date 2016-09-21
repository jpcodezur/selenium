<?php

class CheckList extends Base {


    public static function runTests(){
        $instance = new CheckList();
    }

    public function test_284492(){
        $this->loginAdmin();
        $this->webdriver->get("http://192.168.240.97:85/customer/account/create/");

        //$isLoggedIn = $this->webdriver->findElementBy(LocatorStrategy::cssSelector, 'body > div.wrapper > div > header > div > div.header_top > div > div.welcome-cc-msg')->getText();
    }

}