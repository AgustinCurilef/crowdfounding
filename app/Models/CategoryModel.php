<?php
namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table      = 'categorias';
    protected $primaryKey = 'ID_CATEGORIA';

    protected $useAutoIncrement = true;

    protected $returnType     =  'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['NOMBRE', 'DESCRIPCION'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;


    
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