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
            log_message('debug', 'retorna false.');

            return false; 

        }

        try {
            $inserted = $this->insert($data);
          //  dd($data);

            if ($inserted) {
                return true;
            }
        } catch (\Exception $e) {
            log_message('error', 'Error al guardar el proyecto: ' . $e->getMessage());
        }

        return false;
    }

    public function getInvestmentsByUser($userId)
    {
        // aca hago el join de projectos con inversiones y me quedo con los 
        // projectos que correspondan al usuario de la sesion

        $builder = $this->db->table('inversiones');
        $builder->select('proyectos.*, inversiones.MONTO as monto_invertido, 
                         (SELECT SUM(MONTO) FROM inversiones 
                          WHERE ID_PROYECTO = proyectos.ID_PROYECTO) as monto_recaudado');
        $builder->join('proyectos', 'inversiones.ID_PROYECTO = proyectos.ID_PROYECTO');
        $builder->where('inversiones.ID_USUARIO', $userId);
        $query = $builder->get();
        $projects = $query->getResult();
    
        $categoryModel = new CategoryModel();
        foreach ($projects as $project) {
            // Añadimos las categorías a cada proyecto
            $project->categoria_nombre = $categoryModel->getCategory($project->ID_PROYECTO);
            // Calculamos el porcentaje de progreso
            $project->porcentaje_progreso = ($project->monto_recaudado / $project->PRESUPUESTO) * 100;
        }
    
        return $projects;
    }

    
}
