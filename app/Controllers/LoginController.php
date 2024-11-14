<?php

namespace App\Controllers;
use App\Models\UserModels;

class LoginController extends BaseController
{
    public function login()
    {
        $data = ['title' => 'Iniciar Sesión'];
        return view('session/login', $data);
    }

    public function authenticate()
    {

        $email = $this->request->getPost('email');  // Obtener el email desde el formulario
        $password = $this->request->getPost('password');  // Obtener la contraseña desde el formulario
        log_message('debug', 'Contraseña: ' . print_r($password, true));
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        log_message('debug', 'Contraseña: ' . print_r($hashedPassword, true));


        // Crear una instancia del modelo UserModel
        $userModel = new UserModels();
        $user = $userModel->getUserByEmail($email);  // Obtener el usuario por email
        log_message('debug', 'Usuario obtenido: ' . print_r($user, true));

        if ($user && password_verify($password, $user['CONTRASENIA'])) {
            // Si el usuario existe y la contraseña es correcta (asegúrate de usar `password_verify`)
            
            // Aquí puedes guardar la sesión del usuario si usas sesiones
            session()->set('user_id', $user['ID_USUARIO']);  // Usar el nombre correcto de la columna
            return redirect()->to('/inicio');  // Redirigir a la página de inicio
        } else {
            // Si las credenciales son incorrectas, redirigir al login con un mensaje de error
            return redirect()->to('/login')->with('error', 'Credenciales incorrectas');
        }
    }



}
