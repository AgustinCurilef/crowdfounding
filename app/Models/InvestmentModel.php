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
        'FECHA' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'ID_PROYECTO' => [
            'required' => 'El proyecto es obligatorio',
            'numeric' => 'El ID del proyecto debe ser un número'
        ],
        'ID_USUARIO' => [
            'required' => 'El usuario es obligatorio',
            'numeric' => 'El ID del usuario debe ser un número'
        ],
        'MONTO' => [
            'required' => 'El monto es obligatorio',
            'numeric' => 'El monto debe ser un número',
            'greater_than' => 'El monto debe ser mayor a 0'
        ],
        'ESTADO' => [
            'required' => 'El estado es obligatorio'
        ],
        'FECHA' => [
            'required' => 'La fecha es obligatoria',
            'valid_date' => 'La fecha debe tener un formato válido'
        ]
    ];

    public function findComposite($ID_PROYECTO, $ID_USUARIO)
    {
        return $this->where([
            'ID_PROYECTO' => $ID_PROYECTO,
            'ID_USUARIO' => $ID_USUARIO
        ])->first();
    }

    public function deleteComposite($ID_PROYECTO, $ID_USUARIO)
    {
        return $this->where([
            'ID_PROYECTO' => $ID_PROYECTO,
            'ID_USUARIO' => $ID_USUARIO
        ])->delete();
    }

    public function insert($data = null, bool $returnID = true)
    {
        if (is_array($data) && isset($data['ID_PROYECTO'], $data['ID_USUARIO'])) {
            $exists = $this->findComposite($data['ID_PROYECTO'], $data['ID_USUARIO']);
            if ($exists) {
                return false;
            }
        }
        return parent::insert($data, $returnID);
    }
}
