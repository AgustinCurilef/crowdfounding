<?php
namespace App\Controllers;
use App\Models\InvestmentModel;
use App\Models\ProjectModel;

class InvestmentController extends BaseController
{
    public function create()
    {
        // Cargar el modelo de proyectos para obtener la lista
        $projectModel = new ProjectModel();
        
        $data = [
            'title' => 'Realizar Inversión',
            'proyectos' => $projectModel->findAll()
        ];
        
        return view('estructura/header', $data)
            . view('estructura/navbar')
            . view('estructura/sidebar')
            . view('investment/makeInvestment', $data)
            . view('estructura/footer');
    }
    
    public function save()
    {
        $investmentModel = new InvestmentModel();
        
        // Obtener el ID del usuario de la sesión
        $idUsuario = session()->get('id_usuario'); // Ajusta esto según tu manejo de sesión
        
        // Preparar los datos
        $data = [
            'ID_PROYECTO' => $this->request->getPost('id_proyecto'),
            'ID_USUARIO' => $idUsuario,
            'MONTO' => $this->request->getPost('monto'),
            'ESTADO' => 'Pendiente',
            'FECHA' => date('Y-m-d') // Fecha actual
        ];
        
        // Validaciones
        if (empty($data['ID_PROYECTO']) || empty($data['MONTO'])) {
            return redirect()->to('/investment/create')
                           ->with('error', 'Todos los campos son obligatorios');
        }
        
        if ($data['MONTO'] <= 0) {
            return redirect()->to('/investment/create')
                           ->with('error', 'El monto debe ser mayor a 0');
        }
        
        // Guardar la inversión
        if ($investmentModel->insert($data)) {
            return redirect()->to('/investment')
                           ->with('mensaje', 'Inversión registrada exitosamente');
        } else {
            return redirect()->to('/investment/create')
                           ->with('error', 'Error al registrar la inversión');
        }
    }
}