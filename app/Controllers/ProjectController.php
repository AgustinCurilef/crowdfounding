<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\NotificationUserModel;


class ProjectController extends BaseController
{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();
    }

    public function showFront($idProyect)
    {
        $projectModel = new ProjectModel();
        $imageName = $projectModel->getImage($idProyect); // Obtener imagen BLOB desde el modelo
        $urlImage = WRITEPATH . 'uploads\\proyecto\\portada\\' . $imageName;
        //log_message('si:', $urlImage);
        if ($imageName) {

                    // Obtener el tipo MIME de la imagen
            $mime = mime_content_type($urlImage);

            // Leer el contenido de la imagen
            $imageData = file_get_contents($urlImage);

            // Especificar el tipo MIME correcto para imágenes JPG
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setBody($imageData);// Enviar la imagen al navegador
                
        } else {
            return $this->response->setStatusCode(404, 'Default image not found');
        }      
    }

    public function listAllProjects(): String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();
        $projects = $ProjectModel->getProjects();
        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'], // Usa el nombre de usuario directamente

        ];

        foreach ($projects as $project) {
            if ($project->PORTADA) {
                $project->imagen_base64 = base64_encode($project->PORTADA);
            } else {
                $project->imagen_base64 = ''; // Si no hay imagen, asignar vacío
            }
        }

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('project/explorerProject', $data)
            . view('estructura/footer');
    }
    public function list(): String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProject($this->user['USERNAME']);
        $categories = $categoryModel->findAll();
        $NotificationUserModel = new NotificationUserModel();
        $amountNotification = $NotificationUserModel->getUnreadCount($this->user['ID_USUARIO']);


        $currentPage = $this->request->getVar('page') ?? 1; // Capturamos la página actual (por defecto, 1)
        $perPage = 6; // Definimos cuántos ítems por página
        helper('pagination');  // Carga el helper

        // Llamada a paginateArray que devuelve los proyectos y los datos de paginación
        $paginatedProjects = paginateArray($projects, $perPage, $currentPage);

        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $paginatedProjects['data'], // Los proyectos paginados
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'], // Usa el nombre de usuario directamente
            'currentPage' => $currentPage, // Pasa la página actual
            'totalPages' => $paginatedProjects['totalPages'], // Total de páginas
            'totalItems' => $paginatedProjects['totalItems'], // Total de ítems
            'amountNotification' => $amountNotification
        ];

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('project/myProjectList', $data)
            . view('estructura/footer');
    }
    public function listInvestments(): String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $userId = $this->user['ID_USUARIO'];
        $projects = $ProjectModel->getInvestmentsByUser($userId);
        $categories = $categoryModel->findAll();
        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'] ?? null
        ];



        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('project/myInvestments', $data)
            . view('estructura/footer');
    }


    public function addProyect(): String
    {

        $categoryModel = new CategoryModel();
        $categories = $categoryModel->findAll();

        $data = [
            'title' => 'Mis Proyectos',
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'] ?? null
        ];
        
        return view('estructura/header', $data)
        . view('estructura/navbar', $data)
        . view('estructura/sidebar')
        . view('project/addProyect', $data)
        . view('estructura/footer');
    }
    
    public function saveProject()
    {
        // Configuración para la subida del archivo
        $projectModel = new ProjectModel();
        $file = $this->request->getFile('portada');
        $validationRule = [
            'portada' => [
                'rules' => 'is_image[portada]|max_size[portada,2048]|mime_in[portada,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'El archivo debe ser una imagen válida.',
                    'max_size' => 'El tamaño máximo permitido es de 2 MB.',
                    'mime_in' => 'Solo se permiten imágenes en formato JPG, JPEG o PNG.'
                ]
            ]
        ];
        $data = [
            'NOMBRE' => $this->request->getPost('NOMBRE'),
            'CATEGORIAS' => $this->request->getPost('ID_CATEGORIA'),
            'USERNAME_USUARIO' => $this->user['USERNAME'],
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB'),
            'ESTADO' => $this->request->getPost('ESTADO')
        ];
        if (!$this->validate($validationRule)) {
            // Obtén los mensajes de error
            $errors = \Config\Services::validation()->getErrors();
            // Muestra los errores o redirige con ellos
            return redirect()->back()->withInput()->with('errors', $errors);
        }
        // Validar la imagen si se ha cargado
        if ($file->isValid()) {

            $uploadPath = WRITEPATH . 'uploads/proyecto/portada';
            // Generar un nombre único para la imagen y moverla a la carpeta de subida
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $imageName = $file->getRandomName();
            if ($file->move($uploadPath, $imageName)) {
                $data['PORTADA'] = $imageName;
            };
        }
        $projectName = $this->request->getPost('NOMBRE'); 
        if ($projectModel->projectNameExists($projectName, null)) {
            return redirect()->back()->withInput()->with('error', 'El nombre del proyecto ya está en uso.');
        }
        // Recogemos los datos del formulario

        log_message('debug', 'Datos recibidos: ' . json_encode($data));

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
        // Configuración para la subida del archivo
        $projectModel = new ProjectModel();
        $validationRule = [
            'portada' => [
                'rules' => 'uploaded[portada]|is_image[portada]|max_size[portada,2048]|mime_in[portada,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'uploaded' => 'Debes seleccionar una imagen de portada.',
                    'is_image' => 'El archivo debe ser una imagen válida.',
                    'max_size' => 'El tamaño máximo permitido es de 2 MB.',
                    'mime_in' => 'Solo se permiten imágenes en formato JPG, JPEG o PNG.'
                ]
            ]
        ];

        // Validar la imagen si se ha cargado
        $file = $this->request->getFile('portada');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Si la imagen fue subida, validar y procesarla
            if (!$this->validate($validationRule)) {
                log_message('debug', 'no pasó la validación de las reglas: ' . $file->getMimeType()); // Tipo MIME
                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }
            $uploadPath = WRITEPATH . 'uploads/proyecto/portada/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $imageName = $projectModel->getImage($id);
            // Generar un nombre único para la imagen y moverla a la carpeta de subida
            if(empty($imageName)) {
                $imageName = $file->getRandomName();
            }
            else {
                unlink($uploadPath . $imageName);
            }
            $file->move($uploadPath, $imageName);
        }

        // Recogemos los datos del formulario
        $data = [
            'ID_PROYECTO' => $id,
            'NOMBRE' => $this->request->getPost('NOMBRE'),
            'CATEGORIAS' => $this->request->getPost('ID_CATEGORIA'),
            'USERNAME_USUARIO' => $this->user['USERNAME'],
            'PRESUPUESTO' => $this->request->getPost('PRESUPUESTO'),
            'OBJETIVO' => $this->request->getPost('OBJETIVO'),
            'DESCRIPCION' => $this->request->getPost('DESCRIPCION'),
            'FECHA_LIMITE' => $this->request->getPost('FECHA_LIMITE'),
            'RECOMPENSAS' => $this->request->getPost('RECOMPENSAS'),
            'SITIO_WEB' => $this->request->getPost('SITIO_WEB'),
            'ESTADO' => $this->request->getPost('ESTADO'),
            'PORTADA' => $imageName // Puede ser null si no se subió imagen
        ];
        $updateSuccess = $projectModel->updateProject($data);
        if ($updateSuccess) {
            return redirect()->to('/myprojects')->with('success', 'Proyecto guardado exitosamente.');
        } else {
            $dbError = $projectModel->db->error(); // Retorna un array con 'code' y 'message'
            // Registrar o mostrar el error
            log_message('error', 'Error en la actualización del proyecto: ' . $dbError['message']);
            return redirect()->back()->with('error', 'Hubo un problema al guardar el proyecto. Error: ' . $dbError['message']);
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
