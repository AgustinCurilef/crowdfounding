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
                    <!-- Información del Proyecto -->
                    <div class="mb-3">
                        <h4>Proyecto: <?= $project->NOMBRE ?></h4>
                        <p class="text-muted"><?= $project->DESCRIPCION ?></p>
                        <p>Presupuesto necesario: $<?= number_format($project->PRESUPUESTO, 2) ?></p>
                        <p>Fecha límite: <?= date('d/m/Y', strtotime($project->FECHA_LIMITE)) ?></p>
                        
                        <!-- Campo oculto para el ID del proyecto -->
                        <input type="hidden" name="id_proyecto" value="<?= $project->ID_PROYECTO ?>">
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
                                   step="1.00" 
                                   min="0" 
                                   required
                                   placeholder="0.00">
                        </div>
                        <div class="invalid-feedback">
                            Por favor ingrese un monto válido.
                        </div>
                    </div>

                    <!-- Datos de la Tarjeta -->
                    <h5 class="mt-4">Datos de la Tarjeta</h5>

                    <div class="mb-3">
                        <label for="nombre_tarjeta" class="form-label">Nombre en la Tarjeta *</label>
                        <input type="text" 
                               class="form-control" 
                               id="nombre_tarjeta" 
                               name="nombre_tarjeta" 
                               required 
                               placeholder="Nombre completo">
                        <div class="invalid-feedback">Por favor ingrese el nombre que aparece en la tarjeta.</div>
                    </div>

                    <div class="mb-3">
                        <label for="numero_tarjeta" class="form-label">Número de la Tarjeta *</label>
                        <input type="text" 
                               class="form-control" 
                               id="numero_tarjeta" 
                               name="numero_tarjeta" 
                               required 
                               placeholder="1234 5678" 
                               pattern="\d{8}">
                        <div class="invalid-feedback">Por favor ingrese un número de tarjeta válido (8 dígitos sin espacios).</div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-md-6">
                            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento (MM/AA) *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="fecha_vencimiento" 
                                   name="fecha_vencimiento" 
                                   required 
                                   placeholder="MM/AA" 
                                   pattern="(0[1-9]|1[0-2])\/\d{2}">
                            <div class="invalid-feedback">Por favor ingrese una fecha válida en formato MM/AA.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="clave" class="form-label">CVV *</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="clave" 
                                   name="clave" 
                                   required 
                                   placeholder="123" 
                                   pattern="\d{3}">
                            <div class="invalid-feedback">Por favor ingrese un CVV válido (3 dígitos).</div>
                        </div>
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
