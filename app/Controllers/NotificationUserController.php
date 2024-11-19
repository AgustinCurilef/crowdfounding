<?php
namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\NotificationUserModel;
use App\Models\UserModel; 


class NotificationUserController extends BaseController
{
    protected $user;
    protected $notificationModel;
    protected $notificationUserModel;
    protected $userModel; // Añadimos la propiedad

    public function __construct()
    {
        $this->user = [
            'ID_USUARIO' => session()->get('ID_USUARIO'),
            'USERNAME' => session()->get('USERNAME'),
        ];
        $this->notificationModel = new NotificationModel();
        $this->notificationUserModel = new NotificationUserModel();
        $this->userModel = new UserModel(); // Inicializamos el modelo
    }

    public function createInvestmentNotification($projectData, $amount)
    {
        // Primero obtenemos el ID_USUARIO a partir del USERNAME
        $usuario = $this->userModel->where('USERNAME', $projectData->USERNAME_USUARIO)
                                 ->first();
        
        if (!$usuario) {
            // Si no encontramos el usuario, registramos el error y retornamos
            log_message('error', 'No se encontró el usuario con USERNAME: ' . $projectData->USERNAME_USUARIO);
            return false;
        }

        // Crear la notificación
        $notificationData = [
            'NOMBRE' => 'Nueva Inversión',
            'DESCRIPCION' => "Has recibido una nueva inversión de $" . $amount . " en tu proyecto '" . $projectData->NOMBRE . "'"
        ];

        $notificationId = $this->notificationModel->insert($notificationData);

        // Asignar la notificación al dueño del proyecto usando su ID_USUARIO
        if ($notificationId) {
            $this->notificationUserModel->addUserNotification(
            $notificationId,
            $usuario['ID_USUARIO'] // Usamos el índice en lugar de la notación de objeto
            );
        }

        return $notificationId;
    }

    public function index()
    {
        if (!session()->get('ID_USUARIO')) {
            return redirect()->to('/login');
        }

        $notifications = $this->notificationUserModel->getUserNotifications($this->user['ID_USUARIO']);
        
        $data = [
            'title' => 'Mis Notificaciones',
            'notifications' => $notifications,
            'user_name' => $this->user['USERNAME']
        ];

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('user/userNotifications', $data)  // Actualizar la ruta de la vista
            . view('estructura/footer');
    }

    public function getUnreadCount()
    {
        if (!session()->get('ID_USUARIO')) {
            return $this->response->setJSON(['count' => 0]);
        }

        $count = $this->notificationUserModel->getUnreadCount($this->user['ID_USUARIO']);
        return $this->response->setJSON(['count' => $count]);
    }

    public function markAsRead($id)
    {
        if (!session()->get('ID_USUARIO')) {
            return $this->response->setJSON(['success' => false]);
        }

        $success = $this->notificationUserModel->markAsRead($id, $this->user['ID_USUARIO']);
        return $this->response->setJSON(['success' => $success]);
    }

    public function recent()
    {
        if (!session()->get('ID_USUARIO')) {
            return $this->response->setJSON([]);
        }

        $notifications = $this->notificationUserModel->getRecentNotifications($this->user['ID_USUARIO']);
        return $this->response->setJSON($notifications);
    }
}