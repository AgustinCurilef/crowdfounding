<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso no autorizado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column justify-content-center align-items-center vh-100">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-12">
                <h1 class="display-4 text-danger">403 - Acceso no autorizado</h1>
                <p class="lead text-secondary">
                    Lo sentimos, no tienes permiso para acceder a esta página.
                </p>
                <a href="<?= base_url('/inicio') ?>" class="btn btn-primary btn-lg mt-3">
                    Volver al inicio
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>