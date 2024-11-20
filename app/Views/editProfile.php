<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar con foto de perfil -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-image-container mb-3">
                            <!-- Mostrar la foto de perfil actual -->
                            <img src="<?= base_url('user/showImage/' . $user['ID_USUARIO']); ?>"
                            class="rounded-circle profile-image" id="profileImagePreview">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4">Edit Profile</h2>
                    <!-- Mostrar el mensaje de error si existe -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error') ?>
                            </div>
                        <?php endif; ?>
                    <!-- Formulario para editar perfil -->
                    <form action="<?= base_url('user/saveChanges') ?>" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id_usuario" value="<?= session()->get('ID_USUARIO'); ?>" />
                        <!-- Información básica -->
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?= old('username', $user['USERNAME']) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="nombre" class="form-label">First Name</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?= old('nombre', $user['NOMBRE']) ?>" required>
                                </div>
                                <div class="col-12">
                                    <label for="apellido" class="form-label">Last Name</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="<?= old('apellido', $user['APELLIDO']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nacionalidad" class="form-label">Nationality</label>
                                    <select name="nacionalidad" class="form-control">
                                        <option value="">Select your nationality</option>
                                        <option value="Argentina" <?= ($user['NACIONALIDAD'] == 'Argentina') ? 'selected' : '' ?>>Argentina</option>
                                        <option value="Chile" <?= ($user['NACIONALIDAD'] == 'Chile') ? 'selected' : '' ?>>Chile</option>
                                        <!-- Agregar más opciones de nacionalidades aquí -->
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="fecha_nacimiento" class="form-label">Born Date</label>
                                    <input type="date" class="form-control" name="fecha_nacimiento" value="<?= old('fecha_nacimiento', $user['FECHA_NACIMIENTO']) ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Phone Number</label>
                                    <input type="tel" 
                                        class="form-control" 
                                        id="telefono" 
                                        name="telefono" 
                                        value="<?= old('telefono', $user['TELEFONO']) ?>" 
                                        maxlength="15">
                                    <small class="form-text text-muted">
                                        Format: <code>XXX-XXX-XXX-XXX-XXX</code> .
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
                            <h5>Photo Profile</h5>
                            <input type="file" id="foto_perfil" name="foto_perfil" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('/inicio') ?>" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                            <!-- Formulario para eliminar el perfil -->
                            <form action="<?= base_url('user/delete/') . $user['ID_USUARIO']?>" method="POST" onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.')">
                                <button type="submit" class="btn btn-danger">Delete Profile</button>
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>

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