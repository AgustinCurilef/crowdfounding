<div class="container py-5">
  

    <div class="row">
        <div class="col-md-3">
            <!-- Sidebar con foto de perfil -->
            <div class="card">
                <div class="card-body text-center">
                    <div class="profile-image-container mb-3">
                        <img src="template\dist\assets\img\avatar2.png" 
                             alt="Foto de perfil" 
                             class="rounded-circle profile-image" 
                             id="profileImagePreview">
                    </div>
                    <button type="button" 
                            class="btn btn-outline-primary btn-sm" 
                            id="changeProfileImage">
                        Cambiar foto
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Editar Perfil</h2>
                    
                        <!-- Imagen de perfil oculta -->
                        <input type="file" 
                               name="profile_image" 
                               id="profileImageInput" 
                               class="d-none" 
                               accept="image/*">

                        <!-- Información básica -->
                        <div class="mb-4">
                            <h5>Información Básica</h5>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="name" class="form-label">Nombre completo</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="name" 
                                           name="name" 
                                           value="juan" 
                                           required>
                                </div>

                                <div class="col-12">
                                    <label for="bio" class="form-label">Biografía</label>
                                    <textarea class="form-control" 
                                              id="bio" 
                                              name="bio" 
                                              rows="4">hola perro </textarea>
                                </div>

                                <div class="col-md-6">
                                    <label for="location" class="form-label">Ubicación</label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="location" 
                                           name="location" 
                                           value="argentina">
                                </div>

                                <div class="col-md-6">
                                    <label for="website" class="form-label">Sitio Web</label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="website" 
                                           name="website" 
                                           value=" holaaa">
                                </div>
                            </div>
                        </div>

                        <!-- Redes sociales -->
                        <div class="mb-4">
                            <h5>Redes Sociales</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="social_linkedin" class="form-label">
                                        <i class="bi bi-linkedin"></i> LinkedIn
                                    </label>
                                    <input type="url" 
                                           class="form-control" 
                                           id="social_linkedin" 
                                           name="social_linkedin" 
                                           value="social linkedin">
                                </div>

                                <div class="col-md-6">
                                    <label for="social_twitter" class="form-label">
                                        <i class="bi bi-twitter"></i> Twitter
                                    </label>
                                    <input type="text" 
                                           class="form-control" 
                                           id="social_twitter" 
                                           name="social_twitter" 
                                           value="twitter">
                                </div>
                            </div>
                        </div>

                        <!-- Intereses -->
                        <div class="mb-4">
                            <h5>Intereses</h5>
                            <div class="interests-container" id="interestsContainer">
                                <?php 
                          
                                foreach($categories as $category): 
                                    if (($category->NOMBRE) !== ''):
                                ?>
                                    <span class="badge bg-primary me-2 mb-2 interest-badge">
                                        <?php echo esc($category->NOMBRE) ?>
                                        <i class="bi bi-x-circle ms-1 remove-interest"></i>
                                    </span>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                            <input type="text" 
                                   class="form-control" 
                                   id="interestInput" 
                                   placeholder="Agregar un interés (presiona Enter)">
                            <input type="hidden" 
                                   name="interests" 
                                   id="interestsHidden" 
                                   value="intereses">
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="" 
                               class="btn btn-secondary me-md-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>