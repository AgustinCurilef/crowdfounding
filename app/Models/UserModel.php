<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = ['username', 'email', 'nombre', 'apellido', 'contrasenia', 'fecha_nacimiento', 'nacionalidad', 'telefono', 'linkedin', 'foto_perfil'];

    // Método para obtener un usuario por su correo electrónico
    public function getUserByEmail($email)
    {
        return $this->db->table('usuarios')
                        ->select('ID_USUARIO, USERNAME, EMAIL, NOMBRE, APELLIDO, CONTRASENIA, FECHA_NACIMIENTO, NACIONALIDAD, LINKEDIN, TELEFONO') // Excluye FOTO_PERFIL
                        ->where('email', $email)
                        ->get()
                        ->getRowArray();
    }

    public function getImage($idUsuario)
    {
        $builder = $this->builder();
        $builder->select('foto_perfil');
        $builder->where('id_usuario', $idUsuario);
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->foto_perfil; // Devuelve el BLOB de la imagen
        }

        return null; // Si no se encuentra la imagen
    }

    public function usernameExists(string $username, int $excludeId = null): bool
    {
        $query = $this->where('username', $username);

        if ($excludeId !== null) {
            $query->where('id_usuario !=', $excludeId);
        }

        return $query->countAllResults() > 0;
    }
}

