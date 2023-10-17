<?php

namespace Laramus\Liberius\Controllers;

use Laramus\Liberius\Models\User;

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
        // $datas = User::query("SELECT * FROM users")->resultSet();

        // $datas = User::create([
        //     "email" => "testing@gmaial.com",
        //     "password" => "XII PPLG 2"
        // ]);

        // $data = User::update(11, [
        //     "email" => "ridho1@gmail.com",
        //     "password" => 123
        // ]);

        // $data = User::find(2);
        // $data = User::find(2, [ "email", "password" ]);

        // $data = User::delete(11);

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
