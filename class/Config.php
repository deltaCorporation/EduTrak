<?php

/*
 * Config class
 */

class Config{
    /*
     * Static function get() | return config value from ini file
     */
    public static function get($path = null){
        if($path){
            $config = $GLOBALS['config'];
            $path = explode('/', $path);

            foreach ($path as $bit) {
                if (isset($config[$bit])) {
                    $config = $config[$bit];
                }
            }
            return $config;
        }
    }
}

