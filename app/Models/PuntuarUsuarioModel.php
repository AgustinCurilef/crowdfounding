
<?php

namespace App\Models;

use CodeIgniter\Model;


class PuntuarUsuarioModel extends Model
{
    protected $table = 'puntuar_usuario';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID_USUARIO_PUNTUADOR', 'ID_USUARIO_PUNTUADO', 'PUNTAJE'];
}
