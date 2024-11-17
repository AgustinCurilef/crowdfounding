<main class="app-main">
    <div class="hold-transition sidebar-mini">
        <div class="wrapper">
            <div class="content-wrapper">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Modificar Proyecto</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card project-form-card">
                                    <div class="card-body">
                                        <!-- Mensajes flash de éxito o error -->
                                        <?php if (session()->getFlashdata('success')): ?>
                                            <div class="alert alert-success">
                                                <?= session()->getFlashdata('success'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (session()->getFlashdata('error')): ?>
                                            <div class="alert alert-danger">
                                                <?= session()->getFlashdata('error'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Formulario -->
                                        <form id="projectForm" action="<?= base_url('/updateProject/'. $project->ID_PROYECTO) ?>" method="POST">
                                            <!-- Imagen de portada -->
                                            <div class="text-center mb-4">
                                                <div class="upload-preview mb-3">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <div class="upload-btn-wrapper">
                                                    <label class="upload-btn" for="imageUpload">
                                                        <i class="fas fa-upload mr-2"></i>CARGAR PORTADA
                                                        <input type="file" id="imageUpload" name="PORTADA" accept="image/*" hidden>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Columna izquierda: Nombre, Presupuesto y Fecha -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectName">Nombre del Proyecto</label>
                                                        <input type="text" class="form-control" id="projectName" name="NOMBRE" value="<?= esc($project->NOMBRE) ?>" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="budget">Presupuesto Requerido</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="number" class="form-control" id="budget" name="PRESUPUESTO" value="<?= esc($project->PRESUPUESTO) ?>" min="0" step="0.01" required>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="deadline">Fecha límite</label>
                                                        <input type="datetime-local" class="form-control" id="deadline" name="FECHA_LIMITE" value="<?= date('Y-m-d\TH:i', strtotime($project->FECHA_LIMITE)) ?>" required>
                                                    </div>
                                                </div>

                                                <!-- Columna derecha: Categorías -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Categorías</label>
                                                        <div class="categories-container border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                                            <div class="custom-control custom-checkbox mb-3 border-bottom pb-2">
                                                                <input type="checkbox" 
                                                                       class="custom-control-input" 
                                                                       id="selectAllCategories">
                                                                <label class="custom-control-label font-weight-bold" for="selectAllCategories">
                                                                    Seleccionar todas
                                                                </label>
                                                            </div>

                                                            <?php foreach ($categories as $category) : ?>
                                                                <div class="custom-control custom-checkbox mb-2">
                                                                    <input type="checkbox" 
                                                                        class="custom-control-input category-checkbox" 
                                                                        id="category_<?= esc($category->ID_CATEGORIA) ?>" 
                                                                        name="ID_CATEGORIA[]" 
                                                                        value="<?= esc($category->ID_CATEGORIA) ?>"
                                                                        <?php if (in_array($category->NOMBRE, $selectedCategories)): ?> checked <?php endif; ?>>
                                                                    <label class="custom-control-label" for="category_<?= esc($category->ID_CATEGORIA) ?>">
                                                                        <?= esc($category->NOMBRE) ?>
                                                                    </label>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                        <small class="text-muted mt-1">Seleccionadas: <span id="selectedCount"><?= count($selectedCategories) ?></span> categorías</small>
                                                    </div>
                                                </div>

                                                <!-- Descripción -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="description">Descripción detallada</label>
                                                        <textarea class="form-control" id="description" name="DESCRIPCION" rows="4" required><?= esc($project->DESCRIPCION) ?></textarea>
                                                    </div>
                                                </div>

                                                <!-- Cuarta fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rewards">Plan de recompensa</label>
                                                        <input type="text" class="form-control" id="rewards" name="RECOMPENSAS" value="<?= esc($project->RECOMPENSAS) ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="website">Sitio Web</label>
                                                        <input type="url" class="form-control" id="website" name="SITIO_WEB" value="<?= esc($project->SITIO_WEB) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Campo de estado del proyecto -->
                                            <div class="row mt-4">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Estado del Proyecto</label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ESTADO" id="estadoPublicado" value="1" <?= $project->ESTADO == 1 ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="estadoPublicado">
                                                                Publicado
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="ESTADO" id="estadoOculto" value="0" <?= $project->ESTADO == 0 ? 'checked' : '' ?>>
                                                            <label class="form-check-label" for="estadoOculto">
                                                                Oculto
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Botones de acción -->
                                            <div class="row mt-4">
                                                <div class="col-12 text-right">
                                                    <button type="button" class="btn btn-secondary mr-2" id="cancelButton">
                                                        <i class="fas fa-times mr-2"></i>Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-primary btn-submit">
                                                        <i class="fas fa-check mr-2"></i>Actualizar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview de imagen
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPreviewIcon = document.querySelector('.upload-preview i');

    imageUpload.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
                uploadPreviewIcon.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    });

    // Botón cancelar
    const cancelButton = document.getElementById('cancelButton');
    cancelButton.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas cancelar? Los cambios no guardados se perderán.')) {
            window.history.back();
        }
    });
});
</script>
