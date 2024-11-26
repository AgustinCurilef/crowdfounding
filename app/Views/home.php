<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impulsa - Crowdfunding Tecnológico</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('template/dist/css/home.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>


</head>

<body>
    <nav class="navbar">
        <div class="logo">
            <img src="<?= base_url('/template/dist/assets/img/LogoImpulsa.png') ?>" alt="Impulsa">
        </div>
        <div class="nav-links">
            <li><a href="#proyectos">Proyectos</a></li>
            <li><a href="#como-funciona">Cómo Funciona</a></li>
            <li><a class="btn-primary" href="<?= base_url('/login') ?>">Iniciar Sesión</a></li>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">El futuro de la tecnología comienza aquí</h1>
            <p>Únete a la revolución tecnológica. Invierte en los proyectos más innovadores</p>
            <div class="category-badges">
                <span class="category-badge">Inteligencia Artificial</span>
                <span class="category-badge">Robótica</span>
                <span class="category-badge">Big Data</span>
                <span class="category-badge">IoT</span>
            </div>
        </div>
    </section>

    <section class="featured-projects" id="proyectos">
        <h2 class="section-title">Proyectos Destacados</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4" id="projectsGrid">
            <?php for ($i = 0; $i < min(count($projects), 3); $i++) :
                $project = $projects[$i];
            ?>
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
                        </div>



                    </div>
                </div>
            <?php endfor; ?>
        </div>
    </section>
    <section class="how-it-works" id="como-funciona">
        <h2 class="section-title">¿Cómo Funciona?</h2>
        <div class="steps-container">
            <div class="step-card">
                <i class="fas fa-lightbulb step-icon"></i>
                <h3>Explora Proyectos</h3>
                <p>Descubre innovaciones tecnológicas y elige los proyectos que más te apasionen</p>
            </div>
            <div class="step-card">
                <i class="fas fa-rocket step-icon"></i>
                <h3>Invierte</h3>
                <p>Contribuye al desarrollo tecnológico con inversiones desde que se adaptan a tu bolsillo</p>
            </div>
    </section>

    <section class="features-section">
        <h2 class="section-title" style="color: white;">¿Por qué Impulsa?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-shield-alt step-icon"></i>
                <h3>Inversiones Seguras</h3>
                <p>Proyectos con bajo riesgo y rentabilidad confiable para cuidar tu inversión. Apuesta por la estabilidad y la transparencia.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line step-icon"></i>
                <h3>Alto Potencial</h3>
                <p>Invierte en proyectos emergentes con grandes oportunidades de crecimiento. Sé parte del futuro de las grandes ideas.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-users step-icon"></i>
                <h3>Comunidad Tech</h3>
                <p>Apoya iniciativas tecnológicas creadas por comunidades con impacto social. Impulsa la innovación y transforma vidas.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <img src="<?= base_url('/template/dist/assets/img/LogoImpulsa.png') ?>" alt="Logo" class="brand-image opacity-100" style="max-width: 150px;">
                <p>Impulsando la innovación tecnológica a través del crowdfunding.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-linkedin"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Explorar</h4>
                <a href="#">Todos los Proyectos</a>
                <a href="#">Inteligencia Artificial</a>
                <a href="#">Robótica</a>
                <a href="#">Big Data</a>
                <a href="#">IoT</a>
            </div>

            <div class="footer-section">
                <h4>Recursos</h4>
                <a href="#">Centro de Ayuda</a>
                <a href="#">Blog</a>
                <a href="#">Guías</a>
                <a href="#">Para Inversores</a>
                <a href="#">Para Creadores</a>
            </div>

            <div class="footer-section">
                <h4>Legal</h4>
                <a href="#">Términos y Condiciones</a>
                <a href="#">Política de Privacidad</a>
                <a href="#">Políticas de Inversión</a>
                <a href="#">Seguridad</a>
            </div>
        </div>
        <div style="text-align: center; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p>&copy; 2024 Impulsa. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>

</html>