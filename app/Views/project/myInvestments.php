<style>
    .description-cell {
        max-width: 300px;
        /* Ancho máximo de la columna */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Para mostrar la descripción completa al hacer hover */
    .description-cell:hover {
        white-space: normal;
        overflow: visible;
        position: relative;
        background-color: white;
        z-index: 1;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        padding: 5px;
        border-radius: 4px;
    }

    /* Ajustar el ancho de otras columnas */
    .project-name {
        width: 200px;
    }

    .categories-cell {
        width: 150px;
    }

    .progress-cell {
        width: 150px;
    }

    .amount-cell {
        width: 120px;
    }
</style>
<main class="app-main" style="background: radial-gradient(ellipse, #99CBC8, #199890);">
    <section class="content" style="padding-top : 20px">
        <div class=" container-fluid">
            <!-- Filtros -->
            <div class="card mb-4">
                <div class="card-header text-black">
                    <h3 class="card-title">Filtros</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-select" id="categoryFilter">
                                    <option value="">Todos</option>
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= esc($category->NOMBRE) ?>"><?= esc($category->NOMBRE) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Estado</label>
                                <select class="form-select" id="statusFilter">
                                    <option value="">Todos</option>
                                    <option value="1">Público</option>
                                    <option value="0">Oculto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Proyectos -->
            <div class="card">

                <div class="card-body">

                    <table id="projectsTable" class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="project-name">Proyecto</th>
                                <th class="categories-cell">Categorías</th>
                                <th class="amount-cell">Presupuesto</th>
                                <th class="amount-cell">Recaudado</th>
                                <th class="amount-cell">Mi Inversión</th>
                                <th class="progress-cell">Progreso</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($projects as $project) : ?>
                                <tr>
                                    <td class="project-name">
                                        <div class="d-flex align-items-center">
                                            <?php if (isset($project->imagen_base64)) : ?>
                                                <img src="data:image/jpeg;base64,<?= esc($project->imagen_base64) ?>"
                                                    class="rounded me-2"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            <?php endif; ?>
                                            <div>
                                                <strong><?= esc($project->NOMBRE) ?></strong>
                                                <div class="description-cell">
                                                    <?= esc($project->DESCRIPCION) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="categories-cell">
                                        <?php foreach ($project->categoria_nombre as $categoria) : ?>
                                            <span class="badge bg-primary"><?= esc($categoria) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td class="amount-cell"><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</td>
                                    <td class="amount-cell"><?= number_format($project->monto_recaudado, 2, ',', '.') ?> $</td>
                                    <td class="amount-cell"><?= number_format($project->monto_invertido, 2, ',', '.') ?> $</td>
                                    <td class="progress-cell">
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success"
                                                role="progressbar"
                                                style="width: <?= min(100, round($project->porcentaje_progreso, 1)) ?>%"
                                                aria-valuenow="<?= round($project->porcentaje_progreso, 1) ?>"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                <?= round($project->porcentaje_progreso, 1) ?>%
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>

<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar DataTables
        let table = $('#projectsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            pageLength: 10,
            ordering: true,
            responsive: true
        });

        // Aplicar filtros personalizados
        $('#categoryFilter, #statusFilter').on('change', function() {
            let categoryVal = $('#categoryFilter').val().toLowerCase();
            let statusVal = $('#statusFilter').val();

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let row = $(table.row(dataIndex).node());
                let categories = data[1].toLowerCase();
                let status = row.find('td:last span.badge').text() === 'Público' ? '1' : '0';

                let categoryMatch = !categoryVal || categories.includes(categoryVal);
                let statusMatch = !statusVal || status === statusVal;

                return categoryMatch && statusMatch;
            });

            table.draw();
            $.fn.dataTable.ext.search.pop();
        });
    });
</script>