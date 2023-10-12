<?php

namespace Laramus\Liberius\Controllers;

/**
 * BaseController
 * 
 * This is base class for all controllers
 */
class Controller
{
    protected $view;

    /**
     * Constructor class for Controller.
     */
    public function __construct()
    {
        $this->view = new View();
    }
}

/**
 * View
 * 
 * this is class for rendering rune.php views 
 */
class View
{
    /**
     * Render template based on name file.
     *
     * @param string $viewName name file to render; defaults to $viewName
     */
    public function render($viewName, $data = [])
    {
        require_once __DIR__ . '/../../rune/' . $viewName . '.' .'rune.php';
    }
}
