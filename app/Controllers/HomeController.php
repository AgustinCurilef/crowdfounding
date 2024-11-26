<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CategoryModel;

class HomeController extends BaseController
{
    public function index(): String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
        $projects = $ProjectModel->getProjects();
        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $projects,
            'categories' => $categories
        ];

        foreach ($projects as $project) {
            if ($project->imagen) {
                $project->imagen_base64 = base64_encode($project->imagen);
            } else {
                $project->imagen_base64 = ''; // Si no hay imagen, asignar vacío
            }
        }

        return view('home', $data);
    }
}
