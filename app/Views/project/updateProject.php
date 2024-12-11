<main class="app-main updates-page" style="background-color: #f8f9fa; padding: 20px 0;">
    <div class="container">
        <h1 class="text-center my-4">Actualizaciones del Proyecto</h1>

        <?php if (!empty($updates)) : ?>
            <div class="d-flex flex-column align-items-center">
                <?php foreach ($updates as $update) : ?>
                    <div class="update-item mb-4 p-4 shadow-sm bg-white rounded"
                        style="width: 60%; max-width: 600px;">
                        <!-- Cabecera: Foto de perfil y autor -->
                        <div class="d-flex align-items-center mb-3">
                            <!-- Foto de perfil del autor -->
                            <img
                                src="<?= base_url($update['profile_photo']) ?>"
                                alt="Foto del autor"
                                class="img-fluid rounded-circle me-2"
                                style="width: 40px; height: 40px; object-fit: cover;">

                            <!-- Nombre del autor y fecha -->
                            <div>
                                <h6 class="mb-0"><?= esc($update['author']) ?></h6>
                                <small class="text-muted"><?= esc($update['date']) ?></small>
                            </div>
                        </div>

                        <!-- Imagen de la actualización -->
                        <div class="mb-3 text-center">
                            <img
                                src="<?= base_url($update['photo']) ?>"
                                alt="Foto de actualización"
                                class="img-fluid rounded"
                                style="max-width: 100%; height: 250px; object-fit: cover;">
                        </div>

                        <!-- Descripción de la actualización -->
                        <p><?= esc($update['description']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else : ?>
            <p class="text-center text-muted">No hay actualizaciones disponibles.</p>
        <?php endif; ?>
    </div>
</main>