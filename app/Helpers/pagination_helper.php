<?php

if (!function_exists('paginateArray')) {
    /**
     * Paginación para arrays.
     *
     * @param array $data Los datos a paginar.
     * @param int $perPage Número de elementos por página.
     * @param int $currentPage Página actual.
     * @return array Datos de la página solicitada junto con la información de paginación.
     */
    function paginateArray($data, $perPage = 10, $currentPage = 1)
    {
        // Calcular el total de elementos
        $totalItems = count($data);

        // Calcular el desplazamiento (offset) para la página solicitada
        $offset = ($currentPage - 1) * $perPage;

        // Obtener los elementos para la página actual
        $items = array_slice($data, $offset, $perPage);

        // Retornar los datos de la paginación con la clave 'data'
        return [
            'data' => $items,  // Cambié 'items' a 'data'
            'currentPage' => $currentPage,
            'totalPages' => ceil($totalItems / $perPage),
            'totalItems' => $totalItems,
        ];
    }
}
