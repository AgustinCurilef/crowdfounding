<main class="app-main updates-page">
    <div class="container">
        <h1 class="text-center my-4">Actualizaciones del Proyecto</h1>

        <?php if (!empty($updates)) : ?>
            <?php foreach ($updates as $update) : ?>
                <div class="update-item mb-4 p-3 border rounded">
                    <div class="row">
                        <div class="col-md-2">
                            <img src="<?= base_url($update['photo']) ?>" alt="Foto de actualización" class="img-fluid rounded">
                        </div>
                        <div class="col-md-10">
                            <h5><?= esc($update['author']) ?></h5>
                            <small class="text-muted"><?= esc($update['date']) ?></small>
                            <p class="mt-2"><?= esc($update['description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="text-center">No hay actualizaciones disponibles.</p>
        <?php endif; ?>
    </div>
</main>