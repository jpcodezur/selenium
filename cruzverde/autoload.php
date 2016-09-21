<?php
require_once('../phpwebdriver' . DIRECTORY_SEPARATOR . 'WebDriver.php');
include_once 'cls/CheckList.php';

function __autoload($class){
    if(is_file("$class.php")){
        require_once("$class.php");
    }elseif(is_file("cls/$class.php")){
        require_once("cls/$class.php");
    }elseif(is_file("../cls/$class.php")){
        require_once("../cls/$class.php");
    }elseif(is_file("cruzverde/cls/$class.php")){
        require_once("cruzverde/cls/$class.php");
    }elseif(is_file(getcwd()."/cls/$class.php")){
        require_once(getcwd()."cruzverde/cls/$class.php");
    }
}