<div class="form-container">
    <div class="card">
        <div class="card-header">
            <h4>Editar Categoría</h4>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('categories/update/' . $category->ID_CATEGORIA) ?>" method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre de la Categoría</label>
                    <input type="text" 
                           class="form-control" 
                           id="nombre" 
                           name="nombre" 
                           value="<?= $category->NOMBRE ?>" 
                           required>
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label>
                    <textarea class="form-control" 
                              id="descripcion" 
                              name="descripcion" 
                              rows="3" 
                              required><?= $category->DESCRIPCION ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Actualizar Categoría</button>
                <a href="<?= base_url('categories/list') ?>" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>