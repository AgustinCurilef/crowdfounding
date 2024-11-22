<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $title ?></title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE 4 | Register Page">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="<?= base_url('template/dist/css/adminlte.css') ?>"><!--end::Required Plugin(AdminLTE)-->
</head> <!--end::Head-->
<body class="register-page bg-body-secondary">
    <div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header">
             <a href="<?= base_url('template/dist/pages/index2.html') ?>" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
                    <h1 class="mb-0"> <b>Fund4Futures</b>
                    </h1>
                </a> </div> <!-- /.register-logo -->
        <div class="card">
            <div class="card-body register-card-body">
                <p class="register-box-msg">¡ Unete a nosotros !</p>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <form id="registerForm" action="<?= base_url('/register') ?>" method="post">
                    <div class="input-group mb-3"> <input type="text" class="form-control" placeholder="Username" name="username" required>
                        <div class="input-group-text"> <span class="bi bi-person"></span> </div>
                    </div>
                    <div class="input-group mb-3"> <input type="text" class="form-control" placeholder="First Name" name="nombre" required>
                        <div class="input-group-text"> <span class="bi bi-person"></span> </div>
                    </div>
                    <div class="input-group mb-3"> <input type="text" class="form-control" placeholder="Last Name" name="apellido" required>
                        <div class="input-group-text"> <span class="bi bi-person"></span> </div>
                    </div>
                    <div class="input-group mb-3"> <input type="email" class="form-control" placeholder="Email" name="correo" required>
                        <div class="input-group-text"> <span class="bi bi-envelope"></span> </div>
                    </div>
                    <div class="input-group mb-3"> <input type="password" class="form-control" placeholder="Password" name="contrasenia" required>
                        <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    </div>
                    <div class="input-group mb-3"> <input type="password" class="form-control" placeholder="Repeat your password" name="contrasenia2" required>
                        <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-check"> <input class="form-check-input" type="checkbox" value="1" id="terminosCheck" name="terminos" required> 
                                <label class="form-check-label" for="terminosCheck"> Acepta los <a href="#">términos</a> </label>
                            </div>
                        </div> <!-- /.col -->
                        <div class="col-4">
                            
                        </div> <!-- /.col -->
                    </div> <!--end::Row-->
                    <div class="d-grid gap-2" style="padding-top: 10px;" > <button type="submit" class="btn btn-primary">Registrar</button> </div>
                </form>
                <p class="mb-0" style="padding-top: 10px;"> <a href="<?= base_url("/login")?>" class="text-center">Ya tengo una cuenta de usuario</a> </p>
            </div> <!-- /.register-card-body -->
        </div>
    </div> <!-- /.register-box -->

    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <script src="<?= base_url('template/dist/js/adminlte.js') ?>"></script>
    
    <!-- Script de validación -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            var contrasenia = document.querySelector('input[name="contrasenia"]').value;
            var confirmContrasenia = document.querySelector('input[name="contrasenia2"]').value;
            var terminos = document.querySelector('#terminosCheck').checked;

            // Validar que las contraseñas coincidan
            if (contrasenia !== confirmContrasenia) {
                alert("Las contraseñas no coinciden.");
                e.preventDefault();  // Evitar el submit
                return;
            }

            // Validar que el checkbox de términos esté tildado
            if (!terminos) {
                alert("Debe aceptar los términos y condiciones.");
                e.preventDefault();  // Evitar el submit
                return;
            }
        });
    </script>

</body>
</html>
