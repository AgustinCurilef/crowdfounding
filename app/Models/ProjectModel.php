<?php
namespace App\Models;

use CodeIgniter\Model;
use App\Models\CategoryModel;

class ProjectModel extends Model
{
    protected $table      = 'proyectos';
    protected $primaryKey = 'ID_PROYECTO';

    protected $useAutoIncrement = true;

    protected $returnType     =  'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['NOMBRE', 'USERNAME_USUARIO','PRESUPUESTO','OBJETIVO','DESCRIPCION','FECHA_LIMITE','RECOMPENSAS','SITIO_WEB'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    public function getProjects() {
        $builder = $this->db->table('proyectos');
        $builder->select('proyectos.*');
        $query = $builder->get();
    
        $projects = $query->getResult();
         // Instanciamos CategoryModel
         $categoryModel = new CategoryModel();

        foreach ($projects as $project) {
            // Añadimos las categorías a cada proyecto
            $project->categoria_nombre = $categoryModel->getCategory($project->ID_PROYECTO);
        }
        
        return $projects;
    }

    public function setProject($data)
    {
        if (empty($data['NOMBRE']) || empty($data['USERNAME_USUARIO'])) {
            return false; 
        }

        try {
            $inserted = $this->insert($data);

            if ($inserted) {
                return true;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar el proyecto: ' . $e->getMessage());
        }

        return false;
    }

    
}
