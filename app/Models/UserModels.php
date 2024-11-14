<?php
namespace App\Models;

use CodeIgniter\Model;

class UserModels extends Model
{
    protected $table = 'usuarios';  // Asegúrate de que esta sea la tabla correcta en tu base de datos
    protected $primaryKey = 'ID_USUARIO';
    protected $allowedFields = ['email', 'CONTRASENIA'];  // Agrega los campos necesarios

    // Método para obtener un usuario por su correo electrónico
    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();  // Devuelve el primer usuario con ese correo
    }
}
