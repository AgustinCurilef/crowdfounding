<?php
namespace App\Models;
use CodeIgniter\Model;

class NotificationUserModel extends Model
{
    protected $table = 'notificaciones_usuario';
    protected $allowedFields = ['ID_NOTIFICACION', 'ID_USUARIO', 'FECHA', 'ESTADO'];
    
    public function addUserNotification($idNotificacion, $idUsuario)
    {
        return $this->insert([
            'ID_NOTIFICACION' => $idNotificacion,
            'ID_USUARIO' => $idUsuario,
            'FECHA' => date('Y-m-d H:i:s'),
            'ESTADO' => 0
        ]);
    }
    
    public function getUserNotifications($userId)
    {
        return $this->select('notificaciones_usuario.*, notificaciones.NOMBRE, notificaciones.DESCRIPCION')
                    ->join('notificaciones', 'notificaciones.ID_NOTIFICACION = notificaciones_usuario.ID_NOTIFICACION')
                    ->where('notificaciones_usuario.ID_USUARIO', $userId)
                    ->orderBy('notificaciones_usuario.FECHA', 'DESC')
                    ->findAll();
    }
    
    public function getUnreadCount($userId)
    {
        return $this->where('ID_USUARIO', $userId)
                    ->where('ESTADO', 0)
                    ->countAllResults();
    }

    public function markAsRead($notificationId, $userId)
    {
        return $this->where('ID_NOTIFICACION', $notificationId)
                    ->where('ID_USUARIO', $userId)
                    ->set(['ESTADO' => 1])
                    ->update();
    }

    public function getRecentNotifications($userId, $limit = 5)
    {
        return $this->select('notificaciones_usuario.*, notificaciones.NOMBRE, notificaciones.DESCRIPCION')
                    ->join('notificaciones', 'notificaciones.ID_NOTIFICACION = notificaciones_usuario.ID_NOTIFICACION')
                    ->where('notificaciones_usuario.ID_USUARIO', $userId)
                    ->orderBy('notificaciones_usuario.FECHA', 'DESC')
                    ->limit($limit)
                    ->find();
    }
}