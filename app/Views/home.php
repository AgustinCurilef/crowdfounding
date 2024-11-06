<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Found4Futures - Crowdfunding Tecnológico</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('template/dist/css/home.css'); ?>">

    
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="<?php echo base_url('template/dist/assets/img/AdminLTELogo.png'); ?>" alt="Found4Futures">
        </div>
        <div class="nav-links">
            <li><a href="#proyectos">Proyectos</a></li>
            <li><a href="#como-funciona">Cómo Funciona</a></li>
            <li><a href="<?= base_url('/login') ?>">Iniciar Sesión</a></li>
            <li><a href="#" class="btn-primary">Iniciar Proyecto</a></li>
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
            <a href="#" class="btn-primary">Descubre Proyectos</a>
        </div>
    </section>

    <section class="featured-projects" id="proyectos">
        <h2 class="section-title">Proyectos Destacados</h2>
        <div class="projects-grid">
            <div class="project-card">
                <img src="/api/placeholder/400/200" alt="Proyecto IA" class="project-image">
                <div class="project-info">
                    <div class="project-category">Inteligencia Artificial</div>
                    <h3 class="project-title">Sistema de IA para Agricultura Inteligente</h3>
                    <p>Revolucionando la agricultura con IA predictiva y automatización</p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 75%"></div>
                    </div>
                    <div class="project-stats">
                        <span>$75,000 recaudados</span>
                        <span>75%</span>
                    </div>
                </div>
            </div>

            <div class="project-card">
                <img src="/api/placeholder/400/200" alt="Proyecto Robótica" class="project-image">
                <div class="project-info">
                    <div class="project-category">Robótica</div>
                    <h3 class="project-title">Robot Asistencial para Hospitales</h3>
                    <p>Automatización de tareas hospitalarias con robots inteligentes</p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 60%"></div>
                    </div>
                    <div class="project-stats">
                        <span>$120,000 recaudados</span>
                        <span>60%</span>
                    </div>
                </div>
            </div>

            <div class="project-card">
                <img src="/api/placeholder/400/200" alt="Proyecto Big Data" class="project-image">
                <div class="project-info">
                    <div class="project-category">Big Data</div>
                    <h3 class="project-title">Plataforma de Análisis Predictivo</h3>
                    <p>Solución empresarial basada en análisis de datos masivos</p>
                    <div class="progress-bar">
                        <div class="progress" style="width: 85%"></div>
                    </div>
                    <div class="project-stats">
                        <span>$170,000 recaudados</span>
                        <span>85%</span>
                    </div>
                </div>
            </div>
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
            <div class="step-card">
    </section>

    <section class="features-section">
        <h2 class="section-title" style="color: white;">¿Por qué Found4Futures?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <i class="fas fa-shield-alt step-icon"></i>
                <h3>Inversiones Seguras</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line step-icon"></i>
                <h3>Alto Potencial</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-users step-icon"></i>
                <h3>Comunidad Tech</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>Found4Futures</h4>
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
            <p>&copy; 2024 Found4Futures. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>