<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'usuarios';
    protected $allowedFields = ['username', 'email', 'nombre', 'apellido', 'contrasenia'];

     // Método para obtener un usuario por su correo electrónico
     public function getUserByEmail($email)
     {
         return $this->where('email', $email)->first();  // Devuelve el primer usuario con ese correo
     }
}

