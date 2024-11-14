<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'usuarios';
    protected $allowedFields = ['username', 'email', 'nombre', 'apellido', 'contrasenia'];
}

