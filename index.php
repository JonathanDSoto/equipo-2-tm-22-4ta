<?php
	include_once "app/config.php";

    if(isset($_SESSION['token'])){
    	header('location: '.BASE_PATH.'products');
	}
?> 

<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">
<head>
    <title>Sign In</title>
    <?php include "layout/head.template.php" ?>

</head>

<body>
    <div class="auth-page-wrapper auth-bg-cover py-5 d-flex justify-content-center align-items-center min-vh-100">
    <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row justify-content-center" id="auth-particles"> 
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue.</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form method="post" action="<?= BASE_PATH ?>auth" class="form">

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email" pattern="(?!(^[.-].*|[^@]*[.-]@|.*\.{2,}.*)|^.{254}.)([a-zA-Z0-9!#$%&'*+\/=?^_`{|}~.-]+@)(?!-.*|.*-\.)([a-zA-Z0-9-]{1,63}\.)+[a-zA-Z]{2,15}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password" >Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" placeholder="Enter password" id="password" name="password" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted shadow-none password-addon" type="submit" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <input type="hidden" name="accion" value="access">
                                            <input type="hidden" name="global_token" value="<?= $_SESSION['global_token'] ?>" >
                                            <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->
    </div>
    <!-- end auth-page-wrapper -->

    <?php include "layout/scripts.template.php" ?>
</body>
</html>