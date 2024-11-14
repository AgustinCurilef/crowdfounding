<div class="content-wrapper">
    <div class="container-fluid mt-4 px-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                <h4 class="m-0">Lista de Categorías</h4>
                <a href="<?= base_url('categories/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Agregar Nueva Categoría
                </a>
            </div>
            <div class="card-body">
                <?php if(session()->getFlashdata('mensaje')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('mensaje') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4" style="width: 10%">ID</th>
                                <th class="px-4" style="width: 25%">Nombre</th>
                                <th class="px-4" style="width: 45%">Descripción</th>
                                <th class="px-4" style="width: 20%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td class="px-4"><?= $category->ID_CATEGORIA ?></td>
                                        <td class="px-4"><?= $category->NOMBRE ?></td>
                                        <td class="px-4"><?= $category->DESCRIPCION ?></td>
                                        <td class="px-4">
                                            <div class="btn-group" role="group">
                                                <a href="<?= base_url('categories/edit/' . $category->ID_CATEGORIA) ?>"
                                                   class="btn btn-warning btn-sm me-2">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <a href="<?= base_url('categories/delete/' . $category->ID_CATEGORIA) ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('¿Estás seguro de que deseas eliminar esta categoría?')">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-3">No hay categorías registradas.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>