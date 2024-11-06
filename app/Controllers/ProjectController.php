<?php

namespace App\Controllers;
use App\Models\ProjectModel;

class ProjectController extends BaseController
{
    public function list():String
    {
        
        $ProjectModel = new ProjectModel();
        $projects = $ProjectModel->getProjects();
        
        
        $data = ['title' => 'Mis Proyectos', 'projects' => $projects ];

        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('project/myProjectList', $data)
            .view('estructura/footer');
    }

}