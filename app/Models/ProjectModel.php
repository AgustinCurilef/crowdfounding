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

    protected $allowedFields = ['NOMBRE', 'USERNAME_USUARIO','PRESUPUESTO','OBJETIVO','DESCRIPCION','FECHA_LIMITE','RECOMPENSAS','SITIO_WEB','ESTADO'];

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
    public function getProject($id) {
        $builder = $this->db->table('proyectos');
        $builder->select('proyectos.*');
        $builder->join('usuarios', 'proyectos.USERNAME_USUARIO = usuarios.USERNAME');

        $builder->where('proyectos.USERNAME_USUARIO', $id);
        $query = $builder->get();
    
        $projects = $query->getResult();
         // Instanciamos CategoryModel
         $categoryModel = new CategoryModel();

        foreach ($projects as $project) {
            // Añadimos las categorías a cada proyecto
            $project->categoria_nombre = $categoryModel->getCategory($project->ID_PROYECTO);
            $project->monto_recaudado = $this->getAmountInvestmentsByProject($project->ID_PROYECTO);
        }
        
        return $projects;
    }
    
    public function getAmountInvestmentsByProject($idProject)
    {
        $builder = $this->db->table('inversiones');
        $builder->select('SUM(inversiones.MONTO) as monto_recaudado');
        $builder->where('inversiones.ID_PROYECTO', $idProject);
        $query = $builder->get();
    
        // Obtener el resultado
        $result = $query->getRow(); // Obtiene una fila única en lugar de un arreglo
    
        // Verificar y retornar el monto recaudado o 0 si está vacío
        return $result && $result->monto_recaudado !== null ? (float)$result->monto_recaudado : 0;
    }
    

    public function setProject($data)
{
    if (empty($data['NOMBRE']) || empty($data['USERNAME_USUARIO'])) {
        log_message('debug', 'Faltan datos obligatorios. Retornando false.');
        return false;
    }

    try {
        $data['ESTADO'] = (int) ($data['ESTADO'] ?? 0);
        // Insertar el proyecto en la tabla principal
        $inserted = $this->insert($data);

        if ($inserted) {
            // Obtener el ID del proyecto recién insertado
            $projectId = $this->insertID();

            // Preparar los datos para la tabla intermedia 'proyecto_categoria'
            if (!empty($data['CATEGORIAS']) && is_array($data['CATEGORIAS'])) {
                $proyectoCategoriaData = [];
                foreach ($data['CATEGORIAS'] as $categoryId) {
                    $proyectoCategoriaData[] = [
                        'ID_PROYECTO' => $projectId,
                        'ID_CATEGORIA' => $categoryId
                    ];
                }

                // Insertar múltiples filas en la tabla intermedia 'proyecto_categoria'
                $this->db->table('proyecto_categoria')->insertBatch($proyectoCategoriaData);
            }

            // Si todo fue exitoso, retornar true
            return true;
        }
    } catch (\Exception $e) {
        log_message('error', 'Error al guardar el proyecto o en la tabla intermedia: ' . $e->getMessage());
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


    public function getProjectById($id)
{
    // Construimos la consulta para obtener un proyecto por su ID
    $builder = $this->db->table('proyectos');
    $builder->select('proyectos.*, proyecto_categoria.ID_CATEGORIA, categorias.nombre AS categoria_nombre');
    $builder->join('proyecto_categoria', 'proyectos.ID_PROYECTO = proyecto_categoria.ID_PROYECTO', 'left');
    $builder->join('categorias', 'proyecto_categoria.ID_CATEGORIA = categorias.ID_CATEGORIA', 'left');
    $builder->where('proyectos.ID_PROYECTO', $id); // Filtramos por el ID del proyecto
    $query = $builder->get();
    
    // Retornamos el proyecto encontrado, o null si no existe
    return $query->getRow(); // getRow() devuelve un solo resultado (objeto)
}


public function updateProject($data)
{
    if (empty($data['NOMBRE']) || empty($data['USERNAME_USUARIO'])) {
        log_message('debug', 'Faltan datos obligatorios. Retornando false.');
        return false;
    }

    try {
        // Obtener el ID del proyecto
        $id = $data['ID_PROYECTO'];

        // Actualizar el proyecto en la tabla principal
        $updated = $this->update($id, $data);

        if ($updated) {
            // Eliminar las categorías actuales asociadas con el proyecto
            $this->db->table('proyecto_categoria')->where('ID_PROYECTO', $id)->delete();

            // Verificar si 'CATEGORIAS' existe en los datos y es un arreglo
            if (isset($data['CATEGORIAS']) && is_array($data['CATEGORIAS']) && !empty($data['CATEGORIAS'])) {
                // Preparar los datos para la tabla intermedia 'proyecto_categoria'
                $proyectoCategoriaData = [];
                foreach ($data['CATEGORIAS'] as $categoryId) {
                    $proyectoCategoriaData[] = [
                        'ID_PROYECTO' => $id,
                        'ID_CATEGORIA' => $categoryId
                    ];
                }

                // Insertar múltiples filas en la tabla intermedia 'proyecto_categoria'
                $this->db->table('proyecto_categoria')->insertBatch($proyectoCategoriaData);
            }

            // Si la actualización fue exitosa, retornar true
            return true;
        }

    } catch (\Exception $e) {
        log_message('error', 'Error al actualizar el proyecto o en la tabla intermedia: ' . $e->getMessage());
    }

    return false;
}




public function deleteProject($id)
{
    try {
        // Usamos el método delete del modelo base de CodeIgniter
        if ($this->delete($id)) {
            return true; // Éxito en la eliminación
        }
    } catch (\Exception $e) {
        // Si ocurre una excepción, registramos el error
        log_message('error', 'Error al eliminar el proyecto con ID ' . $id . ': ' . $e->getMessage());
    }

    return false; // Si algo falla, devolvemos false
}


    
}
