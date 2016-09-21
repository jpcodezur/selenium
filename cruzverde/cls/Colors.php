<?php

const CLI_BLACK = '0;30';
const CLI_GRAY = '1;30';
const CLI_BLUE = '0;34';
const CLI_LIGHT_BLUE = '1;34';
const CLI_GREEN = '0;32';
const CLI_LIGHT_GREEN = '1;32';
const CLI_CYAN = '0;36';
const CLI_LIGHT_CYAN = '1;36';
const CLI_RED = '0;31';
const CLI_LIGHT_RED = '1;31';
const CLI_PURPLE = '0;35';
const CLI_LIGHT_PURPLE = '1;35';
const CLI_BROWN = '0;33';
const CLI_YELLOW = '1;33';
const CLI_LIGHT_GRAY = '0;37';
const CLI_WHITE = '1;37';

const BACKGROUND_BLACK = '40';
const BACKGROUND_RED = '41';
const BACKGROUND_GREEN = '42';
const BACKGROUND_YELLOW = '43';
const BACKGROUND_BLUE = '44';
const BACKGROUND_MAGENTO = '45';
const BACKGROUND_CYAN = '46';
const BACKGROUND_LIGHT_GRAY = '47';

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