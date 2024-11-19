<div class="container mt-4 mb-4" style="min-height: calc(100vh - 200px);">
    <div class="row">
        <div class="form-container">
            <div class="card">
                <div class="card-header">
                    <h4>Agregar Nueva Notificacion</h4>
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
                    <form action="<?= isset($notification) ? base_url('notification/update/' . $notification['ID_NOTIFICACION']) : base_url('notification/save') ?>" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text"
                                class="form-control"
                                id="nombre"
                                name="nombre"
                                value="<?= isset($notification) ? esc($notification['NOMBRE']) : '' ?>"
                                required
                                placeholder="Ingrese el nombre de la notificación">
                            <div class="invalid-feedback">
                                Por favor ingrese un nombre para la notificación.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea
                                class="form-control"
                                id="descripcion"
                                name="descripcion"
                                rows="4"
                                placeholder="Descripción de la notificación"><?= isset($notification) ? esc($notification['DESCRIPCION']) : '' ?></textarea>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('notification') ?>" class="btn btn-secondary me-md-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <?= isset($notification) ? 'Actualizar Notificación' : 'Guardar Notificación' ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>