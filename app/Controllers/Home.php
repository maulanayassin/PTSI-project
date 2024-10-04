<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    public function phpinfo(){
        $session = session();
        $session->set('username', 'YsSIN');
        echo $session->get('username');
        // echo phpinfo();
    }
}
