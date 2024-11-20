<?php
namespace App\Models;
use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table = 'notificaciones';
    protected $primaryKey = 'ID_NOTIFICACION';
    protected $allowedFields = ['NOMBRE', 'DESCRIPCION'];
}