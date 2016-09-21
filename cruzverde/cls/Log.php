<?php

class Log{
    private $id;
    public static $instance;

    private function __construct(){}

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new Log();
            self::$instance->id = date("Y-m-d m:s:d");
            $style ='body{
                        width: 500px;
                        margin: 0 auto;
                        background-color: silver;
                        padding: 10px;
                        font-family: monospace;
                    }';

            file_put_contents('./log/'.self::$instance->id.'.html', $style, FILE_APPEND);
        }

        return self::$instance;
    }

    public function logInFile($text,$type="default"){


        $color = "black";

        if($type == "msg"){
            $color = "blue";
        }elseif($type == "msg"){
            $color = "blue";
        }elseif($type == "success"){
            $color = "green";
        }elseif($type == "error"){
            $color = "red";
        }elseif($type == "alert"){
            $color = "yellow";
        }

        $text = "<div style='color:".$color."'>".$text."</div>";
        file_put_contents('./log/'.$this->id.'.html', $text, FILE_APPEND);
    }
}