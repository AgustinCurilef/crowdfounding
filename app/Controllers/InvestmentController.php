<?php

namespace App\Controllers;

use App\Models\InvestmentModel;
use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\NotificationUserModel;
use DateTime; // Añade esta línea


class InvestmentController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        $this->user = [
            'ID_USUARIO' => session()->get('ID_USUARIO'),
            'USERNAME' => session()->get('USERNAME'),
        ];

        // Inicializa el modelo de usuario una sola vez en el constructor $this->user = session()->get();

    }
    protected function checkSession()
    {
        if (!session()->get('ID_USUARIO')) {
            return redirect()->to('/login')->send(); // `send` detiene la ejecución
        }
    }

    public function index(): String
    {
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories = $categoryModel->findAll();



        $data = [
            'notificationsUser' => $notificationsUser,
            'title' => 'Mis Inversiones',
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => session()->get('USERNAME')
        ];

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('investment', $data)
            . view('estructura/footer');
    }
    public function create($ID_PROYECTO)
    {
        $this->checkSession(); // Verifica la sesión
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $projectModel = new ProjectModel();
        $project = $projectModel->find($ID_PROYECTO);

        if (!$project) {
            return redirect()->to('/inicio')
                ->with('error', 'Proyecto no encontrado');
        }

        $data = [
            'notificationsUser' => $notificationsUser,
            'title' => 'Realizar Inversión',
            'project' => $project,
            'user_name' => session()->get('USERNAME')

        ];

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('investment/makeInvestment', $data)
            . view('estructura/footer');
    }

    public function save()
    {
        $this->checkSession();

        $investmentModel = new InvestmentModel();
        $projectModel = new ProjectModel();

        $ID_PROYECTO = $this->request->getPost('id_proyecto');
        $MONTO = $this->request->getPost('monto');


        if ($MONTO <= 0) {
            return redirect()->to('/investment/create/' . $ID_PROYECTO)
                ->with('error', 'El monto debe ser mayor a 0');
        }

        // Obtener información del proyecto - MOVIDO ANTES DE SU USO
        $project = $projectModel->find($ID_PROYECTO);

        // Calcular el total recaudado hasta ahora
        $totalRecaudado = $projectModel->getAmountInvestmentsByProject($ID_PROYECTO);

        // Sumar la nueva inversión
        $totalRecaudado += $MONTO;

        // Determinar el estado de la inversión
        $fechaActual = new DateTime();
        $fechaLimite = new DateTime($project->FECHA_LIMITE); // Ahora $project ya está definido

        if ($totalRecaudado >= $project->PRESUPUESTO) {
            $estado = 'Pagado';
        } elseif ($fechaActual > $fechaLimite) {
            $estado = 'Cancelado';
        } else {
            $estado = 'Pendiente';
        }


        $data = [
            'ID_PROYECTO' => $ID_PROYECTO,
            'ID_USUARIO' => session()->get('ID_USUARIO'),
            'MONTO' => $MONTO,
            'FECHA' => date('Y-m-d H:i:s'),
            'ESTADO' => $estado,


        ];

        //////////
        // Guardar la inversión
        if ($investmentModel->saveInvestment($data)) {

            // Crear notificación para el dueño del proyecto
            $notificationUserController = new NotificationUserController();
            $notificationUserController->createInvestmentNotification($project);

            $mensaje = 'Inversión registrada exitosamente';
            if ($estado === 'Pagado') {
                $mensaje .= '. El proyecto alcanzó su meta y la inversión ha sido marcada como pagada.';
                $investmentModel->updateStatusInvestment($estado, $ID_PROYECTO);
            } elseif ($estado === 'Cancelado') {
                $mensaje .= '. El proyecto no alcanzó su meta y la inversión ha sido cancelada.';
                $investmentModel->updateStatusInvestment($estado, $ID_PROYECTO);
            }
            return redirect()->to('/investment/create/' . $ID_PROYECTO)
                ->with('mensaje', $mensaje);
        } else {
            // Captura el error exacto
            $errors = $investmentModel->errors();
            $dbError = $investmentModel->db->error();

            return redirect()->to('/investment/create/' . $ID_PROYECTO)
                ->with('error', 'Error al registrar la inversión: '
                    . $data['ID_PROYECTO'] . $data['ID_USUARIO'] . $data['MONTO'] . $data['FECHA'] . $data['ESTADO']
                    . ' - ' . json_encode($dbError));
        }
    }
}
