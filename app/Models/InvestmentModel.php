<?php
namespace App\Models;
use CodeIgniter\Model;

class InvestmentModel extends Model
{
    protected $table = 'inversiones';
    protected $primaryKey = ['ID_PROYECTO', 'ID_USUARIO'];
    protected $useAutoIncrement = false;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = ['ID_PROYECTO', 'ID_USUARIO', 'MONTO', 'ESTADO', 'FECHA'];
    
    protected $useTimestamps = false;
    
    // Validación
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
            'numeric' => 'ID de proyecto inválido'
        ],
        'MONTO' => [
            'required' => 'El monto es obligatorio',
            'numeric' => 'El monto debe ser un número',
            'greater_than' => 'El monto debe ser mayor a 0'
        ]
    ];
}