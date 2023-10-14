<?php

namespace Laramus\Liberius\Ancient;

class Flasher {
    public static function setFlash($key, $message) {
        $_SESSION['flash'] = [
            "key" => $key,
            "message" => $message
        ];
    }   

    public static function has ($key) 
    {
        if( isset($_SESSION['flash']) ) return $key === $_SESSION['flash']['key'];
    }

    public static function get ($key)
    {
        echo $key === $_SESSION['flash']['key'] ? $_SESSION['flash']['message'] : null;
        unset($_SESSION['flash']);
    }
}