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
        $session = session();
        $data['user_name'] = $session->get('user_name');

        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('project/myProjectList', $data)
            .view('estructura/footer');
    }

    public function addProyect(): String
    {
        $data['title'] = 'Agregar Proyecto';
        $session = session();
        $data['user_name'] = $session->get('user_name');
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
            'CATEGORY' => $this->request->getPost('CATEGORIA'),
            'USERNAME_USUARIO' => 'agus',
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB')
        ];
        $projectModel = new ProjectModel();
        if ($projectModel->setProject($data)) {
            log_message('debug', 'supuestamente guarda.');
            return redirect()->to('/proyectos')->with('success', 'Proyecto guardado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al guardar el proyecto.');
        }
    }

    public function listInvestments():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
        
        
        $data = ['title' => 'Mis Proyectos', 'projects' => $projects, 'categories' => $categories];
        $session = session();
        $data['user_name'] = $session->get('user_name');
        
        return view('estructura/header', $data)
            .view('estructura/navbar')
            .view('estructura/sidebar')
            .view('project/myInvestments', $data)
            .view('estructura/footer');
    }


}