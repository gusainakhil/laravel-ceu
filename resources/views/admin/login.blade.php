<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>CEUTrainers | Signin</title>
    <link rel="icon" href="{{ asset('ceuadmin/favicon.png') }}" type="image/x-icon">
    
    <!-- Sweetalet2 and project styling -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('ceuadmin-assets/assets/css/ceu.style.min.css') }}">
</head>
<body>
    <div id="ebazar-layout" class="theme-blue">
        <!-- Main body area -->
        <div class="main p-2 py-3 p-xl-5">
            <!-- Body: Body -->
            <div class="body d-flex p-0 p-xl-5">
                <div class="container-xxl">
                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                            <div style="max-width: 25rem;">
                                <div class="mb-5">
                                    <h2 class="color-900 text-center">A few clicks is all it takes.</h2>
                                </div>
                                <div>
                                    <img src="{{ asset('ceuadmin-assets/assets/images/login-img.svg') }}" alt="login-img">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
                                <!-- Form -->
                                <form class="row g-1 p-3 p-md-4" method="POST" action="/ceuadmin/login">
                                    @csrf
                                    <div class="col-12 text-center mb-5">
                                        <h1>Sign in</h1>
                                        <span>Free access to our dashboard.</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Username</label>
                                            <input type="text" name="username" class="form-control form-control-lg" placeholder="name@example.com" value="admin@ceutrainers.com" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <div class="form-label">
                                                <span class="d-flex justify-content-between align-items-center">
                                                    Password
                                                </span>
                                            </div>
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="***************" value="admin123" required>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <button type="submit" class="btn btn-lg btn-block btn-primary lift text-uppercase">SIGN IN</button>
                                    </div>
                                </form>
                                <!-- End Form -->
                            </div>
                        </div>
                    </div> <!-- End Row -->
                </div>
            </div>
        </div>
    </div>
    
    <!-- Jquery Core Js -->
    <script src="{{ asset('ceuadmin-assets/assets/bundles/libscripts.bundle.js') }}"></script>
    <script src="{{ asset('ceuadmin-assets/assets/js/template.js') }}"></script>
</body>
</html>
