<div class="container-fluid"> <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
                    <li class="nav-item d-none d-md-block"> <a href="#" class="nav-link">Home</a> </li>
                </ul> <!--end::Start Navbar Links--> <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto"> <!--begin::Navbar Search-->
                     <!--<li class="nav-item"> <a class="nav-link" data-widget="navbar-search" href="#" role="button"> <i class="bi bi-search"></i> </a> </li> end::Navbar Search-->
                
                         <!--end::Messages Dropdown Menu--> <!--begin::Notifications Dropdown Menu-->
                    <!-- En tu navbar -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" onclick="markNotificationsAsRead()">                            <i class="bi bi-bell-fill"></i>
                            <span class="navbar-badge badge text-bg-warning" id="notification-count">
                                <?= esc(getAmountNotification(session('ID_USUARIO'))) ?>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" id="notification-dropdown">
                            
                            <div class="dropdown-divider"></div>
                            <div id="notification-list">
                                <!-- Las notificaciones se cargarán aquí -->
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
                        <?= esc($user_name) ?> - Web Developer
                    </p>
                </li>
                <!--end::User Image-->
                <!--begin::Menu Body-->
                <li class="user-body"
                >
                    <a href="#" class="btn btn-default btn-flat float-end">Sign out</a> 
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
