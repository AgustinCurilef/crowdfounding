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

    public function addProyect(): String
    {
        $data['title'] = 'Agregar Proyecto';
        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('project/addProyect')
            .view('estructura/footer');
    }

    public function saveProject()
    {
        // Recogemos los datos del formulario
        $data = [
            'NOMBRE' => $this->request->getPost('NOMBRE'),
            'USERNAME_USUARIO' => $this->request->getPost('USERNAME_USUARIO'),
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB')
        ];
        $projectModel = new ProjectModel();

        if ($projectModel->setProject($data)) {
            return redirect()->to('/proyectos')->with('success', 'Proyecto guardado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al guardar el proyecto.');
        }
    }

}