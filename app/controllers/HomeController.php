<?php

namespace Laramus\Liberius\Controllers;

use Laramus\Liberius\Ancient\Flasher;

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
        $this->view('index');
    }

    public function about($id)
    {
        /**
         * @param mixed
         */
        // $this->view('about');
        $this->redirect('/')->setFlash("msg_success", "Berhasil menambahkan data");
    }

    public function store($request) {
        var_dump($request);
    }

    public function update($request, $id) {
        var_dump($request);
    }
}
