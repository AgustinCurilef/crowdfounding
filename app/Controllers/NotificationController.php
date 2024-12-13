<?php
namespace App\Controllers;
use App\Models\NotificationModel;
use App\Models\NotificationUserModel;
use App\Models\PuntuarUsuarioModel;

class NotificationController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();

    }

    //ADMIN
    public function index()
    {
        $notificationModel = new NotificationModel();
        $notificationUserModel = new NotificationUserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $notifications = $notificationModel->findAll();
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $data = [
            'title' => 'Notificaciones',
            'statistics' => $statistics,
            'notificationsUser' => $notificationsUser,
            'user_name' => $this->user['USERNAME'],
            'notifications' => $notifications
        ];
        
        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('notification/index', $data)
            . view('estructura/footer');
    }

    public function create()
    {
        $notificationUserModel = new NotificationUserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $data = [
            'title' => 'Agregar Notificacion',
            'user_name' => $this->user['USERNAME'],
            'statistics' => $statistics,
            'notificationsUser' => $notificationsUser
    ];
    
    return view('estructura/header', $data)
            . view('estructura/navbar',$data)
            . view('estructura/sidebar')
            . view('notification/create')
            . view('estructura/footer');
    }

    public function save()
    {
        $notificacionModel = new NotificationModel();

        $data = [
            'NOMBRE' => $this->request->getPost('nombre'),
            'DESCRIPCION' => $this->request->getPost('descripcion')
        ];

        if (empty($data['NOMBRE'])) {
            return redirect()->back()
                           ->with('error', 'El nombre de la notificación es obligatorio');
        }

        if ($notificacionModel->insert($data)) {
            return redirect()->to('/notification')
                           ->with('mensaje', 'Notificación creada exitosamente');
        } else {
            return redirect()->back()
                           ->with('error', 'Error al crear la notificación');
        }
    }

    public function edit($id)
    {
        $notificationModel = new NotificationModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $notificationUserModel = new NotificationUserModel();
        $notification = $notificationModel->find($id);
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        if (!$notification) {
            return redirect()->to('/notification')->with('error', 'Notificación no encontrada');
        }
        
        $data = [
            'title' => 'Editar Notificación',
            'statistics' => $statistics,
            'user_name' => $this->user['USERNAME'],
            'notificationsUser' => $notificationsUser,
            'notification' => $notification
        ];
        
        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('notification/create', $data)
            . view('estructura/footer');
    }

    public function update($id)
    {
        $notificationModel = new NotificationModel();
        
        $data = [
            'NOMBRE' => $this->request->getPost('nombre'),
            'DESCRIPCION' => $this->request->getPost('descripcion')
        ];
        
        if (empty($data['NOMBRE'])) {
            return redirect()->back()->with('error', 'El nombre de la notificación es obligatorio');
        }
        
        if ($notificationModel->update($id, $data)) {
            return redirect()->to('/notification')->with('mensaje', 'Notificación actualizada exitosamente');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar la notificación');
        }
    }

    public function delete($id)
    {
        $notificationModel = new NotificationModel();
        
        if ($notificationModel->delete($id)) {
            return redirect()->to('/notification')->with('mensaje', 'Notificación eliminada exitosamente');
        } else {
            return redirect()->to('/notification')->with('error', 'Error al eliminar la notificación');
        }
    }    
}