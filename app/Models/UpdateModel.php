<?php

namespace App\Models;

use CodeIgniter\Model;

class UpdateModel extends Model
{
    protected $table      = 'actualizacion_proyecto';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['ID_PROYECTO ', 'ID_USUARIO', 'FECHA ', 'DESCRIPCION', 'NOMBRE_IMAGEN'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getUpdatesByProjectId($projectId)
    {
        return $this->where('ID_PROYECTO', $projectId)->findAll();
    }
    public function getImage($idProject, $idUser, $date)
    {
        $builder = $this->builder();
        $builder->select('NOMBRE_IMAGEN');
        $builder->where('ID_PROYECTO', $idProject)
            && $builder->where('ID_USUARIO', $idUser)
            && $builder->where('FECHA', $date);

        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $row = $query->getRow();
            return $row->NOMBRE_IMAGEN; // Devuelve el BLOB de la imagen
        }

        return null; // Si no se encuentra la imagen
    }
}
