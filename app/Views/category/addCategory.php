<div class="container">
    <div class="row">
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h4>Agregar Nueva Categoría</h4>
                </div>
                <div class="card-body">
                    <?php if(session()->getFlashdata('mensaje')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('mensaje') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('categories/save') ?>" method="POST">
                        <div class="form-group">
                            <label for="nombre">Nombre de la Categoría</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar Categoría</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>