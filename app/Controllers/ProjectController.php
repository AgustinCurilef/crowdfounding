<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\CategoryModel;


class ProjectController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();

    }
    public function listAllProjects():String
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
    public function list():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProject( $this->user['USERNAME']);
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
    
        $categoryModel = new CategoryModel();
        $categories= $categoryModel-> findAll();

    $data = [
        'title' => 'Mis Proyectos',
        'categories' => $categories,
        'user_name'=> $this->user['USERNAME'] ?? null ];
       
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
            'CATEGORIAS' => $this->request->getPost('ID_CATEGORIA'),
            'USERNAME_USUARIO' => $this->user['USERNAME'] ,
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB'),
            'ESTADO' => $this->request->getPost('ESTADO')
        ];
        $projectModel = new ProjectModel();
        if ($projectModel->setProject($data)) {
            return redirect()->to('/myprojects')->with('success', 'Proyecto guardado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'Hubo un problema al guardar el proyecto.');
        }
    }
    public function modify($id)
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
    
        // Obtener el proyecto por su ID
        $project = $ProjectModel->getProjectById($id);
    
        // Obtener todas las categorías disponibles
        $categories = $categoryModel->findAll();
    
        // Obtener las categorías asociadas a este proyecto
        $selectedCategories = $categoryModel->getCategory($id);

        // Preparar datos para la vista
        $data = [
            'title' => 'Modificar Proyecto',
            'project' => $project,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories ?? [], // Array vacío si no hay categorías seleccionadas
            'user_name' => $this->user['USERNAME'] ?? null,
        ];
    
        // Cargar las vistas
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
            'CATEGORIAS' => $this->request->getPost('ID_CATEGORIA'),
            'USERNAME_USUARIO' => $this->user['USERNAME'] ,
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB'),
            'ESTADO' => $this->request->getPost('ESTADO')

        ];
        log_message('debug', 'controlador: ' . print_r($data, true));

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