<main class="app-main background-impulsa">
    <div class="container mt-4" style="min-height: calc(100vh - 200px); ">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Notificaciones</h3>
                <a href="<?= base_url('notification/create') ?>" class="btn btn-primary">
                    Crear Notificación
                </a>
            </div>
            <div class="card-body">
                <?php if (session()->getFlashdata('mensaje')): ?>
                    <div class="alert alert-success">
                        <?= session()->getFlashdata('mensaje') ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($notifications)): ?>
                    <p>No hay notificaciones registradas.</p>
                <?php else: ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifications as $notification): ?>
                                <tr>
                                    <td><?= $notification['ID_NOTIFICACION'] ?></td>
                                    <td><?= $notification['NOMBRE'] ?></td>
                                    <td><?= $notification['DESCRIPCION'] ?></td>
                                    <td>
                                        <a href="<?= base_url('notification/edit/' . $notification['ID_NOTIFICACION']) ?>" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('notification/delete/' . $notification['ID_NOTIFICACION']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar esta notificación?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>