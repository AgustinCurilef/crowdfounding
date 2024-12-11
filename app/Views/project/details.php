<main class="app-main background-impulsa">
    <div class="hold-transition sidebar-mini" style="padding: 20px;">

        <!-- Información del proyecto -->
        <div class="project-details mb-5">

            <div class="d-flex align-items-center mb-3">
                <!-- Foto de perfil -->
                <div class="profile-img me-3">
                    <img src="<?= base_url('project/showFront/' . $project->ID_PROYECTO) ?>"
                        alt="Portada Proyecto" class="rounded-block" width="75" height="75">
                </div>
                <h1 class="text-primary"><?= esc($project->NOMBRE) ?></h1>
            </div>


            <p><strong>Emprendedor: </strong><span class="text-secondary"> <a href="<?= base_url('profile/' . urlencode($emprendedor['USERNAME'])) ?>" class="text-decoration-none">
                        <strong class="text-primary"><?= esc($emprendedor['USERNAME']) ?></strong>
                    </a></span></p>
            <p><strong>Presupuesto: </strong><span class="text-success"><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</span></p>
            <p><strong>Fecha Límite: </strong><span class="text-muted"><?= esc($project->FECHA_LIMITE) ?></span></p>
            <p><strong>Descripción: </strong><span class="text-secondary"><?= esc($project->DESCRIPCION) ?></span></p>


        </div>



        <!-- Lista de actualizaciones -->
        <div class="updates">
            <?php if (!empty($updates)): ?>
                <?php foreach ($updates as $update): ?>
                    <div class="update mb-4 p-4 border border-light rounded-3 shadow-lg bg-white mx-auto">
                        <!-- Cabecera -->
                        <div class="d-flex align-items-center mb-3">
                            <!-- Foto de perfil -->
                            <div class="profile-img me-3">
                                <img src="<?= base_url('user/showImage/' . esc($emprendedor['ID_USUARIO'])); ?>"
                                    alt="Foto de perfil" class="rounded-circle" width="50" height="50">
                            </div>
                            <!-- Nombre de usuario y fecha -->
                            <div class="d-flex flex-column">
                                <a href="<?= base_url('profile/' . urlencode($emprendedor['USERNAME'])) ?>" class="text-decoration-none">
                                    <strong class="text-primary"><?= esc($emprendedor['USERNAME']) ?></strong>
                                </a>
                                <span class="text-muted"><?= esc($update['FECHA']) ?></span>
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
                <div class="update mb-4 p-4 border border-light rounded-3 shadow-lg bg-white mx-auto">
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

    .updates {
        margin-top: 30px;
        max-width: 900px;
        /* Ajusta el ancho de las actualizaciones */
    }

    .update {
        border: 1px solid #e1e4e8;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background-color: #f9f9f9;
        transition: transform 0.3s ease-in-out;
        max-width: 800px;
    }



    .profile-img img {
        object-fit: cover;
        border: 2px solid #e1e4e8;
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

    .update-footer a {
        font-size: 0.9rem;
        transition: background-color 0.2s ease;
    }

    .update-footer a:hover {
        background-color: #e7f0fe;
    }

    .update-image img {
        max-height: 500px;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
</style>