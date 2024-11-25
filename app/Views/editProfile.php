<main class="app-main" style="background: radial-gradient(ellipse, #99CBC8, #199890);">
<div class="container py-5" style="width: 800px; display: flex; justify-content: center;">
    <div class="row" >
            <div class="card card-outline card-personalized" >
            <!-- Sidebar con foto de perfil -->
            <div class="card-body text-center">

                    <div class="profile-image-container mb-3">
                            <!-- Mostrar la foto de perfil actual -->
                            <img src="<?= base_url('user/showImage/' . $user['ID_USUARIO']); ?>"
                            class="rounded-circle profile-image" style="border: 4px solid #fff; box-shadow: 0 0 15px rgba(0, 0, 0, 0.3); border-color: black" id="profileImagePreview">
                    </div>
                </div>
                <div class="card-body">
                    <!-- Mostrar el mensaje de error si existe -->
                    <?php if (session()->has('errors')): ?>
                    <div class="alert alert-danger">
                        <ul>
                            <?php foreach (session('errors') as $error): ?>
                                <li><?= esc($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>



                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>
                    <!-- Formulario para editar perfil -->
                    <form action="<?= 'user/saveChanges' ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_usuario" value="<?= session()->get('ID_USUARIO'); ?>" />
                        <!-- Información básica -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="username" class="form-label">Usuario</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['USERNAME']) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $user['NOMBRE']) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?= old('apellido', $user['APELLIDO']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nacionalidad" class="form-label">Nacionalidad</label>
                                    <select name="nacionalidad" class="form-control">
                                        <option value="">Selecciona tu nacionalidad</option>
                                        <option value="Argentina" <?= ($user['NACIONALIDAD'] == 'Argentina') ? 'selected' : '' ?>>Argentina</option>
                                        <option value="Chile" <?= ($user['NACIONALIDAD'] == 'Chile') ? 'selected' : '' ?>>Chile</option>
                                        <!-- Agregar más opciones de nacionalidades aquí -->
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento" value="<?= old('fecha_nacimiento', $user['FECHA_NACIMIENTO']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Número telefónico</label>
                                    <input type="tel" 
                                        class="form-control" 
                                        id="telefono" 
                                        name="telefono" 
                                        value="<?= old('telefono', $user['TELEFONO']) ?>" 
                                        maxlength="15">
                                    <small class="form-text text-muted">
                                        Formato: <code>XXX-XXX-XXX-XXX-XXX</code> .
                                    </small>
                                    </div>
                                <div class="col-md-6">
                                    <label for="linkedin" class="form-label">LinkedIn</label>
                                    <input type="url" class="form-control" name="linkedin" value="<?= old('linkedin', $user['LINKEDIN']) ?>">
                                </div>
                            </div>
                        </div>

                        <!-- Foto de perfil -->
                        <div class="mb-4">
                            <h5>Foto de perfil</h5>
                            <input type="file" id="foto_perfil" name="foto_perfil" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('/inicio') ?>" class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </form>
                            <!-- Formulario para eliminar el perfil -->
                            <form action="<?= base_url('user/delete/') . $user['ID_USUARIO']?>" method="POST" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.')">
                                <button type="submit" class="btn btn-danger">Eliminar cuenta</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
    document.querySelector('input[name="foto_perfil"]').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileImagePreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
<script>
document.getElementById('telefono').addEventListener('input', function (e) {
    let input = e.target.value.replace(/\D/g, ''); // Solo permite números

    // Limitar a 15 dígitos
    if (input.length > 15) {
        input = input.slice(0, 15);
    }

    // Autoformatear con guiones cada 3 dígitos
    let formatted = '';
    for (let i = 0; i < input.length; i++) {
        if (i > 0 && i % 3 === 0) {
            formatted += '-';
        }
        formatted += input[i];
    }

    e.target.value = formatted;
});
</script>