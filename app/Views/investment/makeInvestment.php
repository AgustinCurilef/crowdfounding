<div class="content-wrapper">
    <div class="container-fluid mt-4 px-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                <h4 class="m-0">Realizar Inversión</h4>
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

                <form action="<?= base_url('investment/save') ?>" method="POST" class="needs-validation" novalidate>
                    <!-- Selector de Proyecto -->
                    <div class="mb-3">
                        <label for="proyecto" class="form-label">Proyecto *</label>
                        <select class="form-select" id="proyecto" name="id_proyecto" required>
                            <option value="">Seleccione un proyecto</option>
                            <?php foreach ($proyectos as $proyecto): ?>
                                <option value="<?= $proyecto->ID_PROYECTO ?>">
                                    <?= $proyecto->NOMBRE ?> - <?= $proyecto->DESCRIPCION ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un proyecto.
                        </div>
                    </div>

                    <!-- Campo para el monto -->
                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto a Invertir (USD) *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" 
                                   class="form-control" 
                                   id="monto" 
                                   name="monto" 
                                   step="0.01" 
                                   min="0" 
                                   required
                                   placeholder="0.00">
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese un monto válido.
                        </div>
                    </div>

                    <!-- Información adicional -->
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> La inversión quedará en estado "Pendiente" hasta su aprobación.
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('investment') ?>" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Realizar Inversión
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>