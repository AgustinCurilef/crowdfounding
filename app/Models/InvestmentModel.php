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
            return true;
        }

        return false;
    }

    public function updateStatusInvestment($estado, $idProyecto)
    {
        // Verificar si el estado es válido (opcional)
        $estadosValidos = ['Pendiente', 'Pagado', 'Cancelado']; // Definir los estados permitidos
        if (!in_array($estado, $estadosValidos)) {
            return false; // Si el estado no es válido, retorna false
        }

        // Realizar la actualización de estado en todas las inversiones relacionadas con el ID_PROYECTO
        $result = $this->db->table('inversiones') // Asumiendo que la tabla de inversiones se llama 'inversiones'
            ->set('estado', $estado) // Establecer el nuevo estado
            ->where('ID_PROYECTO', $idProyecto) // Filtrar por el ID_PROYECTO
            ->update(); // Ejecutar la actualización
    }
    public function investmentsProject($idProyecto)
    {
        $result = $this->db->table('inversiones') // Asumiendo que la tabla de inversiones se llama 'inversiones'
            ->select('ID_USUARIO')
            ->distinct() // Asegura que los IDs de usuario sean únicos
            ->where('ID_PROYECTO', $idProyecto) // Filtrar por el ID_PROYECTO 
            ->get(); // Ejecutar la consulta

        if ($result->getNumRows() > 0) {
            // Retorna los resultados como un arreglo
            return $result->getResultArray();
        } else {
            // Retorna un arreglo vacío si no hay resultados
            return [];
        }
    }
}
