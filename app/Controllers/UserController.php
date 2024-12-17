<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\CategoryModel;
use App\Models\UserModel;
use App\Models\NotificationUserModel;
use App\Models\PuntuarUsuarioModel;

class UserController extends BaseController
{
    protected $user;

    public function __construct()
    {
        // Inicializa el modelo de usuario una sola vez en el constructor
        $this->user = session()->get();
    }

    public function index(): String
    {
        // Obtener el ID de usuario de la sesión
        $data = ['title' => 'Editar Perfil General', 'user_name' => $this->user['USERNAME']];
        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('estructura/main')
            . view('estructura/footer');
    }

    public function editProfile(): String
    {
        $ProjectModel = new ProjectModel();
        $categoryModel = new CategoryModel();
        $notificationUserModel = new NotificationUserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $projects = $ProjectModel->getProjects();
        $categories = $categoryModel->findAll();

        $data = [
            'title' => 'Editar Perfil',
            'statistics' => $statistics,
            'notificationsUser' => $notificationsUser,
            'projects' => $projects,
            'categories' => $categories,
            'user_name' => $this->user['USERNAME'],
            'user' => $this->user
        ];

        $this->response->setCache([
            'max-age' => 0, // No cache
            'no-store' => true, // No almacenar
        ]);

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('editProfile', $data)
            . view('estructura/footer');
    }

    public function showImage($idUsuario)
    {
        $userModel = new UserModel();
        $imageName = $userModel->getImage($idUsuario); // Obtener imagen BLOB desde el modelo
        $urlImage = WRITEPATH . 'uploads\\profile_pictures\\' . $imageName;

        if ($imageName) {
            // Obtener el tipo MIME de la imagen
            $mime = mime_content_type($urlImage);

            // Leer el contenido de la imagen
            $imageData = file_get_contents($urlImage);

            // Especificar el tipo MIME correcto para imágenes
            return $this->response
                ->setHeader('Content-Type', $mime)
                ->setBody($imageData); // Enviar la imagen al navegador

        } else {
            // Ruta de la imagen por defecto
            $defaultImagePath = WRITEPATH . '../public/template/dist/assets/img/foto_perfil_default.jpg';

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

    public function saveChanges()
    {
        $username = $this->request->getPost('username');
        $userId = $this->request->getPost('id_usuario');
        $file = $this->request->getFile('foto_perfil');
        $userModel = new UserModel();

        $validationRule = [
            'foto_perfil' => [
                'rules' => 'is_image[foto_perfil]|max_size[foto_perfil,2048]|mime_in[foto_perfil,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'El archivo debe ser una imagen válida.',
                    'max_size' => 'El tamaño máximo permitido es de 2 MB.',
                    'mime_in' => 'Solo se permiten imágenes en formato JPG, JPEG o PNG.'
                ]
            ]
        ];

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

        if (!$this->validate($validationRule)) {
            // Obtén los mensajes de error
            $errors = \Config\Services::validation()->getErrors();

            // Muestra los errores o redirige con ellos
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Validación del archivo
        if ($file->getError() !== UPLOAD_ERR_NO_FILE) { // Verifica si el archivo fue cargado
            if ($file->isValid()) {
                $uploadPath = WRITEPATH . 'uploads/profile_pictures/'; // Ruta donde se guardará la imagen
                // Crea el directorio si no existe
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }
                // Verificar si el usuario ya tiene una imagen cargada
                $imageName = $userModel->getImage($userId); // Obtener imagen
                if (empty($imageName)) {
                    $imageName = $file->getRandomName();
                } else {
                    unlink($uploadPath . $imageName);
                }
                // Mueve el archivo al directorio de destino
                if ($file->move($uploadPath, $imageName)) {
                    // Guarda la ruta de la imagen en el campo correspondiente
                    $userData['foto_perfil'] = $imageName;
                } else {
                    return redirect()->back()->withInput()->with('error', 'El archivo subido no es válido.');
                }
            } else {
                return redirect()->back()->withInput()->with('error', 'El archivo subido no es válido.');
            }
        }

        // Actualizar los datos del usuario
        $updateSuccess = $userModel->update($userId, $userData);

        if ($updateSuccess) {
            $session = session();
            $userData = $userModel->find($userId);
            $session->set($userData);
            return redirect()->to('/editProfile')->with('success', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'No se pudo actualizar.');
        }
    }

    public function delete($id)
    {
        $userModel = new UserModel();
        $imageName = $userModel->getImage($id);
        $uploadPath = WRITEPATH . 'uploads/profile_pictures/';
        if ($userModel->delete($id)) {
            if (!empty($imageName)) {
                unlink($uploadPath . $imageName);
            }
            // Mu
            return redirect()->to('/')->with('success', 'Usuario eliminado correctamente.');
        } else {
            return redirect()->to('/editProfile')->with('error', 'No se pudo eliminar el usuario.');
        }
    }

    public function scoreEntrepreneur($nickname_user)
    {
        $userModel = new UserModel();
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $notificationUserModel = new NotificationUserModel();
        $idUsuario = session()->get('ID_USUARIO');
        $emprendedor = $userModel->getUserByNickname($nickname_user);
        $notificationsUser = $notificationUserModel->getRecentNotifications(session()->get('ID_USUARIO'), $limit = 5);
        $statistics = $puntuarUsuarioModel->calculateStatistics(session()->get('ID_USUARIO'));
        $statisticsEmp = $puntuarUsuarioModel->calculateStatistics($emprendedor['ID_USUARIO']);
        $vote = $puntuarUsuarioModel->getVote($emprendedor['ID_USUARIO'], session()->get('ID_USUARIO'));
        $data = [
            'title' => 'Perfil',
            'notificationsUser' => $notificationsUser,
            'mi_voto' => $vote,
            'user_name' => $this->user['USERNAME'],
            'statisticsEmp' => $statisticsEmp,
            'statistics' => $statistics,
            'idUsuario' => $idUsuario,
            'emprendedor' => $emprendedor
        ];

        return view('estructura/header', $data)
            . view('estructura/navbar', $data)
            . view('estructura/sidebar')
            . view('user/scoreEntrepreneur', $data)
            . view('estructura/footer');
    }
    public function submitRating()
    {
        $puntuarUsuarioModel = new PuntuarUsuarioModel();
        $notification = new NotificationUserModel();
        // Obtener datos desde la solicitud
        $request = $this->request->getJSON();

        $puntuador = $request->puntuador;
        $puntuado = $request->puntuado;
        $puntaje = $request->puntaje;

        // Inserta o actualiza el registro
        $data = [
            'ID_USUARIO_PUNTUADOR' => $puntuador,
            'ID_USUARIO_PUNTUADO' => $puntuado,
            'PUNTAJE' => $puntaje
        ];

        $result = $puntuarUsuarioModel->upsert($data);
        if ($result['success'] && $result['operacion'] != 0) {
            // Calcular estadísticas
            $notification->addUserNotification($result['operacion'], $puntuado);
        }




        return $this->response->setJSON($result);

        /*$statistics = $puntuarUsuarioModel->calculateStatistics($puntuado);
        echo json_encode([
            'success' => true,
            'promedio' => round($statistics['promedio'], 1),
            'totalVotos' => $statistics['totalVotos']
        ]);*/
    }
}
