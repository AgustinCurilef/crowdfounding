<?php

namespace App\Controllers;

class LoginController extends BaseController
{
    public function login():String
    {
        $data = ['title' => 'Iniciar Sesión'];
        return view('session/login', $data);
    }

    public function register():String
    {
        $data = ['title' => 'Formulario de Registro'];
        return view('session/register', $data);
    }

}
