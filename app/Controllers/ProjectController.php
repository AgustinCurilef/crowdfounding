<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\UserModels;

class ProjectController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();

    }
    public function list():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
       
        
        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => $this->user['USERNAME']  // Usa el nombre de usuario directamente
        ];
        
       


        return view('estructura/header', $data)
            .view('estructura/navbar', $data)
            .view('estructura/sidebar')
            .view('project/myProjectList', $data)
            .view('estructura/footer');
    }

    public function addProyect(): String
    {
    
        $data = [
            'title' => 'Agregar Proyecto',
            'user_name' => $this->user['USERNAME'] ?? null // Usa el nombre de usuario directamente
        ];
       
        return view('estructura/header', $data)
            .view('estructura/navbar', $data)
            .view('estructura/sidebar')
            .view('project/addProyect', $data)
            .view('estructura/footer');
    }

    public function saveProject()
    {
        // Recogemos los datos del formulario
        $data = [
            'NOMBRE' => $this->request->getPost('NOMBRE'),
            'CATEGORY' => $this->request->getPost('CATEGORIA'),
            'USERNAME_USUARIO' => $this->user['USERNAME'] ,
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
        
        
        $data = ['title' => 'Mis Proyectos',
         'projects' => $projects, 
         'categories' => $categories,
        'user_name'=> $this->user['USERNAME'] ?? null ];
        
        
        return view('estructura/header', $data)
            .view('estructura/navbar', $data)
            .view('estructura/sidebar')
            .view('project/myInvestments', $data)
            .view('estructura/footer');
    }


    public function modify($id)
{
    
    $ProjectModel = new ProjectModel();
    $categoryModel = new CategoryModel();
    $project = $ProjectModel->getProjectById($id);
    $categories= $categoryModel-> findAll();

    $data = [
        'title' => 'Mis Proyectos',
        'project' => $project,
        'categories' => $categories,
        'user_name'=> $this->user['USERNAME'] ?? null ];

    return view('estructura/header', $data)
        . view('estructura/navbar', $data)
        . view('estructura/sidebar')
        . view('project/modifyProject', $data)
        . view('estructura/footer');
}

public function updateProject($id)
    {
        // Recogemos los datos del formulario
        $data = [
            'ID_PROYECTO' => $id,
            'NOMBRE' => $this->request->getPost('NOMBRE'),
            'CATEGORY' => $this->request->getPost('CATEGORIA'),
            'USERNAME_USUARIO' => $this->user['USERNAME'] ,
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB')
        ];
        $projectModel = new ProjectModel();
        if ($projectModel->updateProject($data)) {
            log_message('debug', 'supuestamente guarda.');
            return redirect()->to('/myprojects')->with('success', 'Proyecto guardado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al guardar el proyecto.');
        }

}

public function deleteProject($id)
{
    $ProjectModel = new ProjectModel();
    try {
        // Intentar eliminar el proyecto
        if ($ProjectModel->delete($id)) {
            // Si la eliminación fue exitosa, redirigir con mensaje de éxito
            return redirect()->to('/myprojects')
                           ->with('success', 'Proyecto eliminado exitosamente');
        } else {
            // Si hubo un error en la eliminación
            return redirect()->back()
                           ->with('error', 'No se pudo eliminar el proyecto');
        }
    } catch (\Exception $e) {
        // Si ocurre una excepción
        log_message('error', 'Error al eliminar el proyecto: ' . $e->getMessage());
        return redirect()->back()
                       ->with('error', 'Error al eliminar el proyecto');
    }
}

}