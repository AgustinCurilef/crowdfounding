<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\CategoryModel;

class ProjectController extends BaseController
{
    public function list():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
        
        
        $data = ['title' => 'Mis Proyectos', 'projects' => $projects, 'categories' => $categories];

        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('project/myProjectList', $data)
            .view('estructura/footer');
    }

}