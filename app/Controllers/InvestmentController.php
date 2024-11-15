<?php
namespace App\Controllers;
use App\Models\InvestmentModel;
use App\Models\ProjectModel;
use App\Models\CategoryModel;


class InvestmentController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
   
        $this->user = session()->get();

    }
    public function index():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
        
        
        
        $data = ['title' => 'Mis Proyectos', 
        'projects' => $projects, 
        'categories' => $categories,
        'user_name' => $this->user['USERNAME'] ];

        return view('estructura/header', $data)
            .view('estructura/navbar',$data)
            .view('estructura/sidebar')
            .view('investment', $data)
            .view('estructura/footer');
    }
    public function create()
    {
        // Cargar el modelo de proyectos para obtener la lista
        $projectModel = new ProjectModel();
        
        $data = [
            'title' => 'Realizar Inversión',
            'proyectos' => $projectModel->findAll(),
            'user_name' => $this->user['USERNAME'] 
        ];
        
        return view('estructura/header', $data)
            . view('estructura/navbar',$data)
            . view('estructura/sidebar')
            . view('investment/makeInvestment', $data)
            . view('estructura/footer');
    }
    
    public function save()
    {
        $investmentModel = new InvestmentModel();
        
        
        
        // Preparar los datos
        $data = [
            'ID_PROYECTO' => $this->request->getPost('id_proyecto'),
            'ID_USUARIO' => $this->user['ID_USUARIO'] ,
            'MONTO' => $this->request->getPost('monto'),
            'ESTADO' => 'Pendiente',
            'FECHA' => date('Y-m-d') // Fecha actual
        ];
        
        // Validaciones
        if (empty($data['ID_PROYECTO']) || empty($data['MONTO'])) {
            return redirect()->to('/investment/create')
                           ->with('error', 'Todos los campos son obligatorios');
        }
        
        if ($data['MONTO'] <= 0) {
            return redirect()->to('/investment/create')
                           ->with('error', 'El monto debe ser mayor a 0');
        }
        
        // Guardar la inversión
        if ($investmentModel->insert($data)) {
            return redirect()->to('/investment')
                           ->with('mensaje', 'Inversión registrada exitosamente');
        } else {
            return redirect()->to('/investment/create')
                           ->with('error', 'Error al registrar la inversión');
        }
    }
}