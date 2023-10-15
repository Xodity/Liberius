<?php

namespace Laramus\Liberius\Controllers;

use Laramus\Liberius\Ancient\Flasher;

/**
 * BaseController
 * 
 * This is base class for all controllers
 */
class Controller
{
    public $flasher;

    public function __construct()
    {
        $this->flasher = new Flasher;
    }

    public function view($viewName, $data = [])
    {
        
        if(strpos($viewName, ".")) {
            $viewName = str_replace(".", "/", $viewName);
        }
        $flasher = $this->flasher;

        require_once __DIR__ . '/../../rune/' . $viewName . '.' .'rune.php';
    }

    public function redirect($route)
    {
        header("Location: " . $route);
        return $this->flasher;
    }

    public function hash($value)
    {
        return password_hash($value, PASSWORD_BCRYPT);
    }

    public function hash_check($value, $hash)
    {
        return password_verify($value, $hash);
    }
}