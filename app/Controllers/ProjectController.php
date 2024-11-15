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
    public function listInvestments():String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $userId = $this->user['ID_USUARIO'];
        $projects = $ProjectModel->getInvestmentsByUser($userId);   
        $categories= $categoryModel-> findAll();
        $data = ['title' => 'Mis Proyectos','projects' => $projects, 
        'categories' => $categories,'user_name'=> $this->user['USERNAME'] ?? null ];
       
 //       @log_message('debug', 'Proyectos recuperados para usuario {id}: {projects}', [
 //           'id' => $userId,
 //           'projects' => json_encode($projects, JSON_PRETTY_PRINT)
 //       ]);

        return view('estructura/header', $data)
            .view('estructura/navbar', $data)
            .view('estructura/sidebar')
            .view('project/myInvestments', $data)
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
}