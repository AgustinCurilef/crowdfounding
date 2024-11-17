<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> 
    <!--begin::Sidebar Brand-->
            <div class="sidebar-brand" >
                 <!--begin::Brand Link--> 
                 <a href="<?= base_url('inicio') ?>" class="brand-link"> 
                <!--begin::Brand Image-->
                 <img src="../../dist/assets/img/AdminLTELogo.png" alt="Logo" class="brand-image opacity-75 shadow"> 
                 <!--end::Brand Image-->
                  <!--begin::Brand Text--> <span class="brand-text fw-light">Found4Futures</span> <!--end::Brand Text-->
                 </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                    <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Perfil
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="<?= base_url('editProfile') ?>" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Editar Perfil</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./index2.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Preferencias Pago</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./index3.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Configuracion y Privacidad</p>
                                    </a> </li>
                            </ul>
                            
                        </li>  
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Administracion General
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./index.html" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Notificaciones</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./index2.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Usuarios</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./index3.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Privacidad</p>
                                    </a> </li>
                            </ul>
                            
                        </li>  
                    
                    
                    
                    <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Proyectos
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">  <a href="<?= base_url('myprojects') ?>" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Mis Proyectos</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="<?= base_url('addProyect') ?>" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Crear Proyectos</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="./index3.html" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Dashboard v3</p>
                                    </a> </li>
                            </ul>
                            
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Inversiones
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?= base_url('myInvestments') ?>" class="nav-link"> 
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Mis Inversiones</p>
                            </a>
                        </li>
                        <li class="nav-item">
                        <a href="<?= base_url('investment/create') ?>" class="nav-link"> 
                        <i class="nav-icon bi bi-circle"></i>
                                <p>Realizar Inversion</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="./index3.html" class="nav-link"> 
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li>
                       
                    </ul>                            
                    </li>

                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-speedometer"></i>
                                <p>
                                    Categorias
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="<?= base_url('/categories') ?>" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                        <p>Explorar Categorias</p>
                                    </a> </li>
                                <li class="nav-item"> <a href="<?= base_url('/categories/create') ?>" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                    <p>Crear Categorias (admin)</p>
                                    </a> </li>
                            </ul>
                            
                        </li>
                    
                        <!--ACAAA LLEGUE -->
                        
                    
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> <!--end::Sidebar--> <!--begin::App Main-->