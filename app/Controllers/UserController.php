<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\CategoryModel;

class UserController extends BaseController
{
    public function index():String
     
    {
     // Obtener el ID de usuario de la sesión
        $userId = session()->get('user_id');
        $userModel = new \App\Models\UserModels();
        $user = $userModel->find($userId);
        $data = ['title' => 'Home','user_name' => $user['USERNAME'],];
        return view('estructura/header', $data)
            .view('estructura/navbar')
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
        
        
        $data = ['title' => 'Mis Proyectos', 'projects' => $projects, 'categories' => $categories];

        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('editProfile', $data)
            .view('estructura/footer');
    }
    
}
