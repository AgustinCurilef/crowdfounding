<main class="app-main">
   <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Filters and Search -->
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Filtros</h3>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#newProjectModal">
                        <i class="fas fa-plus"></i> Nuevo Proyecto
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Categoría</label>
                            <select class="form-control select2" id="categoryFilter">
                            <option value="0">Todos</option>
                            <?php foreach ($categories as $category) : ?>
                                
                                <option value= <?=esc( $category->ID_CATEGORIA)?> > <?= esc($category->NOMBRE) ?></option>
                                <?php endforeach; ?>   
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Estado</label>
                            <select class="form-control select2" id="statusFilter">
                                <option value="">Todos</option>
                                <option value="active">Activo</option>
                                <option value="completed">Completado</option>
                                <option value="draft">Borrador</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Buscar</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Buscar proyectos...">
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
                <div class="col">
                    <div class="card h-100">
                        <img class="card-img-top" src="https://via.placeholder.com/350x200" alt="Project Image">


<div class="card-body">
    <!-- Nombre y Presupuesto -->
    <div class="mb-3">
        <span class="text-muted">Nombre del Proyecto: </span><?= esc($project->NOMBRE) ?><br>
        <span class="text-muted">Presupuesto total: </span><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $
    </div>
    
    <!-- Mi inversión y Monto recaudado -->
    <div class="mb-2">
        <span class="text-muted">Mi inversión: </span>
        <span class="text-success"><?= number_format($project->monto_invertido, 2, ',', '.') ?> $</span>
    </div>

    <!-- Barra de progreso -->
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
    
    <!-- Monto recaudado -->
    <div class="text-center mb-2">
        <span class="text-muted">Recaudado: </span>
        <strong><?= number_format($project->monto_recaudado, 2, ',', '.') ?> $</strong>
        <span class="text-muted"> de </span>
        <strong><?= number_format($project->PRESUPUESTO, 2, ',', '.') ?> $</strong>
    </div>

    <!-- Descripción -->
    <div class="mt-2">
        <span class="text-muted">Descripción: </span><br>
        <?= esc($project->DESCRIPCION) ?>
    </div>
</div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                <?php foreach ($project->categoria_nombre as $categoria) : ?>
                        <span class="badge bg-primary"><?= esc($categoria) ?></span>
                    <?php endforeach; ?>
                      <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-info">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger">
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
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</section>

</main>
