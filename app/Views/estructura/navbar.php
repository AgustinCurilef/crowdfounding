<div class="container-fluid ">
    <!--begin::Start Navbar Links-->
    <ul class="navbar-nav">
        <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
        <li class="nav-item d-none d-md-block"> </li>
    </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
    <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
        <!--<li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> end::Navbar Search-->

        <!--end::Messages Dropdown Menu--> <!--begin::Notifications Dropdown Menu-->
        <!-- En tu navbar -->
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="markNotificationsAsRead()">
                <span id="campanita" class="navbar-badge badge  bi bi-bell-fill" id="notification-count" style="background-color: #99CBC8 ; color: black">
                    <?= esc(getAmountNotification(session('ID_USUARIO'))) ?>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end" id="notification-dropdown" style="width: 400px;">
                <div class="dropdown-divider"></div>
                <div id="notification-list" >
                    <!-- Las notificaciones se cargarán aquí -->
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
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                </div>
                <div class="dropdown-divider"></div>
                <a href="<?= base_url('user/notifications') ?>" class="dropdown-item dropdown-footer">
                    Ver todas las notificaciones
                </a>
            </div>
        </li>
        </li> <!--end::Notifications Dropdown Menu--> <!--begin::Fullscreen Toggle-->
        <li class="nav-item">
            <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
            </a>
        </li> <!--end::Fullscreen Toggle-->
        <!--begin::User Menu Dropdown-->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                <img src="<?= base_url('user/showImage/' . session()->get('ID_USUARIO')); ?>" class="user-image rounded-circle shadow" alt="User Image">
                <!-- Aquí se reemplaza 'Alexander Pierce' con la variable PHP -->
                <span class="d-none d-md-inline"><?= esc($user_name) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                <!--begin::User Image-->
                <li class="user-header text-bg-primary">
                    <img src="<?= base_url('user/showImage/' . session()->get('ID_USUARIO')); ?>" class="rounded-circle shadow" alt="User Image">
                    <p>
                        <!-- Aquí también utilizas la variable para mostrar el nombre -->
                        <?= esc($user_name) ?>

                    <div class="d-flex justify-content-center align-items-center">
                        <div class="star-rating average-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                        </div>
                        <span class="ms-2 average-rating">(4.2)</span>
                    </div>
                    </p>
                </li>

                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body">
                    <a href="<?= base_url('/logout') ?>" class="btn btn-default btn-flat float-end">Sign out</a>
                </li>
                <!--end::Menu Body-->
            </ul>
        </li> <!--end::User Menu Dropdown--
                </ul> --end::End Navbar Links-->
</div> <!--end::Container-->
</nav> <!--end::Header--> <!--begin::Sidebar-->

<script>
    function markNotificationsAsRead() {
        fetch('<?= base_url('notification/mark-read') ?>', {

                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest' // Para identificar que es una solicitud AJAX
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log('Notificaciones marcadas como leídas');
                    // Opcional: Actualizar el contador en la interfaz
                    document.getElementById('notification-count').textContent = '0';
                } else {
                    console.error('Error al marcar notificaciones como leídas:', data.message);
                }
            })
            .catch(error => console.error('Error en la solicitud:', error));
    }
</script>