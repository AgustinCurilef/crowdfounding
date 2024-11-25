<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class UserController extends BaseController

{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();
    }


    public function index(): String

    {
        // Obtener el ID de usuario de la sesión
        $data = ['title' => 'Home', 'user_name' => $this->user['USERNAME']];
        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('estructura/main')
            . view('estructura/footer');
    }

    public function editProfile(): String
    {

        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories = $categoryModel->findAll();


        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'],
            'user' => $this->user
        ];

        $this->response->setCache([
            'max-age' => 0, // No cache
            'no-store' => true, // No almacenar
        ]);
        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('editProfile', $data)
            . view('estructura/footer');
    }

    public function showImage($idUsuario)
    {
        $userModel = new UserModel();
        $imagenBlob = $userModel->getImage($idUsuario); // Obtener imagen BLOB desde el modelo

        if ($imagenBlob) {
            // Especificar el tipo MIME correcto para imágenes JPG
            return $this->response->setHeader('Content-Type', 'image/jpeg')
                ->setBody($imagenBlob); // Enviar la imagen al navegador
        } else {
            return $this->response->setStatusCode(404); // Imagen no encontrada
        }
    }

    public function saveChanges()
    {
        $username = $this->request->getPost('username');
        $userId = $this->request->getPost('id_usuario'); 
        $file = $this->request->getFile('foto_perfil');
        $userModel = new UserModel();
    
        $userData = [
            'username' => $this->request->getPost('username'),
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'telefono' => $this->request->getPost('telefono'),
            'linkedin' => $this->request->getPost('linkedin')
        ];
    
        // Username ya existe, regresar con error
        if ($userModel->usernameExists($username, $userId)) {
            return redirect()->back()->withInput()->with('error', 'El username ya está en uso.');
        }
    
        // Validación del archivo
        if ($file->getError() !== UPLOAD_ERR_NO_FILE) { // Verifica si el archivo fue cargado
    
            if ($file->isValid()) {
                $userData['foto_perfil'] = file_get_contents($file->getTempName());
            } else {
                return redirect()->back()->withInput()->with('error', 'El archivo subido no es válido.');
            }
        }
    
        // Actualizar los datos del usuario
        $updateSuccess = $userModel->update($userId, $userData);
    
        if ($updateSuccess) {
            $session = session();
            $userData = $userModel->find($userId);
            $session->set($userData);
            return redirect()->to('/editProfile')->with('success', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar.');
        }
    }    

    public function delete($id)
    {
        $userModel = new UserModel();;

        if ($userModel->delete($id)) {
            return redirect()->to('/')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->to('/editProfile')->with('error', 'No se pudo eliminar el usuario.');
        }
    }
}
