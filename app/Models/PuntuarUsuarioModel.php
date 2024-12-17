<?php
namespace App\Models;

use CodeIgniter\Model;


class PuntuarUsuarioModel extends Model
{
    protected $table = 'puntuar_usuario';
    protected $primaryKey = 'ID_PUNTUACION';
    protected $allowedFields = ['ID_USUARIO_PUNTUADOR', 'ID_USUARIO_PUNTUADO', 'PUNTAJE'];



    public function calculateStatistics($puntuado) {
    $query = $this
        ->select('ROUND(AVG(PUNTAJE), 1) as promedio, COUNT(*) as totalVotos')
        ->where('ID_USUARIO_PUNTUADO', $puntuado)
        ->get();
    return $query->getRowArray();
    }

    public function getVote($puntuado, $puntuador) {
        $query = $this
            ->select('PUNTAJE')
            ->where('ID_USUARIO_PUNTUADO', $puntuado)
            ->where('ID_USUARIO_PUNTUADOR', $puntuador)
            ->get();
        return $query->getRowArray();
    }

    public function upsert($data)
    {
        // Verificar si ya existe un registro con la clave primaria compuesta
        $existing = $this
        ->select('ID_PUNTUACION')
        ->where('ID_USUARIO_PUNTUADOR', $data['ID_USUARIO_PUNTUADOR'])
        ->where('ID_USUARIO_PUNTUADO', $data['ID_USUARIO_PUNTUADO'])
        ->first();
        
        if (empty($existing['ID_PUNTUACION'])) {
            // Si no existe, insertar
            if ($this->insert($data)) {
                return [
                    'success' => true,
                    'message' => 'Puntuación registrada correctamente.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al registrar la puntuación.'
                ];
            }
        } 
        else {
            // Si existe, actualizar
            if ($this->update($existing['ID_PUNTUACION'], ['PUNTAJE' => $data['PUNTAJE']])){
                return [
                    'success' => true,
                    'message' => 'Puntuación actualizada correctamente.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar la puntuación.'
                ];
            }
        } 
    }

}


