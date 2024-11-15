<main class="app-main">
    <div class="hold-transition sidebar-mini">
        <div class="wrapper">
            <div class="content-wrapper">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Modificar Proyecto</h1>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card project-form-card">
                                    <div class="card-body">
                                        <!-- Mensajes flash de éxito o error -->
                                        <?php if (session()->getFlashdata('success')): ?>
                                            <div class="alert alert-success">
                                                <?= session()->getFlashdata('success'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (session()->getFlashdata('error')): ?>
                                            <div class="alert alert-danger">
                                                <?= session()->getFlashdata('error'); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Formulario -->
                                        <form id="projectForm" action="<?= base_url('/updateProject/'. $project->ID_PROYECTO) ?>" method="POST">
                                            <!-- Campo oculto para ID del proyecto -->
                                            <input type="hidden" name="ID_PROYECTO" value="<?= $project->ID_PROYECTO ?>">

                                            <!-- Imagen de portada, tengo que cargar el div class -->
                                            <div class="text-center mb-4">
                                               
                                                <div class="upload-btn-wrapper">
                                                    <label class="upload-btn" for="imageUpload">
                                                        <i class="fas fa-upload mr-2"></i>CARGAR PORTADA
                                                        <input type="file" id="imageUpload" name="PORTADA" accept="image/*" hidden>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Primera fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="projectName">Nombre del Proyecto</label>
                                                        <input type="text" class="form-control" id="projectName" name="NOMBRE" 
                                                               value="<?= $project->NOMBRE ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                    <label>Categoría</label>
                                                    <select class="form-control select2" id="categoryFilter">
                                                        <option value="0">Todos</option>
                                                        <?php foreach ($categories as $category) : ?>
                                                            <option value="<?= esc($category->ID_CATEGORIA) ?>" 
                                                            <?= isset($project->ID_CATEGORIA) && $category->ID_CATEGORIA == $project->ID_CATEGORIA ? 'selected' : '' ?>>
                                                                <?= esc($category->NOMBRE) ?>
                                                            </option>
                                                        <?php endforeach; ?> 
                                                    </select>
                                                    </div>
                                                </div>

                                                <!-- Segunda fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="budget">Presupuesto Requerido</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">$</span>
                                                            </div>
                                                            <input type="number" class="form-control" id="budget" name="PRESUPUESTO" 
                                                                   value="<?= $project->PRESUPUESTO ?>" min="0" step="0.01" required>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="deadline">Fecha límite</label>
                                                        <input type="datetime-local" class="form-control" id="deadline" name="FECHA_LIMITE" 
                                                               value="<?= date('Y-m-d\TH:i', strtotime($project->FECHA_LIMITE)) ?>" required>
                                                    </div>
                                                </div>

                                                <!-- Tercera fila -->
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="objective">Objetivo / Impacto esperado</label>
                                                        <input type="text" class="form-control" id="objective" name="OBJETIVO" 
                                                               value="<?= $project->OBJETIVO ?>" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="description">Descripción detallada</label>
                                                        <textarea class="form-control" id="description" name="DESCRIPCION" rows="4" required><?= $project->DESCRIPCION ?></textarea>
                                                    </div>
                                                </div>

                                                <!-- Cuarta fila -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="rewards">Plan de recompensa</label>
                                                        <input type="text" class="form-control" id="rewards" name="RECOMPENSAS" 
                                                               value="<?= $project->RECOMPENSAS ?>">
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="website">Sitio Web</label>
                                                        <input type="url" class="form-control" id="website" name="SITIO_WEB" 
                                                               value="<?= $project->SITIO_WEB ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Botones de acción -->
                                            <div class="row mt-4">
                                                <div class="col-12 text-right">
                                                    <button type="button" class="btn btn-secondary mr-2" id="cancelButton">
                                                        <i class="fas fa-times mr-2"></i>Cancelar
                                                    </button>
                                                    <button type="submit" class="btn btn-primary btn-submit">
                                                        <i class="fas fa-check mr-2"></i>Actualizar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</main>
