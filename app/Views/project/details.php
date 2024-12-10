<main class="app-main background-impulsa">
    <div class="hold-transition sidebar-mini" style="padding: 20px;">
        <h1 class="mb-4">Detalles del Proyecto</h1>

        <!-- Información del proyecto -->
        <div class="project-details mb-5">
            <h2 class="text-primary"><?= esc($project->NOMBRE) ?></h2>
            <p><strong>Presupuesto: </strong><span class="text-success"><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</span></p>
            <p><strong>Fecha Límite: </strong><span class="text-muted"><?= esc($project->FECHA_LIMITE) ?></span></p>
            <p><strong>Descripción: </strong><span class="text-secondary"><?= esc($project->DESCRIPCION) ?></span></p>
            <!-- Otras propiedades del proyecto -->
        </div>

        <h3 class="mb-3">Actualizaciones del Proyecto</h3>

        <!-- Lista de actualizaciones -->
        <div class="updates">
            <?php if (!empty($updates)): ?>
                <?php foreach ($updates as $update): ?>
                    <div class="update mb-4 p-4 border border-light rounded-3 shadow-lg bg-white">
                        <!-- Cabecera -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="update-header">
                                <strong class="text-primary"><?= esc($project->USERNAME_USUARIO) ?> </strong>
                                <span class="text-muted"> - <?= esc($update['FECHA']) ?></span>
                            </div>

                        </div>

                        <!-- Cuerpo de la actualización -->
                        <div class="update-body mb-3">
                            <p class="text-dark"><?= esc($update['DESCRIPCION']) ?></p>
                            <?php if ($update['NOMBRE_IMAGEN']): ?>
                                <div class="update-image mt-3">
                                    <img src="<?= base_url('project/showFrontUpdates/' . $update['ID_PROYECTO'] . '/' . $update['ID_USUARIO'] . '/' . date('Y-m-d H:i:s', strtotime($update['FECHA']))); ?>" alt="Imagen de actualización" class="img-fluid rounded-3 shadow-sm">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Pie de la publicación -->
                        <div class="update-footer d-flex justify-content-start mt-3">
                            <!-- Botón para invertir -->
                            <a href="<?= base_url('investment/create/' . $project->ID_PROYECTO) ?>"
                                class="btn btn-outline-primary btn-sm me-2">
                                Invertir
                            </a>

                            <!-- Botón para puntuar emprendedor -->
                            <a href="<?= base_url('profile/' . urlencode($project->USERNAME_USUARIO)) ?>"
                                class="btn btn-outline-danger btn-sm">
                                Puntuar Emprendedor
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="update mb-4 p-4 border border-light rounded-3 shadow-lg bg-white">

                    <p>No hay actualizaciones disponibles para este proyecto.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<!-- Estilos personalizados -->
<style>
    .app-main {
        background-color: #f4f7fc;
    }

    .project-details {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .update {
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        transition: transform 0.3s ease-in-out;
    }



    .update-header strong {
        font-size: 1.1rem;
        color: #007bff;
    }

    .update-body p {
        font-size: 1rem;
        color: #333;
        line-height: 1.5;
    }

    .update-footer button {
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }

    .update-footer button:hover {
        background-color: #e7f0fe;
    }

    .update-image img {
        max-height: 500px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }



    .updates {
        margin-top: 30px;
    }

    .update-actions button {
        font-size: 0.9rem;
        color: #6c757d;
    }
</style>