// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Datos de ejemplo para proyectos
    const proyectos = [
        {
            titulo: "Edificio Residencial Centro",
            ubicacion: "Buenos Aires",
            rendimiento: "18% anual",
            plazo: "24 meses",
            minimo: "$1,000",
            imagen: "/api/placeholder/300/200"
        },
        {
            titulo: "Complex Comercial Norte",
            ubicacion: "Córdoba",
            rendimiento: "15% anual",
            plazo: "36 meses",
            minimo: "$2,000",
            imagen: "/api/placeholder/300/200"
        },
        {
            titulo: "Torres del Puerto",
            ubicacion: "Rosario",
            rendimiento: "20% anual",
            plazo: "18 meses",
            minimo: "$1,500",
            imagen: "/api/placeholder/300/200"
        }
    ];

    // Función para cargar proyectos
    function cargarProyectos() {
        const proyectosContainer = document.querySelector('.proyectos-grid');
        
        proyectos.forEach(proyecto => {
            const proyectoCard = document.createElement('div');
            proyectoCard.className = 'proyecto-card';
            proyectoCard.innerHTML = `
                <img src="${proyecto.imagen}" alt="${proyecto.titulo}">
                <div class="proyecto-info" style="padding: 1rem;">
                    <h3>${proyecto.titulo}</h3>
                    <p><strong>Ubicación:</strong> ${proyecto.ubicacion}</p>
                    <p><strong>Rendimiento:</strong> ${proyecto.rendimiento}</p>
                    <p><strong>Plazo:</strong> ${proyecto.plazo}</p>
                    <p><strong>Inversión mínima:</strong> ${proyecto.minimo}</p>
                    <button class="cta-button" style="margin-top: 1rem;">Invertir Ahora</button>
                </div>
            `;
            proyectosContainer.appendChild(proyectoCard);
        });
    }

    // Menú hamburguesa para móviles
    const menuHamburguesa = document.querySelector('.menu-hamburguesa');
    const navLinks = document.querySelector('.nav-links');

    if (menuHamburguesa) {
        menuHamburguesa.addEventListener('click', () => {
            navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
        });
    }

    // Smooth scroll para los enlaces de navegación
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Animación del header al hacer scroll
    let lastScroll = 0;
    const header = document.querySelector('.header');

    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;

        if (currentScroll <= 0) {
            header.classList.remove('scroll-up');
            return;
        }

        if (currentScroll > lastScroll && !header.classList.contains('scroll-down')) {
            header.classList.remove('scroll-up');
            header.classList.add('scroll-down');
        } else if (currentScroll < lastScroll && header.classList.contains('scroll-down')) {
            header.classList.remove('scroll-down');
            header.classList.add('scroll-up');
        }
        lastScroll = currentScroll;
    });

    // Cargar los proyectos al iniciar
    cargarProyectos();
});