<?php
namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class RegisterController extends BaseController {

    // Mostrar el formulario de registro
    public function register() {
        $data = ['title' => 'Formulario de Registro'];
        helper('form');
        return view('session/register', $data);
    }

    // Guardar el nuevo usuario
    public function store() {
        // Obtener los datos del formulario
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('correo');  // Asegúrate de que el nombre sea 'correo'
        $nombre = $this->request->getPost('nombre');
        $apellido = $this->request->getPost('apellido');
        $contrasenia = $this->request->getPost('contrasenia');
        $confirm_contrasenia = $this->request->getPost('contrasenia2');  // Confirmación de contraseña
        $terminos = $this->request->getPost('terminos'); //check de términos y condiciones

        // Validación de contraseñas
        if ($contrasenia !== $confirm_contrasenia) {
            return redirect()->back()->with('error', 'Las contraseñas no coinciden');
        }

        // Validación de aceptación de términos y condiciones
        if (!$terminos) {
            return redirect()->back()->with('error', 'Debe aceptar los términos y condiciones');
        }

        // Cargar el modelo de usuarios
        $userModel = new UserModel();

        // Verificar si el username ya existe
        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->with('error', 'El nombre de usuario ya está en uso.');
        }

        // Verificar si el correo electrónico ya existe
        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->with('error', 'El correo electrónico ya está en uso.');
        }

        // Cifrar la contraseña
        $hashedPassword = password_hash($contrasenia, PASSWORD_DEFAULT);

        // Crear el array de datos
        $data = [
            'username' => $username,
            'email' => $email,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'contrasenia' => $hashedPassword,
        ];

        // Guardar el nuevo usuario en la base de datos
        $userModel->save($data);

        // Redirigir a la página de login con un mensaje de éxito
        return redirect()->to('/login')->with('success', 'Registro exitoso');
    }
}
