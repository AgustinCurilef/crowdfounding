<?php

namespace App\Controllers;
use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\UserModel;

class UserController extends BaseController

{
    protected  $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();

    }

    
    public function index():String
     
    {
     // Obtener el ID de usuario de la sesión
        $data = ['title' => 'Home','user_name' => $this->user['USERNAME']];
        return view('estructura/header', $data)
            .view('estructura/navbar',$data)
            .view('estructura/sidebar')
            .view('estructura/main')
            .view('estructura/footer');
            
        }
    
    public function editProfile():String
    {
        
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $projects = $ProjectModel->getProjects();
        $categories= $categoryModel-> findAll();
        
        
        $data = ['title' => 'Mis Proyectos',
         'projects' => $projects, 
         'categories' => $categories,
        'user_name' => $this->user['USERNAME'],
        'user' => $this->user];

        $this->response->setCache([
            'max-age' => 0, // No cache
            'no-store' => true, // No almacenar
        ]);
        return view('estructura/header', $data)
            .view('estructura/navbar',$data)
            .view('estructura/sidebar')
            .view('editProfile', $data)
            .view('estructura/footer');
    }

    public function showImage($idUsuario)
    {
        $userModel = new UserModel();
        $imagenBlob = $userModel->getImage($idUsuario); // Obtener imagen BLOB desde el modelo

        if ($imagenBlob) {
            // Especificar el tipo MIME correcto para imágenes JPG
            return $this->response->setHeader('Content-Type', 'image/jpeg')
                                  ->setBody($imagenBlob); // Enviar la imagen al navegador
        } else {
            // Si no se encuentra la imagen, lanzar un error 404
            throw new PageNotFoundException('Imagen no encontrada');
        }
    }
    
    public function saveChanges()
    {
        $rules = [
            'file' => [
                'uploaded[file]',  // Verifica si el archivo fue subido
                'max_size[file,2048]',  // Tamaño máximo de 2 MB (2048 KB)
                'is_image[file]',  // Verifica si el archivo es una imagen (opcional)
                'mime_in[file,image/jpg,image/jpeg,image/png]'  // Verifica el tipo de archivo
            ]
        ];

        $username = $this->request->getPost('username');
        $userId = $this->request->getPost('id_usuario'); // Suponiendo que el ID de usuario está en la sesión
        $file = $this->request->getFile('foto_perfil');
        $userModel = new UserModel();

        $userData = [
            'username' => $this->request->getPost('username'),
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'telefono' => $this->request->getPost('telefono'),
            'linkedin' => $this->request->getPost('linkedin')
        ];

        // Username ya existe, regresar con error
        if ($userModel->usernameExists($username, $userId)) {
            return redirect()->back()->withInput()->with('error', 'El username ya está en uso.');
        }

        log_message('debug', 'controlador: ' . print_r($file, true));
        // Validación del archivo
        if ($file->isValid() && !$this->validate($rules)) {
            $mimeType = $file->getMimeType();
            // Verificar si el tipo MIME es el correcto
            if ($mimeType != 'image/jpeg') {
                return redirect()->to('/editProfile')
                    ->withInput()
                    ->with('error', 'El archivo debe ser una imagen JPG.');
            }
            // Si es válido, guarda el archivo en el formato adecuado
            $userData = array_merge($userData, [
                'foto_perfil' => file_get_contents($file->getTempName())
            ]);
        }
        else {
            return redirect()->back()->withInput()->with('error', 'The image cannot be larger than 2MB');
        };
        

        $updateSuccess = $userModel->update($userId, $userData);
        // Redirigir con mensaje de éxito
        if ($updateSuccess) {
            $session = session();
            // Recuperar los datos actualizados
            $userData = $userModel->find($userId);
            // Actualizar los datos de la sesión
            $session->set($userData);
            return redirect()->to('/editProfile')->with('success', 'Perfil actualizado correctamente');
        }
        else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar');
        };
    }      
}
