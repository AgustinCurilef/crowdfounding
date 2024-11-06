<!-- index.html -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma de Inversiones Inmobiliarias</title>
    <link rel="stylesheet" href="<?php echo base_url('template/dist/css/home.css'); ?>">
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <img src="<?php echo base_url('template/dist/assets/img/AdminLTELogo.png'); ?>" alt="Logo">
            </div>
            <ul class="nav-links">
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#proyectos">Proyectos</a></li>
                <li><a href="#como-funciona">Cómo Funciona</a></li>
                <li><a href="#nosotros">Nosotros</a></li>
                <li class="btn-login"><a href="<?= base_url('/login') ?>">Iniciar Sesión</a></li>
            </ul>
            <div class="menu-hamburguesa">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1>Invierte en Bienes Raíces de Manera Inteligente</h1>
                <p>Accede a las mejores oportunidades inmobiliarias desde $1000</p>
                <button class="cta-button">Comenzar Ahora</button>
            </div>
        </section>

        <section class="proyectos" id="proyectos">
            <h2>Proyectos Destacados</h2>
            <div class="proyectos-grid">
                <!-- Tarjetas de proyectos generadas dinámicamente por JS -->
            </div>
        </section>

        <section class="beneficios">
            <h2>¿Por qué elegirnos?</h2>
            <div class="beneficios-grid">
                <div class="beneficio-card">
                    <img src="<?php echo base_url('template/dist/assets/img/avatar.png'); ?>" alt="Seguridad">
                    <h3>Seguridad Garantizada</h3>
                    <p>Todas las inversiones están respaldadas legalmente</p>
                </div>
                <div class="beneficio-card">
                    <img src="<?php echo base_url('template/dist/assets/img/avatar2.png'); ?>" alt="Rentabilidad">
                    <h3>Alta Rentabilidad</h3>
                    <p>Retornos superiores al promedio del mercado</p>
                </div>
                <div class="beneficio-card">
                    <img src="<?php echo base_url('template/dist/assets/img/avatar3.png'); ?>" alt="Transparencia">
                    <h3>Total Transparencia</h3>
                    <p>Seguimiento en tiempo real de tus inversiones</p>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h4>Contacto</h4>
                <p>Email: info@ejemplo.com</p>
                <p>Tel: (123) 456-7890</p>
            </div>
            <div class="footer-section">
                <h4>Redes Sociales</h4>
                <div class="social-links">
                    <a href="#">Facebook</a>
                    <a href="#">Twitter</a>
                    <a href="#">LinkedIn</a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Legal</h4>
                <a href="#">Términos y Condiciones</a>
                <a href="#">Política de Privacidad</a>
            </div>
        </div>
    </footer>

    <script src="<?php echo base_url('template/dist/js/home.js'); ?>"></script>
</body>
</html>