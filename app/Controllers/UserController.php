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

    
    public function index():String
     
    {
     // Obtener el ID de usuario de la sesión
        $data = ['title' => 'Home','user_name' => $this->user['USERNAME']];
        return view('estructura/header', $data)
            .view('estructura/navbar',$data)
            .view('estructura/sidebar')
            .view('estructura/main')
            .view('estructura/footer');
            
        }
    
    public function editProfile():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
        
        
        $data = ['title' => 'Mis Proyectos',
         'projects' => $projects, 
         'categories' => $categories,
        'user_name' => $this->user['USERNAME'],
        'user' => $this->user];

        return view('estructura/header', $data)
            .view('estructura/navbar',$data)
            .view('estructura/sidebar')
            .view('editProfile', $data)
            .view('estructura/footer');
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
            // Si no se encuentra la imagen, lanzar un error 404
            throw new PageNotFoundException('Imagen no encontrada');
        }
    }
    
    
}
