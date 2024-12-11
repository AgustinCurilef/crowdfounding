<main class="app-main background-impulsa">
    <div class="hold-transition sidebar-mini d-flex justify-content-center align-items-center" style="min-height: 100vh; padding: 20px;">
        <div class="card shadow-sm" style="width: 100%; max-width: 600px; border-radius: 10px;">
            <div class="card-body">
                <!-- Mensajes de éxito o error -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <!-- Título del proyecto -->
                <h5 class="card-title text-center mb-4"><?= esc($project->NOMBRE) ?></h5>

                <!-- Formulario -->
                <form id="updateProjectForm" action="<?= base_url('saveUpdateProject/' . $project->ID_PROYECTO) ?>" method="POST" enctype="multipart/form-data">
                    <!-- Descripción -->
                    <div class="mb-3">
                        <textarea
                            class="form-control"
                            id="descripcion"
                            name="descripcion"
                            rows="4"
                            placeholder="¿Qué tienes en mente sobre tu proyecto?"
                            style="resize: none; border-radius: 8px;"></textarea>
                    </div>

                    <!-- Imagen de portada -->
                    <div class="text-center mb-4">
                        <div class="upload-preview mb-3" style="position: relative; width: 100%; border-radius: 10px; overflow: hidden; background-color: #f8f9fa;">
                            <img id="imagePreview" src="" alt="Vista previa de imagen" class="img-fluid" style="display: none; width: 100%; height: auto; object-fit: contain;">
                            <div id="uploadIcon" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); display: none;">
                                <i class="fas fa-cloud-upload-alt fa-3x text-muted"></i>
                            </div>
                        </div>
                        <label class="btn btn-outline-secondary btn-sm" for="imageUpload">
                            <i class="fas fa-upload me-2"></i>Seleccionar imagen
                            <input type="file" id="imageUpload" name="portada" accept="image/*" hidden>
                        </label>
                        <div id="error-message" style="color: red; display: none; font-size: 0.9rem;">Por favor, completa al menos uno de los campos: descripción o imagen.</div>
                    </div>

                    <!-- Botones -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= base_url('myprojects') ?>" class="btn btn-secondary btn-sm">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm">
                            Publicar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('updateProjectForm');
        const descripcionField = document.getElementById('descripcion');
        const imageField = document.getElementById('imageUpload');
        const errorMessage = document.getElementById('error-message');
        const imagePreview = document.getElementById('imagePreview');
        const uploadIcon = document.getElementById('uploadIcon');

        // Vista previa de la imagen
        imageField.addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block'; // Muestra la imagen
                    uploadIcon.style.display = 'none'; // Oculta el icono
                };

                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none'; // Oculta la imagen si no hay archivo
                uploadIcon.style.display = 'block'; // Muestra el icono
                imagePreview.src = '';
            }
        });

        // Validar antes de enviar el formulario
        form.addEventListener('submit', (e) => {
            const descripcion = descripcionField.value.trim();
            const imageUploaded = imageField.files.length > 0;

            // Si no hay descripción ni imagen subida
            if (!descripcion && !imageUploaded) {
                e.preventDefault(); // Detiene el envío
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Por favor, completa al menos uno de los campos: descripción o imagen.';
            } else {
                errorMessage.style.display = 'none'; // Oculta el mensaje si es válido
            }
        });
    });
</script>