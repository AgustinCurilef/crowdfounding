<main class="app-main">
    <div class="hold-transition sidebar-mini">
        <div class="wrapper">
            <div class="content-wrapper">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Alta de Proyecto</h1>
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
                                        <form id="projectForm">
                                            <!-- Imagen de portada -->
                                            <div class="text-center mb-4">
                                                <div class="upload-preview mb-3">
                                                    <img id="imagePreview" src="" alt="Vista previa de imagen">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                </div>
                                                <div class="upload-btn-wrapper">
                                                    <label class="upload-btn" for="imageUpload">
                                                        <i class="fas fa-upload mr-2"></i>CARGAR PORTADA
                                                        <input type="file" id="imageUpload" accept="image/*" hidden>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Primera fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectName">Nombre del Proyecto</label>
                                                        <input type="text" class="form-control" id="projectName" name="projectName" placeholder="Nombre del Proyecto" required>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="category">Categoría</label>
                                                        <select class="form-control" id="category" name="category" required>
                                                            <option value="">Selecciona una categoría</option>
                                                            <option value="tech">Tecnología</option>
                                                            <option value="art">Arte</option>
                                                            <option value="education">Educación</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Segunda fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="budget">Presupuesto Requerido</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="number" class="form-control" id="budget" name="budget" placeholder="0.00" min="0" step="0.01" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="deadline">Fecha límite</label>
                                                        <input type="datetime-local" class="form-control" id="deadline" name="deadline" required>
                                                    </div>
                                                </div>

                                                <!-- Tercera fila -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="objective">Objetivo / Impacto esperado</label>
                                                        <input type="text" class="form-control" id="objective" name="objective" placeholder="Describe el objetivo principal del proyecto" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="description">Descripción detallada</label>
                                                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Describe los detalles de tu proyecto" required></textarea>
                                                    </div>
                                                </div>

                                                <!-- Cuarta fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rewards">Plan de recompensa</label>
                                                        <input type="text" class="form-control" id="rewards" name="rewards" placeholder="Describe las recompensas para los patrocinadores">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="website">Sitio Web</label>
                                                        <input type="url" class="form-control" id="website" name="website" placeholder="https://">
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
                                                        <i class="fas fa-check mr-2"></i>Confirmar
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

    // Manejo del formulario
    const projectForm = document.getElementById('projectForm');
    projectForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Aquí puedes agregar la lógica de validación y envío del formulario
        console.log('Formulario enviado');
    });

    // Botón cancelar
    const cancelButton = document.getElementById('cancelButton');
    cancelButton.addEventListener('click', function() {
        if (confirm('¿Estás seguro de que deseas cancelar? Los cambios no guardados se perderán.')) {
            // Aquí puedes agregar la lógica para manejar la cancelación
            projectForm.reset();
            imagePreview.style.display = 'none';
            uploadPreviewIcon.style.display = 'block';
        }
    });
});
</script>