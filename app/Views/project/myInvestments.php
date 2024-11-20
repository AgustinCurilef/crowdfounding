<main class="app-main">
    <section class="content">
        <div class="container-fluid">
            <!-- Filtros y Búsqueda -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Filtros</h3>
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
                                    <option value="1">Publico</option>
                                    <option value="0">Oculto</option>
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
                    <div class="col">
                        <div class="card h-100" data-status="<?= esc($project->ESTADO) ?>">
                            <?php if (isset($project->imagen_base64)) : ?>
                                <img class="card-img-top" src="data:image/jpeg;base64,<?= esc($project->imagen_base64) ?>" alt="Project Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="text-muted">Nombre del Proyecto: </span><?= esc($project->NOMBRE) ?><br>
                                    <span class="text-muted">Presupuesto total: </span><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $
                                </div>

                                <div class="mb-2">
                                    <span class="text-muted">Mi inversión: </span>
                                    <span class="text-success"><?= number_format($project->monto_invertido, 2, ',', '.') ?> $</span>
                                </div>

                                <div class="progress mb-2">
                                    <div class="progress-bar bg-success"
                                        role="progressbar"
                                        style="width: <?= min(100, round($project->porcentaje_progreso, 1)) ?>%"
                                        aria-valuenow="<?= round($project->porcentaje_progreso, 1) ?>"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        <?= round($project->porcentaje_progreso, 1) ?>%
                                    </div>
                                </div>

                                <div class="text-center mb-2">
                                    <span class="text-muted">Recaudado: </span>
                                    <strong><?= number_format($project->monto_recaudado, 2, ',', '.') ?> $</strong>
                                    <span class="text-muted"> de </span>
                                    <strong><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</strong>
                                </div>

                                <div class="mt-2">
                                    <span class="text-muted">Descripción: </span><br>
                                    <?= esc($project->DESCRIPCION) ?>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between align-items-center">
                                <?php foreach ($project->categoria_nombre as $categoria) : ?>
                                    <span class="badge bg-primary"><?= esc($categoria) ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<script>
    function filterProjects() {
        // Obtener valores de los filtros
        const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const searchQuery = document.getElementById('searchInput').value.toLowerCase();

        // Obtener todos los proyectos
        const projectCards = document.querySelectorAll('#projectsGrid .col');
        let visibleCount = 0; // Contador para proyectos visibles

        projectCards.forEach(card => {
            let showProject = true;
            const projectCard = card.querySelector('.card');
            const projectContent = projectCard.textContent.toLowerCase();
            const projectCategories = Array.from(projectCard.querySelectorAll('.badge'))
                .map(badge => badge.textContent.toLowerCase());
            const projectStatus = projectCard.getAttribute('data-status');

            // Filtrar por categoría
            if (categoryFilter !== 'todos' && !projectCategories.includes(categoryFilter)) {
                showProject = false;
            }

            // Filtrar por estado
            if (statusFilter !== 'todos' && projectStatus !== statusFilter) {
                showProject = false;
            }

            // Filtrar por búsqueda de texto
            if (searchQuery && !projectContent.includes(searchQuery)) {
                showProject = false;
            }

            // Mostrar u ocultar el proyecto
            card.style.display = showProject ? '' : 'none';
            if (showProject) visibleCount++; // Incrementar contador si el proyecto es visible
        });

        // Comprobar si hay resultados visibles usando el contador
        const noResultsMessage = document.getElementById('noResultsMessage') || createNoResultsMessage();
        if (visibleCount === 0) {
            noResultsMessage.style.display = 'block';
        } else {
            noResultsMessage.style.display = 'none';
        }
    }

    function createNoResultsMessage() {
        const message = document.createElement('div');
        message.id = 'noResultsMessage';
        message.className = 'col-12 text-center mt-4';
        message.innerHTML = '<h4>No se encontraron proyectos que coincidan con los filtros seleccionados</h4>';

        const grid = document.getElementById('projectsGrid');
        grid.appendChild(message); // Cambiado a appendChild para asegurar la posición correcta

        return message;
    }

    // Asegurarnos de que el mensaje no aparezca al cargar la página si hay proyectos
    document.addEventListener('DOMContentLoaded', () => {
        // Solo inicializar si hay algún filtro seleccionado
        const categoryFilter = document.getElementById('categoryFilter');
        const statusFilter = document.getElementById('statusFilter');
        const searchInput = document.getElementById('searchInput');

        if (categoryFilter.value !== 'todos' ||
            statusFilter.value !== 'todos' ||
            searchInput.value.trim() !== '') {
            filterProjects();
        }
    });
</script>