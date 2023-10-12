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
        $this->view->render('index');
    }

    public function about($id)
    {
        /**
         * @param mixed
         */
        $this->view->render('about');
    }

    public function store($request) {
        var_dump($request);
    }

    public function update($request, $id) {
        var_dump($request);
    }
}
