<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\NotificationUserModel;
use App\Models\UpdateModel;
use App\Models\UserModel;
use App\Models\InvestmentModel;


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
                    // Obtener el tipo MIME de la imagen
            $mime = mime_content_type($urlImage);

            // Leer el contenido de la imagen
            $imageData = file_get_contents($urlImage);

            // Especificar el tipo MIME correcto para imágenes JPG
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setBody($imageData); // Enviar la imagen al navegador
                
        } else {
            // Ruta de la imagen por defecto
            $defaultImagePath = WRITEPATH . '../public/template/dist/assets/img/imagen_proyecto_por_defecto.png';

            if (file_exists($defaultImagePath)) {
                // Leer el contenido de la imagen predeterminada
                $defaultImage = file_get_contents($defaultImagePath);

                return $this->response->setHeader('Content-Type', 'image/jpeg')
                    ->setBody($defaultImage); // Enviar la imagen por defecto al navegador
            } else {
                // Si la imagen predeterminada no existe, retornar un error 404
                return $this->response->setStatusCode(404, 'Default image not found');
            }
        }     
    }

    public function listAllProjects(): String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $categories = $categoryModel->findAll();
        $projects = $ProjectModel->getProjects();
        $data = [
            'title' => 'Explorar Proyectos',
            'projects' => $projects,
            'notificationsUser' => $notificationsUser,
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
        $notificationsUser = $NotificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);


        $currentPage = $this->request->getVar('page') ?? 1; // Capturamos la página actual (por defecto, 1)
        $perPage = 6; // Definimos cuántos ítems por página
        helper('pagination');  // Carga el helper

        // Llamada a paginateArray que devuelve los proyectos y los datos de paginación
        $paginatedProjects = paginateArray($projects, $perPage, $currentPage);

        $data = [
            'title' => 'Mis Proyectos',
            'notificationsUser' => $notificationsUser,
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
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);

        $data = [
            'title' => 'Mis Inversiones',
            'notificationsUser' => $notificationsUser,
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
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $categories = $categoryModel->findAll();

        $data = [
            'title' => 'Crear Proyecto',
            'categories' => $categories,
            'notificationsUser' => $notificationsUser,
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
        $projectModel = new ProjectModel();
        $file = $this->request->getFile('portada');
        $validationRule = [
            'portada' => [
                'rules' => 'is_image[portada]|max_size[portada,2048]|mime_in[portada,image/jpg,image/jpeg,image/png]',
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
        // Recogemos los datos del formulario
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
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        

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
            'notificationsUser' => $notificationsUser,
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
            if ($file->move($uploadPath, $imageName)) {
                $data['PORTADA'] = $imageName;
            };
        }

        // Recogemos los datos del formulario
        // Recogemos los datos del formulario

        $updateSuccess = $projectModel->updateProject($data);
        if ($updateSuccess) {
            return redirect()->to('/myprojects')->with('success', 'Proyecto guardado exitosamente.');
        } else {
            $dbError = $projectModel->db->error(); // Retorna un array con 'code' y 'message'
            // Registrar o mostrar el error
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
    public function details($idProyect)
    {
        // Obtener los detalles del proyecto
        $userModel = new UserModel();
        $projectModel = new ProjectModel();
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $project = $projectModel->find($idProyect);
        $emprendedor = $userModel->getUserByNickname($project->USERNAME_USUARIO);

        // Obtener las actualizaciones del proyecto
        $updateModel = new UpdateModel();
        $updates = $updateModel->getUpdatesByProjectId($idProyect);


        // Cargar la vista con los datos del proyecto y las actualizaciones

        $data = [
            'title' => 'Detalle de Mis Proyectos',
            'project' => $project,
            'updates' => $updates,
            'notificationsUser' => $notificationsUser,
            'emprendedor' => $emprendedor,
            'user_name' => $this->user['USERNAME'] ?? null
        ];



        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('project/details', $data)
            . view('estructura/footer');
    }
    public function showFrontUpdates($idProyect, $ID_USUARIO, $FECHA)
    {
        $updateModel = new UpdateModel();

        $imageName = $updateModel->getImage($idProyect, $ID_USUARIO, $FECHA); // Obtener imagen BLOB desde el modelo
        $urlImage = WRITEPATH . 'uploads\\updates\\' . $imageName;
        log_message('debug', 'Ruta de la imagen: ' . $urlImage);

        //log_message('si:', $urlImage);
        if ($imageName) {

            // Obtener el tipo MIME de la imagen
            $mime = mime_content_type($urlImage);

            // Leer el contenido de la imagen
            $imageData = file_get_contents($urlImage);

            // Especificar el tipo MIME correcto para imágenes JPG
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setBody($imageData); // Enviar la imagen al navegador

        } else {
            // Ruta de la imagen por defecto
            $defaultImagePath = WRITEPATH . '../public/template/dist/assets/img/imagen_proyecto_por_defecto.png';

            if (file_exists($defaultImagePath)) {
                // Leer el contenido de la imagen predeterminada
                $defaultImage = file_get_contents($defaultImagePath);

                return $this->response->setHeader('Content-Type', 'image/jpeg')
                    ->setBody($defaultImage); // Enviar la imagen por defecto al navegador
            } else {
                // Si la imagen predeterminada no existe, retornar un error 404
                return $this->response->setStatusCode(404, 'Default image not found');
            }
        }
    }
    public function toggleVisibilityExplorer($idProyecto)
    {
        $user = new UserModel();
        $notification = new NotificationUserModel();
        $proyectoModel = new ProjectModel();
        $proyecto = $proyectoModel->find($idProyecto);
        $usuario = $user->getUserByNickname($proyecto->USERNAME_USUARIO);

        $nuevoEstado = $proyecto->ESTADO === '1' ? '0' : '1';   
        $proyectoModel->update($idProyecto, ['ESTADO' => $nuevoEstado]);
        $notification->addUserNotification(3, $usuario['ID_USUARIO']);

        return $this->response->setJSON(['status' => 'success', 'nuevoEstado' => $nuevoEstado === '0' ? 'PRIVADO' : 'PUBLICO']);
    }

    public function toggleVisibility($idProyecto)
    {
        $user = new UserModel();
        $notification = new NotificationUserModel();
        $proyectoModel = new ProjectModel();
        $proyecto = $proyectoModel->find($idProyecto);
        $usuario = $user->getUserByNickname($proyecto->USERNAME_USUARIO);

        $nuevoEstado = $proyecto->ESTADO === '1' ? '0' : '1';   
        $proyectoModel->update($idProyecto, ['ESTADO' => $nuevoEstado]);

        return $this->response->setJSON(['status' => 'success', 'nuevoEstado' => $nuevoEstado === '0' ? 'PRIVADO' : 'PUBLICO']);
    }
    
    public function shareUpdateProject($idProyecto)
    {
        $projectModel = new ProjectModel();
        $notificationUserModel = new NotificationUserModel();
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $project = $projectModel->find($idProyecto);
        
        // Preparar datos para la vista
        $data = [
            'title' => 'Actualizacion de mis proyectos',
            'project' => $project,
            'notificationsUser' => $notificationsUser,
            
            'user_name' => $this->user['USERNAME'] ?? null,
        ];

        // Cargar las vistas
        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('project/addUpdateProject', $data)
            . view('estructura/footer');
    }





    public function saveUpdateProject($projectId)
    {
        $model = new UpdateModel();
        $projectModel = new ProjectModel();
        $project = $projectModel->find($projectId);

        // Obtén los datos del formulario
        $descripcion = $this->request->getPost('descripcion');


        // Subir la imagen (si se selecciona una)
        $image = $this->request->getFile('portada');
        if ($image->isValid() && !$image->hasMoved()) {
            // Generar un nombre de archivo único
            $imageName = $image->getRandomName();

            // Mover la imagen al directorio 'writable/uploads/updates'
            $image->move(WRITEPATH . 'uploads/updates', $imageName);

            // Guardar los datos en la base de datos
            $data = [
                'ID_PROYECTO' => $project->ID_PROYECTO,
                'ID_USUARIO' => $this->user['ID_USUARIO'],
                'DESCRIPCION' => $descripcion,
                'NOMBRE_IMAGEN' => $imageName // Guardamos solo el nombre de la imagen
            ];

            // Insertar los datos en la tabla
            $model->insert($data);

            return redirect()->to('project/details/' . $project->ID_PROYECTO)->with('success', 'Actualización publicada exitosamente');
        } else {
            return redirect()->back()->with('error', 'Error al cargar la imagen');
        }
    }
}
