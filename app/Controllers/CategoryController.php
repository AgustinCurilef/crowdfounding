<?php
namespace App\Controllers;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function index(): string
    {
        // Cambiamos el index para que muestre el listado
        $categoryModel = new CategoryModel();
        $data = [
            'title' => 'Lista de Categorías',
            'categories' => $categoryModel->findAll()
        ];
        $session = session();
        $data['user_name'] = $session->get('user_name');
       
        return view('estructura/header', $data)
            . view('estructura/navbar')
            . view('estructura/sidebar')
            . view('category/listCategories', $data)
            . view('estructura/footer');
    }

    public function create(): string
    {
        // Movemos la funcionalidad de agregar a un nuevo método
        $data = ['title' => 'Agregar Categoría'];
        $session = session();
        $data['user_name'] = $session->get('user_name');
        return view('estructura/header', $data)
            . view('estructura/navbar')
            . view('estructura/sidebar')
            . view('category/addCategory')
            . view('estructura/footer');
    }

    // El resto de métodos permanecen igual
    public function save()
    {
        $categoryModel = new CategoryModel();
       
        $data = [
            'NOMBRE' => $this->request->getPost('nombre'),
            'DESCRIPCION' => $this->request->getPost('descripcion')
        ];
        if ($categoryModel->insert($data)) {
            return redirect()->to('/categories')->with('mensaje', 'Categoría agregada exitosamente');
        } else {
            return redirect()->to('/categories/create')->with('error', 'Error al agregar la categoría');
        }
    }

    public function edit($id)
    {
        $categoryModel = new CategoryModel();
        $data = [
            'title' => 'Editar Categoría',
            'category' => $categoryModel->find($id)
        ];
       
        return view('estructura/header', $data)
            . view('estructura/navbar')
            . view('estructura/sidebar')
            . view('category/editCategory', $data)
            . view('estructura/footer');
    }

    public function update($id)
    {
        $categoryModel = new CategoryModel();
       
        $data = [
            'NOMBRE' => $this->request->getPost('nombre'),
            'DESCRIPCION' => $this->request->getPost('descripcion')
        ];
        if ($categoryModel->update($id, $data)) {
            return redirect()->to('/categories')->with('mensaje', 'Categoría actualizada exitosamente');
        } else {
            return redirect()->to('/categories/edit/' . $id)->with('error', 'Error al actualizar la categoría');
        }
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();
       
        if ($categoryModel->delete($id)) {
            return redirect()->to('/categories')->with('mensaje', 'Categoría eliminada exitosamente');
        } else {
            return redirect()->to('/categories')->with('error', 'Error al eliminar la categoría');
        }
    }
}