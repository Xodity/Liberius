<?php

namespace Laramus\Liberius\Controllers;

/**
 * 
 * @extends parent<Controller>
 * 
 */
class HomeController extends Controller
{
    public function index()
    {
        /**
         * @param mixed
         */
        $this->view->render('index.rune.php');
    }

    public function about()
    {
        /**
         * @param mixed
         */
        $this->view->render('about.rune.php');
    }
}
