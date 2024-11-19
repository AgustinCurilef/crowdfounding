<?php

namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        // Verificar si el usuario ha iniciado sesión
        if (!$session->has('ID_USUARIO')) {
            return redirect()->to(site_url('/login'));
        }

        // Verificar el rol, si se especificó en los argumentos
        if ($arguments !== null && isset($arguments[0])) {
            $requiredRole = $arguments[0]; // Rol requerido
            $userRole = $session->get('ROL'); // Acceso directo al índice 'ROL'

            if ($requiredRole != $userRole) {
                // Redirigir si el rol no coincide
                return redirect()->to(site_url('/unauthorized'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Implementar lógica posterior si es necesario
    }
}
