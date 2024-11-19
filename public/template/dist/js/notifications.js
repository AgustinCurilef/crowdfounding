document.addEventListener('DOMContentLoaded', function() {
    function loadNotifications() {
        // Cargar contador
            fetch('/user/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const count = data.count;
                document.getElementById('notification-count').textContent = count;
                document.getElementById('notification-header').textContent = 
                    `${count} Notificación${count !== 1 ? 'es' : ''}`;
            })
            .catch(error => {
                console.error('Error al cargar el contador:', error);
            });

        // Cargar notificaciones recientes
        fetch('user/notifications/recent')
            .then(response => response.json())
            .then(notifications => {
                const container = document.getElementById('notification-list');
                container.innerHTML = '';

                if (notifications.length === 0) {
                    container.innerHTML = '<div class="dropdown-item">No hay notificaciones nuevas</div>';
                    return;
                }
                
                notifications.forEach(notification => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.className = 'dropdown-item' + 
                        (notification.ESTADO === 'NO_LEIDO' ? ' bg-light' : '');
                    
                    const date = new Date(notification.FECHA);
                    const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                    
                    item.innerHTML = `
                        <div>
                            <strong>${notification.NOMBRE}</strong>
                            <span class="float-end text-secondary fs-7">
                                ${formattedDate}
                            </span>
                        </div>
                        <small>${notification.DESCRIPCION}</small>
                    `;
                    
                    item.onclick = (e) => {
                        e.preventDefault();
                        markAsRead(notification.ID_NOTIFICACION);
                    };
                    
                    container.appendChild(item);
                });
            })
            .catch(error => {
                console.error('Error al cargar las notificaciones:', error);
            });
    }

    function markAsRead(notificationId) {
        fetch(`<?= base_url('user/notifications/mark-read/') ?>${notificationId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
            }
        })
        .catch(error => {
            console.error('Error al marcar como leída:', error);
        });
    }

    // Cargar notificaciones inicialmente
    loadNotifications();

    // Actualizar cada minuto
    setInterval(loadNotifications, 60000);
});