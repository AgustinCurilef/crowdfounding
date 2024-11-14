<?php

namespace App\Controllers;

class LoginController extends BaseController
{
    public function login():String
    {
        $data = ['title' => 'Iniciar Sesión'];
        return view('session/login', $data);
    }

}
