<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\CategoryModel;

class InvestmentController extends BaseController
{
    public function index():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
        
        
        $data = ['title' => 'Mis Proyectos', 'projects' => $projects, 'categories' => $categories];

        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('investment', $data)
            .view('estructura/footer');
    }
}