<div class="content-wrapper" style="background: radial-gradient(ellipse, #99CBC8, #199890);">
    <div class="container-fluid mt-4 px-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center bg-light py-3">
                <h4 class="m-0">Realizar Inversión</h4>
            </div>
            <div class="card-body">
                <!-- Mensajes Flash -->
                <?php if (session()->getFlashdata('mensaje')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('mensaje') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Formulario -->
                <form action="<?= base_url('investment/save') ?>" method="POST" class="needs-validation" novalidate>
                    <!-- Información del Proyecto -->
                    <div class="mb-3">
                        <h4>Proyecto: <?= esc($project->NOMBRE) ?></h4>
                        <p class="text-muted"><?= esc($project->DESCRIPCION) ?></p>
                        <p><strong>Presupuesto necesario:</strong> $<?= number_format($project->PRESUPUESTO, 2) ?></p>
                        <p><strong>Fecha límite:</strong> <?= date('d/m/Y', strtotime($project->FECHA_LIMITE)) ?></p>
                        <input type="hidden" name="id_proyecto" value="<?= esc($project->ID_PROYECTO) ?>">
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
                                min="1"
                                required
                                placeholder="Ingrese el monto">
                        </div>
                        <div class="invalid-feedback">Por favor, ingrese un monto válido mayor a 0.</div>
                    </div>

                    <!-- Datos de la Tarjeta -->
                    <h5 class="mt-4">Datos de la Tarjeta</h5>
                    <!-- Tipo de Tarjeta -->
                    <div class="mb-3">
                        <label class="form-label">Tipo de Tarjeta *</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_tarjeta" id="visa" value="Visa" required>
                                <label class="form-check-label" for="visa">Visa</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_tarjeta" id="mastercard" value="Mastercard">
                                <label class="form-check-label" for="mastercard">Mastercard</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_tarjeta" id="amex" value="American Express">
                                <label class="form-check-label" for="amex">American Express</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo_tarjeta" id="mercadopago" value="Mercado Pago">
                                <label class="form-check-label" for="mercadopago">Mercado Pago</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Seleccione un tipo de tarjeta.</div>
                    </div>

                    <div class="mb-3">
                        <label for="nombre_tarjeta" class="form-label">Nombre en la Tarjeta *</label>
                        <input type="text"
                            class="form-control"
                            id="nombre_tarjeta"
                            name="nombre_tarjeta"
                            required
                            placeholder="Nombre completo">
                        <div class="invalid-feedback">Ingrese el nombre tal como aparece en la tarjeta.</div>
                    </div>

                    <div class="mb-3">
                        <label for="numero_tarjeta" class="form-label">Número de la Tarjeta *</label>
                        <input type="text"
                            class="form-control"
                            id="numero_tarjeta"
                            name="numero_tarjeta"
                            required
                            placeholder="1234 5678 9012 3456"
                            pattern="\d{10}">
                        <div class="invalid-feedback">Ingrese un número de tarjeta válido (10 dígitos).</div>
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
                            <div class="invalid-feedback">Ingrese una fecha válida en formato MM/AA.</div>
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
                            <div class="invalid-feedback">Ingrese un CVV válido (3 dígitos).</div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="<?= base_url('inicio') ?>" class="btn btn-secondary me-2">
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
<script>
    // Validaciones personalizadas de Bootstrap
    (function() {
        'use strict'
        // Busca todos los formularios con clase needs-validation
        var forms = document.querySelectorAll('.needs-validation')

        // Recorre y evita que se envíen sin validación
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>