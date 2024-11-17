<?php
namespace App\Models;

use CodeIgniter\Model;

class InvestmentModel extends Model
{
    protected $table = 'inversiones';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['ID_PROYECTO', 'ID_USUARIO', 'MONTO', 'ESTADO', 'FECHA'];
    protected $useTimestamps = false;
    
    protected $validationRules = [
        'ID_PROYECTO' => 'required|numeric',
        'ID_USUARIO' => 'required|numeric',
        'MONTO' => 'required|numeric|greater_than[0]',
        'ESTADO' => 'required',
     
    ];

    public function findComposite($ID_PROYECTO, $ID_USUARIO)
    {
        return $this->where([
            'ID_PROYECTO' => $ID_PROYECTO,
            'ID_USUARIO' => $ID_USUARIO
        ])->first();
    }

    public function saveInvestment($data)
    {
        // Intentar insertar directamente
        $result = $this->db->table($this->table)->insert($data);
        
        // Verificar si la inserción fue exitosa
        if ($result) {
            return $this->db->insertID();
        }
        
        return false;
    }

    public function insert($data = null, bool $returnID = true)
    {
        // Si los datos son válidos, proceder con la inserción
        if ($this->validate($data)) {
            // Usar el método insert de la clase padre
            $result = parent::insert($data, $returnID);
            
            // Si la inserción fue exitosa y queremos el ID
            if ($result !== false && $returnID) {
                return $this->getInsertID();
            }
            
            // Si la inserción fue exitosa pero no queremos el ID
            if ($result !== false) {
                return true;
            }
        }
        
        // Si la validación falló o la inserción falló
        return false;
    }
}