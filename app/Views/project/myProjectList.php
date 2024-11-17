<main class="app-main">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Filters and Search -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Filtros</h3>
                        <button class="btn btn-primary" onclick="window.location.href='<?= base_url('/addProyect') ?>'">
                            <i class="fas fa-plus"></i> Nuevo Proyecto
                        </button>


                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-select" id="categoryFilter" onchange="filterProjects()">
                                    <option value="todos">Todos</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= esc($category->NOMBRE) ?>"><?= esc($category->NOMBRE) ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-control select2" id="statusFilter" onchange="filterProjects()">
                                    <option value="todos">Todos</option>
                                    <option value="0">Publico</option>
                                    <option value="1">Oculto</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Buscar</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar proyectos..." oninput="filterProjects()">
                                    <div class="input-group-append">
                                        <button class="btn btn-default" type="button">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Projects Grid -->
            <div class="row row-cols-1 row-cols-md-3 g-4" id="projectsGrid">
                <?php foreach ($projects as $project) : ?>
                    <!-- Project Card Template -->
                    <div class="project-card" data-categories="<?= esc(implode(',', $project->categoria_nombre)) ?>" data-status="<?= esc($project->ESTADO) ?>" data-name="<?= esc($project->NOMBRE) ?>">


                        <div class="card h-100">
                            <img class="card-img-top" src="data:image/jpeg;base64,<?= esc($project->imagen_base64) ?>" alt="Project Image">
                            <div class="card-body">
                                <!-- Nombre y Presupuesto -->
                                <div class="mb-3">
                                    <span class="fw-bold">Nombre del Proyecto: </span><?= esc($project->NOMBRE) ?><br>
                                    <span class="fw-semibold">Objetivo: </span><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $
                                </div>

                                <?php
                                // Variables para cálculo
                                $presupuesto = isset($project->PRESUPUESTO) ? (float)$project->PRESUPUESTO : 0;
                                $recaudado = isset($project->monto_recaudado) ? (float)str_replace(',', '.', $project->monto_recaudado) : 0;

                                // Calcular el porcentaje de recaudación
                                $porcentaje = $presupuesto > 0 ? ($recaudado / $presupuesto) * 100 : 0;
                                $porcentaje = min(max($porcentaje, 0), 100);
                                ?>


                                <!-- Monto recaudado -->
                                <div class="text-center mb-2">
                                    <span class="text-muted">Recaudado: </span>
                                    <strong><?= number_format($project->monto_recaudado, 2, ',', '.') ?> $</strong>
                                    <span class="text-muted"> de </span>
                                    <strong><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</strong>
                                </div>

                                <!-- Barra de progreso -->
                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: <?= round($porcentaje, 1) ?>%"
                                        aria-valuenow="<?= round($porcentaje, 1) ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= round($porcentaje, 1) ?>%
                                    </div>
                                </div>

                                <!-- Descripción truncada -->
                                <div class="mt-2">
                                    <span class="text-muted">Descripción: </span><br>
                                    <div class="description-truncate">
                                        <?= esc(strlen($project->DESCRIPCION) > 80 ? substr($project->DESCRIPCION, 0, 80) . '...' : $project->DESCRIPCION) ?>
                                    </div>

                                    <?php if (strlen($project->DESCRIPCION) > 80): ?>
                                        <button type="button" class="btn btn-link p-0 mt-2" data-bs-toggle="modal" data-bs-target="#modal-<?= $project->ID_PROYECTO ?>">
                                            Ver más...
                                        </button>
                                    <?php endif; ?>


                                </div>

                                <!-- Modal para la descripción completa -->
                                <div class="modal fade" id="modal-<?= $project->ID_PROYECTO ?>" tabindex="-1" aria-labelledby="modalLabel-<?= $project->ID_PROYECTO ?>" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalLabel-<?= $project->ID_PROYECTO ?>"><?= esc($project->NOMBRE) ?></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <h6 class="text-muted">Descripción completa:</h6>
                                                <p><?= esc($project->DESCRIPCION) ?></p>

                                                <!-- Información adicional en el modal -->
                                                <h6 class="text-muted mt-3">Detalles del proyecto:</h6>
                                                <p>Presupuesto total: <?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</p>
                                                <p>Monto recaudado: <?= number_format($project->monto_recaudado, 2, ',', '.') ?> $</p>
                                                <div class="progress mb-2">
                                                    <div class="progress-bar bg-success"
                                                        role="progressbar"
                                                        style="width: <?= round($porcentaje, 1) ?>%"
                                                        aria-valuenow="<?= round($porcentaje, 1) ?>"
                                                        aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        <?= round($porcentaje, 1) ?>%
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Footer con categorías y botones -->
                            <div class="card-footer d-flex justify-content-between align-items-center flex-column">
                                <!-- Categorías -->
                                <div class="categories">
                                    <?php foreach ($project->categoria_nombre as $categoria) : ?>
                                        <span class="badge bg-primary"><?= esc($categoria) ?></span>
                                    <?php endforeach; ?>

                                    <!-- Ver más si hay más de 5 categorías -->
                                    <?php if (count($project->categoria_nombre) > 5) : ?>
                                        <button class="btn btn-sm btn-link" onclick="toggleCategories()">Ver más</button>
                                        <div id="extraCategories" style="display: none;">
                                            <?php
                                            $extraCategories = array_slice($project->categoria_nombre, 5);
                                            foreach ($extraCategories as $categoria) :
                                            ?>
                                                <span class="badge bg-primary"><?= esc($categoria) ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- Botones de acción -->
                                <div class="btn-group">
                                    <a href="<?= base_url('modifyProject/' . $project->ID_PROYECTO) ?>" class="btn btn-sm btn-info">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete('<?= base_url('deleteProject/' . $project->ID_PROYECTO) ?>')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>



                        </div>
                    </div>
                <?php endforeach; ?>
            </div>




            <!-- Pagination -->
            <div class="row mt-4">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <!-- Botón Anterior -->
                            <?php if ($currentPage > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage - 1 ?>" tabindex="-1">Anterior</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1">Anterior</a>
                                </li>
                            <?php endif; ?>

                            <!-- Páginas -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($currentPage == $i) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Botón Siguiente -->
                            <?php if ($currentPage < $totalPages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Siguiente</a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#">Siguiente</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                </div>
            </div>


        </div>
    </section>

</main>

<script>
    //nos permite filtrar los proyectos basados en la categoría seleccionada
    function filterProjects() {
        const selectedCategory = document.getElementById('categoryFilter').value.toLowerCase().trim();
        const selectedStatus = document.getElementById('statusFilter').value.toLowerCase().trim();
        const nameCard = document.getElementById('searchInput').value.toLowerCase().trim();
        const projectCards = document.querySelectorAll('.project-card');

        projectCards.forEach(card => {
            // Validar los datasets de las tarjetas
            const categories = card.dataset.categories ?
                card.dataset.categories.replace(/\s+/g, ' ').split(',').map(cat => cat.toLowerCase().trim()) : [];
            const projectName = card.dataset.name ? card.dataset.name.toLowerCase() : '';
            const projectStatus = card.dataset.status ? card.dataset.status.toLowerCase() : '';
            console.log('Nombre ingresado:', nameCard);
            console.log('Nombre del proyecto:', projectName);
            // Verificar si cumple con los filtros
            const matchesCategory = selectedCategory === 'todos' || categories.includes(selectedCategory);
            const matchesStatus = selectedStatus === 'todos' || projectStatus === selectedStatus;
            const matchesName = nameCard === '' || projectName.startsWith(nameCard);



            // Mostrar u ocultar la tarjeta
            card.style.display = matchesCategory && matchesStatus && matchesName ? '' : 'none';
        });
    }





    // Llamar a la función al cargar la página para aplicar cualquier filtro inicial
    document.addEventListener('DOMContentLoaded', filterProjects);

    function confirmDelete(url) {
        if (confirm('¿Estás seguro de que deseas eliminar este proyecto? Esta acción no se puede deshacer.')) {
            // Si el usuario confirma, redirige a la URL de eliminación
            window.location.href = url;
        }
        // Si el usuario cancela, no pasa nada
    }

    // Función para mostrar/ocultar las categorías adicionales
    function toggleCategories() {
        var extraCategories = document.getElementById('extraCategories');
        var button = document.querySelector('.btn-link');
        if (extraCategories.style.display === "none") {
            extraCategories.style.display = "block";
            button.textContent = "Ver menos"; // Cambiar texto del botón
        } else {
            extraCategories.style.display = "none";
            button.textContent = "Ver más"; // Volver al texto original
        }
    }
</script>