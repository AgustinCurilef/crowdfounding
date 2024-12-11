<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Mis Notificaciones</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if (empty($notificationsUser)) : ?>
                                <p>No tienes notificaciones.</p>
                            <?php else : ?>
                                <div class="list-group">
                                    <?php foreach ($notificationsUser as $notification) : ?>
                                        <div class="list-group-item <?= ($notification['ESTADO'] == 'NO_LEIDO') ? 'list-group-item-warning' : '' ?>">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><?= esc($notification['NOMBRE']) ?></h5>
                                                <small><?= date('d/m/Y H:i', strtotime($notification['FECHA'])) ?></small>
                                            </div>
                                            <p class="mb-1"><?= esc($notification['DESCRIPCION']) ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>