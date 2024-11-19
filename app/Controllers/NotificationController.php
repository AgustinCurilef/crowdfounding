<?php
namespace App\Controllers;
use App\Models\NotificationModel;

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
        $notifications = $notificationModel->findAll();
        
        $data = [
            'title' => 'Notificaciones',
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
        $data = ['title' => 'Agregar Notificacion','user_name' => $this->user['USERNAME'] ];

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
        $notification = $notificationModel->find($id);
        
        if (!$notification) {
            return redirect()->to('/notification')->with('error', 'Notificación no encontrada');
        }
        
        $data = [
            'title' => 'Editar Notificación',
            'user_name' => $this->user['USERNAME'],
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