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
    public function listAllProjects(): String
    {

        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories = $categoryModel->findAll();
        $currentPage = $this->request->getVar('page') ?? 1; // Capturamos la página actual (por defecto, 1)
        $perPage = 6; // Definimos cuántos ítems por página
        helper('pagination');  // Carga el helper
        // Llamada a paginateArray que devuelve los proyectos y los datos de paginación
        $paginatedProjects = paginateArray($projects, $perPage, $currentPage);

        $data = [
            'title' => 'Mis Proyectos',
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'], // Usa el nombre de usuario directamente
            'currentPage' => $currentPage, // Pasa la página actual
            'totalPages' => $paginatedProjects['totalPages'], // Total de páginas
            'totalItems' => $paginatedProjects['totalItems'], // Total de ítems
        ];
        foreach ($projects as $project) {
            if ($project->imagen) {
                $project->imagen_base64 = base64_encode($project->imagen);
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

        //       @log_message('debug', 'Proyectos recuperados para usuario {id}: {projects}', [
        //           'id' => $userId,
        //           'projects' => json_encode($projects, JSON_PRETTY_PRINT)
        //       ]);

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
        $imageName = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            log_message('debug', 'Imagen subida: ' . $file->getName()); // Nombre del archivo
            log_message('debug', 'Tamaño de la imagen: ' . $file->getSize() . ' bytes'); // Tamaño del archivo
            log_message('debug', 'Tipo MIME de la imagen: ' . $file->getMimeType()); // Tipo MIME

            if (!$this->validate($validationRule)) {
                log_message('debug', 'no paso la valicion de las reglas: ' . $file->getMimeType()); // Tipo MIME

                return redirect()->back()->withInput()->with('error', $this->validator->getErrors());
            }

            // Generar un nombre único para la imagen y moverla a la carpeta de subida
            $imageName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $imageName);
            // Ya no necesitas usar getTempName()
            // Leer el contenido binario del archivo
            $imagePath = WRITEPATH . 'uploads/' . $imageName;
            $imageData = file_get_contents($imagePath);

            // Verificar si la imagen se cargó correctamente
            if ($imageData === false) {
                log_message('debug', 'Error al leer la imagen desde: ' . $imagePath);
            } else {
                log_message('debug', 'Imagen cargada correctamente, tamaño: ' . strlen($imageData) . ' bytes');
            }
        }
        // Recogemos los datos del formulario
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
            'ESTADO' => $this->request->getPost('ESTADO'),
            'ARCHIVO' => $imageData

        ];
        $projectModel = new ProjectModel();
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
