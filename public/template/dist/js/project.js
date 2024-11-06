$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });

    // Initialize tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Filter handling
    $('#categoryFilter, #statusFilter').on('change', function() {
        filterProjects();
    });

    // Search handling
    let searchTimeout;
    $('#searchInput').on('keyup', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            filterProjects();
        }, 500);
    });

    // New Project Form Handling
    $('#saveProject').on('click', function() {
        const formData = new FormData($('#newProjectForm')[0]);
        
        // Validate form
        if (!$('#newProjectForm')[0].checkValidity()) {
            $('#newProjectForm')[0].reportValidity();
            return;
        }

        // Here you would typically make an AJAX call to save the project
        $.ajax({
            url: '/projects/save',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#newProjectModal').modal('hide');
                    Swal.fire({
                        title: '¡Éxito!',
                        text: 'El proyecto ha sido creado correctamente',
                        icon: 'success'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: response.message || 'Hubo un error al crear el proyecto',
                        icon: 'error'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Hubo un error al procesar la solicitud',
                    icon: 'error'
                });
            }
        });
    });

    // Delete Project Handling
    $('.btn-danger').on('click', function() {
        const projectId = $(this).data('project-id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                deleteProject(projectId);
            }
        });
    });
});

function filterProjects() {
    const category = $('#categoryFilter').val();
    const status = $('#statusFilter').val();
    const search = $('#searchInput').val();

    // Here you would typically make an AJAX call to get filtered results
    $.ajax({
        url: '/projects/filter',
        type: 'GET',
        data: {
            category: category,
            status: status,
            search: search
        },
        success: function(response) {
            updateProjectsGrid(response.projects);
        },
        error: function() {
            Swal.fire({
                title: 'Error',
                text: 'Error al filtrar los proyectos',
                icon: 'error'
            });
        }
    });
}

function updateProjectsGrid(projects) {
    const grid = $('#projectsGrid');
    grid.empty();

    projects.forEach(project => {
        // Add project card to grid
        const card = createProjectCard(project);
        grid.append(card);
    });
}
