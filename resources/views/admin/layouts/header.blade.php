<div class="header">
    <nav class="navbar py-4">
        <div class="container-xxl">
            <!-- header rightbar icon -->
            <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">

                <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center zindex-popover">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm"><span class="font-weight-bold">{{ session('admin_username', 'admin@ceutrainers.com') }}</span></p>
                        <small>Admin Profile</small>
                    </div>
                    <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                        <img class="avatar lg rounded-circle img-thumbnail" src="{{ asset('ceuadmin-assets/assets/images/profile_av.svg') }}" alt="profile">
                    </a>
                    <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                        <div class="card border-0 w280">
                            <div class="card-body pb-0">
                                <div class="d-flex py-1">
                                    <img class="avatar rounded-circle" src="{{ asset('ceuadmin-assets/assets/images/profile_av.svg') }}" alt="profile">
                                    <div class="flex-fill ms-3">
                                        <p class="mb-0"><span class="font-weight-bold">{{ session('admin_company', 'CEUTrainers Admin') }}</span></p>
                                        <small class="">{{ session('admin_username', 'admin@ceutrainers.com') }}</small>
                                    </div>
                                </div>
                                <div><hr class="dropdown-divider border-dark"></div>
                            </div>
                            <div class="list-group m-2">
                                <a href="{{ route('admin.page', 'admin-profile') }}" class="list-group-item list-group-item-action border-0"><i class="icofont-ui-user fs-5 me-3"></i>Profile Page</a>
                                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="list-group-item list-group-item-action border-0 text-start w-100"><i class="icofont-logout fs-5 me-3"></i>Signout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="setting ms-2">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#Settingmodal"><i class="icofont-gear-alt fs-5"></i></a>
                </div>
            </div>

            <!-- menu toggler -->
            <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                <span class="fa fa-bars"></span>
            </button>

            <!-- main menu Search-->
            <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0">
                <div class="input-group flex-nowrap input-group-lg">
                    <input type="search" class="form-control" placeholder="Search" aria-label="search" aria-describedby="addon-wrapping">
                    <button type="button" class="input-group-text" id="addon-wrapping"><i class="fa fa-search"></i></button>
                </div>
            </div>

        </div>
    </nav>
</div>

<!-- Modal Custom Settings-->
<div class="modal fade right" id="Settingmodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Custom Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body custom_setting">
                <!-- Settings: Color -->
                <div class="setting-theme pb-3">
                    <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-color-bucket fs-4 me-2 text-primary"></i>Template Color Settings</h6>
                    <ul class="list-unstyled row row-cols-3 g-2 choose-skin mb-2 mt-2">
                        <li data-theme="indigo"><div class="indigo"></div></li>
                        <li data-theme="tradewind"><div class="tradewind"></div></li>
                        <li data-theme="monalisa"><div class="monalisa"></div></li>
                        <li data-theme="blue" class="active"><div class="blue"></div></li>
                        <li data-theme="cyan"><div class="cyan"></div></li>
                        <li data-theme="green"><div class="green"></div></li>
                        <li data-theme="orange"><div class="orange"></div></li>
                        <li data-theme="blush"><div class="blush"></div></li>
                        <li data-theme="red"><div class="red"></div></li>
                    </ul>
                </div>
                <div class="sidebar-gradient py-3">
                    <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-paint fs-4 me-2 text-primary"></i>Sidebar Gradient</h6>
                    <div class="form-check form-switch gradient-switch pt-2 mb-2">
                        <input class="form-check-input" type="checkbox" id="CheckGradient">
                        <label class="form-check-label" for="CheckGradient">Enable Gradient! ( Sidebar )</label>
                    </div>
                </div>
                <!-- Settings: Light/dark -->
                <div class="setting-mode py-3">
                    <h6 class="card-title mb-2 fs-6 d-flex align-items-center"><i class="icofont-layout fs-4 me-2 text-primary"></i>Contrast Layout</h6>
                    <ul class="list-group list-unstyled mb-0 mt-1">
                        <li class="list-group-item d-flex align-items-center py-1 px-2">
                            <div class="form-check form-switch theme-switch mb-0">
                                <input class="form-check-input" type="checkbox" id="theme-switch">
                                <label class="form-check-label" for="theme-switch">Enable Dark Mode!</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer justify-content-start">
                <button type="button" class="btn btn-white border lift" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
