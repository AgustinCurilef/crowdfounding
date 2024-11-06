<?php
namespace App\Models;

use CodeIgniter\Model;

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
        foreach ($projects as $project) {
            // Añadimos las categorías a cada proyecto
            $project->categoria_nombre = $this->getCategory($project->ID_PROYECTO);
        }
        
        return $projects;
    }
    public function getCategory($id) {
        $builder = $this->db->table('categorias');
        $builder->select('categorias.NOMBRE');
        $builder->join('proyecto_categoria', 'proyecto_categoria.ID_CATEGORIA = categorias.ID_CATEGORIA');
        $builder->where('proyecto_categoria.ID_PROYECTO', $id);
        $query = $builder->get();
    
        // Extraemos solo los nombres de las categorías en un arreglo plano
        $result = $query->getResult();
        $categoryNames = [];
        foreach ($result as $row) {
            $categoryNames[] = $row->NOMBRE;
        }
        return $categoryNames;
    }
}
