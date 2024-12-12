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

    public function createInvestmentNotification($projectData)
    {
        // Primero obtenemos el ID_USUARIO a partir del USERNAME
        $usuario = $this->userModel->where('USERNAME', $projectData->USERNAME_USUARIO)
            ->first();

        if (!$usuario) {
            // Si no encontramos el usuario, registramos el error y retornamos
            log_message('error', 'No se encontró el usuario con USERNAME: ' . $projectData->USERNAME_USUARIO);
            return false;
        }


        $notification = $this->notificationUserModel->addUserNotification(
            2,
            $usuario['ID_USUARIO'] // Usamos el índice en lugar de la notación de objeto
        );
    }

    public function index()
    {
        if (!session()->get('ID_USUARIO')) {
            return redirect()->to('/login');
        }
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $notificationModel = new NotificationModel();
        $notificationsUserAll = $notificationUserModel->getUserNotifications(session()->get('ID_USUARIO'));

        $data = [
            'title' => 'Mis Notificaciones',
            'notificationsUser' => $notificationsUser,
            'notificationsUserAll' => $notificationsUserAll,
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

    public function markAllAsRead()
    {
        $NotificationUserModel = new NotificationUserModel();


        // Obtiene todas las notificaciones del usuario que no están leídas
        $notifications = $NotificationUserModel->where('ID_USUARIO', $this->user['ID_USUARIO'])
            ->where('ESTADO', 0)
            ->findAll();

        $errors = [];

        // Marca cada notificación como leída usando el método del modelo
        foreach ($notifications as $notification) {
            $result = $NotificationUserModel->markAsRead($notification['ID_NOTIFICACION'], $this->user['ID_USUARIO']);
            if (!$result) {
                $errors[] = $notification['ID_NOTIFICACION']; // Guarda el ID si no se pudo actualizar
            }
        }

        if (!empty($errors)) {
            return $this->response->setJSON(['status' => 'error', 'errors' => $errors]);
        }

        // Respuesta según el éxito o error
        return $this->response->setJSON(['status' => 'success']);
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
