<?php

namespace App\Controllers;

use App\Models\UserModel;

class LoginController extends BaseController
{
    public function login()
    {
        $data = ['title' => 'Iniciar Sesión'];
        return view('session/login', $data);
    }

    public function unauthorized()
    {
        return view('session/unauthorized');
    }

    public function authenticate()
    {

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        // Crear una instancia del modelo UserModel
        $userModel = new UserModel();
        $user = $userModel->getUserByEmail($email);  // Obtener el usuario por email

        if ($user && password_verify($password, $user['CONTRASENIA'])) {
            // Si el usuario existe y la contraseña es correcta (asegúrate de usar `password_verify`)
            session()->set($user);
            return redirect()->to('/inicio');
        } else {
            return redirect()->to('/login')->with('error', 'Credenciales incorrectas');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }
}
