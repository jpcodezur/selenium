<?php
include_once 'config.php';
require_once('../phpwebdriver' . DIRECTORY_SEPARATOR . 'WebDriver.php');
include_once 'cls/CheckList.php';

function __autoload($class){

    $isDir = false;
    $path = "";
    if(is_file("$class.php")){
        $isDir = true;
        $path = "$class.php";
        require_once("$class.php");

    }elseif(is_file("cls/$class.php")){
        $isDir = true;
        $path ="cls/$class.php";
        require_once("cls/$class.php");

    }elseif(is_file("../cls/$class.php")){
        $isDir = true;
        $path ="../cls/$class.php";
        require_once("../cls/$class.php");

    }elseif(is_file("cruzverde/cls/$class.php")){
        $isDir = true;
        $path ="cruzverde/cls/$class.php";
        require_once("cruzverde/cls/$class.php");

    }elseif(is_file(getcwd()."/cls/$class.php")){
        $isDir = true;
        $path =getcwd()."/cls/$class.php";
        require_once(getcwd()."cruzverde/cls/$class.php");
    }

    echo "isDir: $isDir, cwd: ".getcwd().", class: ".$class.", path: ".$path." \n";
    //

}