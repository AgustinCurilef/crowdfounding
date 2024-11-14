<?php

namespace App\Controllers;

class UserController extends BaseController
{
    public function index():String
    {
      // Obtener el ID de usuario de la sesión
      $userId = session()->get('user_id');

      // Aquí deberías usar el modelo para obtener el nombre del usuario desde la base de datos
      // Suponiendo que tienes un modelo de usuario que puede obtener el nombre basado en el ID del usuario.
      $userModel = new \App\Models\UserModels();
      $user = $userModel->find($userId);

      // Pasar los datos del usuario a la vista
      $data = [
          'title' => 'Home',
          'user_name' => $user['USERNAME'], // Asegúrate de usar el campo correcto de tu base de datos
      ];

      // Pasar los datos a las vistas
      return view('estructura/header', $data)
          .view('estructura/navbar', $data)
          .view('estructura/sidebar', $data)
          .view('estructura/main', $data)
          .view('estructura/footer', $data);
  }
}
