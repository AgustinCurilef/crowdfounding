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
        $data = ['title' => 'Home','user_name' => $this->user['USERNAME'] ];
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
    
}
