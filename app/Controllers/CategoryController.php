<?php
namespace App\Controllers;
use App\Models\CategoryModel;
use App\Models\NotificationUserModel;
use App\Models\PuntuarUsuarioModel;

class CategoryController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();
        
    }
    public function index(): string
    {
        $categoryModel = new CategoryModel();
        $notificationUserModel = new NotificationUserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $data = [
            'statistics' => $statistics,
            'title' => 'Lista de Categorías',
            'notificationsUser' => $notificationsUser,
            'categories' => $categoryModel->findAll(),
            'user_name' => $this->user['USERNAME'] 
        ];
       
       
       
        return view('estructura/header', $data)
            . view('estructura/navbar',$data)
            . view('estructura/sidebar')
            . view('category/listCategories', $data)
            . view('estructura/footer');
    }

    public function create(): string
    {
        $notificationUserModel = new NotificationUserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $data = [
            'title' => 'Agregar Categoría',
            'user_name' => $this->user['USERNAME'],
            'statistics' => $statistics,
            'notificationsUser' => $notificationsUser];
        return view('estructura/header', $data)
            . view('estructura/navbar',$data)
            . view('estructura/sidebar')
            . view('category/addCategory')
            . view('estructura/footer');
    }

    public function save()
    {
        $categoryModel = new CategoryModel();
       
        $data = [
            'NOMBRE' => $this->request->getPost('nombre'),
            'DESCRIPCION' => $this->request->getPost('descripcion')
        ];
        if ($categoryModel->insert($data)) {
            return redirect()->to('/categories')->with('mensaje', 'Categoría agregada exitosamente');
        } else {
            return redirect()->to('/categories/create')->with('error', 'Error al agregar la categoría');
        }
    }

    public function edit($id)
    {
        $notificationUserModel = new NotificationUserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $categoryModel = new CategoryModel();
        $data = [
            'title' => 'Editar Categoría',
            'statistics' => $statistics,
            'category' => $categoryModel->find($id),
            'notificationsUser' => $notificationsUser,
            'user_name' => $this->user['USERNAME'] 
        ];
       
        return view('estructura/header', $data)
            . view('estructura/navbar',$data)
            . view('estructura/sidebar')
            . view('category/editCategory', $data)
            . view('estructura/footer');
    }

    public function update($id)
    {
        $categoryModel = new CategoryModel();
       
        $data = [
            'NOMBRE' => $this->request->getPost('nombre'),
            'DESCRIPCION' => $this->request->getPost('descripcion')
        ];
        if ($categoryModel->update($id, $data)) {
            return redirect()->to('/categories')->with('mensaje', 'Categoría actualizada exitosamente');
        } else {
            return redirect()->to('/categories/edit/' . $id)->with('error', 'Error al actualizar la categoría');
        }
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();
       
        if ($categoryModel->delete($id)) {
            return redirect()->to('/categories')->with('mensaje', 'Categoría eliminada exitosamente');
        } else {
            return redirect()->to('/categories')->with('error', 'Error al eliminar la categoría');
        }
    }
}