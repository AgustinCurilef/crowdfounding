<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar con foto de perfil -->
            <div class="card">
                <div class="card-body text-center">

                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-4">Edit Profile</h2>
                    <!-- Formulario para editar perfil -->
                    <form action="<?= base_url('perfil/actualizarPerfil') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

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
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?= old('email', $user['EMAIL']) ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="nacionalidad" class="form-label">Nationality</label>
                                    <select name="nacionalidad" class="form-control" required>
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
                                    <input type="text" class="form-control" name="telefono" value="<?= old('telefono', $user['TELEFONO']) ?>">
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
                            <input type="file" name="foto_perfil" class="form-control" accept="image/*">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('perfil') ?>" class="btn btn-secondary me-md-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
