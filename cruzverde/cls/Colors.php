<?php

class Colors {

    public static $instance;

    public static function getInstance(){
        if(!self::$instance){
            self::$instance = new Colors();
        }

        return self::$instance;
    }

    private function __construct() {}

    // Returns colored string
    public function getColoredString($string, $foreground_color = null, $background_color = null) {
        $colored_string = "";

        if($foreground_color){
            $colored_string .= "\033[" . $foreground_color . "m";
        }

        if($background_color) {
            $colored_string .= "\033[" . $background_color . "m";
        }

        // Add string and end coloring
        $colored_string .=  $string . "\033[0m";

        return $colored_string;
    }

    // Returns all foreground color names
    public function getForegroundColors() {
        return array_keys($this->foreground_colors);
    }

    // Returns all background color names
    public function getBackgroundColors() {
        return array_keys($this->background_colors);
    }
}

/*
 *
 $colors = new Colors();

 // Test some basic printing with Colors class
Base::log("aaasdasd","msg");
Base::log("aaasdasd","alert");
Base::log("aaasdasd","error");
Base::log("aaasdasd","success");
 */